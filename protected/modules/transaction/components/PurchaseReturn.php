<?php

class PurchaseReturn extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $purchaseReturnHeader = PurchaseReturnHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($purchaseReturnHeader !== null)
            $this->header->setCodeNumber($purchaseReturnHeader->cn_ordinal, $purchaseReturnHeader->cn_month, $purchaseReturnHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetailByReceive($id) {
        $this->details = array(); //reset detail

        $receiveHeader = ReceiveHeader::model()->findByPk($id);

        foreach ($receiveHeader->receiveDetails as $receiveDetail) {
            $detail = new PurchaseReturnDetail();
            $detail->receive_detail_id = $receiveDetail->id;

            if ($receiveDetail->purchase_detail_id != null)
                $detail->unit_price = $receiveDetail->purchaseDetail->unit_price;
            else
                $detail->unit_price = $receiveDetail->product->selling_price;
            $this->details[] = $detail;
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
                $fields = array('quantity', 'unit_price', 'receive_detail_id');
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

    public function validateDetailsUnique() {          //returns true if details are unique
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

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
                $detail->purchase_return_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;

            if ($detail->receiveDetail->product_name != null) {
                Inventory::model()->deleteAllByAttributes(array(
                    'transaction_ordinal' => $this->header->cn_ordinal,
                    'transaction_month' => $this->header->cn_month,
                    'transaction_year' => $this->header->cn_year,
//				'product_id' => $detail->product_id,
                    'transaction_type' => 2,
                ));

                $inventory = new Inventory();
                $inventory->transaction_ordinal = $this->header->cn_ordinal;
                $inventory->transaction_month = $this->header->cn_month;
                $inventory->transaction_year = $this->header->cn_year;
                $inventory->transaction_type = 2;
                $inventory->transaction_subject = "RETUR " . $this->header->receiveHeader->purchaseHeader->supplier->company;
//                $inventory->product_id = $detail->receiveDetail->product_id;
                 $inventory->product_name = $detail->receiveDetail->product_name;
                $inventory->admin_id = $this->header->admin_id;
                $inventory->date = $this->header->date;
                $inventory->quantity_out = $detail->quantity;
                $inventory->warehouse_id = 1;

                $valid = $inventory->save(false) && $valid;
            }
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
