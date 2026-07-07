<?php

class Adjustment extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $adjustmentHeader = AdjustmentHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($adjustmentHeader !== null)
            $this->header->setCodeNumber($adjustmentHeader->cn_ordinal, $adjustmentHeader->cn_month, $adjustmentHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetail($id) {
        $product = Product::model()->findByPk($id);

        if ($product !== null) {
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($product->id === $detail->product_id) {
                    $exist = true;
                    break;
                }
            }

            if ($exist)
                $this->details[$i]->quantity_adjustment++;
            else {
                $detail = new AdjustmentDetail();
                $detail->product_id = $product->id;
                $this->details[] = $detail;
            }
        }
    }

    public function removeProductAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function updateProducts() {
        foreach ($this->details as $detail)
            $detail->quantity_current = $detail->getCurrentStock($this->header->warehouse_id);
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity_current', 'quantity_adjustment', 'product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else
            $valid = false;

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);
        foreach ($this->details as $detail) {
            if ($detail->quantity_adjustment <= 0)
                continue;

            if ($detail->isNewRecord)
                $detail->adjustment_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;

            Inventory::model()->deleteAllByAttributes(array(
                'transaction_ordinal' => $this->header->cn_ordinal,
                'transaction_month' => $this->header->cn_month,
                'transaction_year' => $this->header->cn_year,
                'product_id' => $detail->product_id,
                'transaction_type' => 5,
            ));

            $inventory = new Inventory();
            $inventory->transaction_ordinal = $this->header->cn_ordinal;
            $inventory->transaction_month = $this->header->cn_month;
            $inventory->transaction_year = $this->header->cn_year;
            $inventory->transaction_type = 5;
            $inventory->transaction_subject = 'adjustment';
            $inventory->product_id = $detail->product_id;
            $inventory->admin_id = $this->header->admin_id;
            $inventory->date = $this->header->date;
            $inventory->quantity_in = $detail->quantity_adjustment - $detail->quantity_current;
            $inventory->warehouse_id = $this->header->warehouse_id;

            $valid = $inventory->save(false) && $valid;
        }

        return $valid;
    }
}
