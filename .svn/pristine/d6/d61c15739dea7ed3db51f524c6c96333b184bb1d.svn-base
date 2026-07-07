<?php

class ReceiveItem extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $receiveItemHeader = ReceiveItemHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($receiveItemHeader !== null)
            $this->header->setCodeNumber($receiveItemHeader->cn_ordinal, $receiveItemHeader->cn_month, $receiveItemHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetailByPurchaseItem($id) {
        $sql = SqlViewGenerator::purchaseItemQuantityRemaining() . "
            WHERE p.purchase_item_header_id = :purchase_item_header_id AND is_inactive = 0
            HAVING quantity_purchased > 0
            ORDER BY p.id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':purchase_item_header_id' => $id));

        $this->details = array(); //reset detail

        foreach ($resultSet as $row) {

            $purchaseItemDetail = PurchaseItemDetail::model()->findByPk($row['purchase_item_detail_id']);

            $detail = new ReceiveItemDetail();
            $detail->purchase_item_detail_id = $purchaseItemDetail->id;
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
                $fields = array('purchase_item_detail_id', 'quantity');
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
        //save header
        $valid = $this->header->save(false);

        //save details
        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;

            if ($detail->isNewRecord)
                $detail->receive_item_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
        }

        return $valid;
    }

}
