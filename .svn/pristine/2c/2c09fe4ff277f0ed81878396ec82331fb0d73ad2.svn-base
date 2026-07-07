<?php

class QuotationReturn extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $quotationReturnHeader = QuotationReturnHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($quotationReturnHeader !== null)
            $this->header->setCodeNumber($quotationReturnHeader->cn_ordinal, $quotationReturnHeader->cn_month, $quotationReturnHeader->cn_year);

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

            if (!$exist) {
                $detail = new QuotationReturnDetail();
                $detail->product_id = $product->id;
                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->product_id === $this->details[$j]->product_id) {
                    $valid = false;
                    $this->header->addError('error', 'Detail pengiriman tidak boleh sama.');
                    break;
                }
            }
        }

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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);
        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;
            if ($detail->isNewRecord)
                $detail->quotation_return_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;

            Inventory::model()->deleteAllByAttributes(array(
                'transaction_ordinal' => $this->header->cn_ordinal,
                'transaction_month' => $this->header->cn_month,
                'transaction_year' => $this->header->cn_year,
                'product_id' => $detail->product_id,
                'transaction_type' => 4,
            ));

            $inventory = new Inventory();
            $inventory->transaction_ordinal = $this->header->cn_ordinal;
            $inventory->transaction_month = $this->header->cn_month;
            $inventory->transaction_year = $this->header->cn_year;
            $inventory->transaction_type = 4;
            $inventory->transaction_subject = "RETUR" . $this->header->customer->company;
            $inventory->product_id = $detail->product_id;
            $inventory->admin_id = $this->header->admin_id;
            $inventory->date = $this->header->date;
            $inventory->quantity_in = $detail->quantity;
            $inventory->warehouse_id = 1;

            $valid = $inventory->save(false) && $valid;
        }

        return $valid;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->total;

        return $total;
    }

}
