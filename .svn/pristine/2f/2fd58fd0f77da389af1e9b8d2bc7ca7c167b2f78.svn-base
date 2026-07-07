<?php

class PurchaseItem extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $purchaseItemHeader = PurchaseItemHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($purchaseItemHeader !== null)
            $this->header->setCodeNumber($purchaseItemHeader->cn_ordinal, $purchaseItemHeader->cn_month, $purchaseItemHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetail($id) {
        $item = Item::model()->findByPk($id);

        if ($item !== null) {
            $detail = new PurchaseItemDetail();
            $detail->item_id = $item->id;
            $this->details[] = $detail;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
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

    public function validate() {
        $valid = $this->header->validate();

        if (!$valid)
            $this->header->addError('error', 'Header Error');
        else {
            $valid = $this->validateDetailsCount() && $valid;
            if (!$valid)
                $this->header->addError('error', 'Validate Details Count Error');
            else {
                //validate details
                if (count($this->details) > 0) {
                    foreach ($this->details as $detail) {
                        $fields = array('quantity', 'unit_price');
                        $valid = $detail->validate($fields) && $valid;
                    }
                }
                else
                    $valid = false;
            }
        }

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

    public function flush() {
        //save header
        $valid = $this->header->save(false);

        //save details
        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0) {
                continue;
            }

            if ($detail->isNewRecord){
                $detail->purchase_item_header_id = $this->header->id;
            }
            
            $receiveItemDetail = ReceiveItemDetail::model()->findAllByAttributes(array('purchase_item_detail_id' => $detail->id, 'is_inactive' => 0));
            if ((int)$detail->is_inactive === 1 && !empty($receiveItemDetail)) {
                continue;
            }

            $valid = $detail->save(false) && $valid;
        }

        return $valid;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            if ((int)$detail->is_inactive == 0) {
                $total += $detail->total;
            }
        }

        return $total;
    }

    public function getTotalBeforeTax() {
        return $this->getSubTotal() - $this->header->discount;
    }

    public function getCalculatedTax() {
//        return ((int)$this->header->is_tax == 1) ?  $this->getTotalBeforeTax() * $this->header->tax_percentage / 100 : 0.00;
        return $this->getTotalBeforeTax() * $this->header->tax_percentage / 100;
    }

    public function getCalculatedTaxIncome() {
        return ((int)$this->header->is_tax_income === 1) ? $this->getTotalBeforeTax() * .02 : 0.00;
    }

    public function getGrandTotal() {
        return $this->getTotalBeforeTax() + $this->getCalculatedTax() + $this->getCalculatedTaxIncome();
    }

}
