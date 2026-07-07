<?php

class Receive extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $receiveHeader = ReceiveHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($receiveHeader !== null) {
            $this->header->setCodeNumber($receiveHeader->cn_ordinal, $receiveHeader->cn_month, $receiveHeader->cn_year);
        }

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function generateSerialNumber($categoryId) {
        $serialNumber = Yii::app()->db->createCommand()
            ->select('serial_number')
            ->from('tblsp_receive_detail')
            ->where('product_category_id = :categoryId', array(':categoryId' => $categoryId))
            ->order('id DESC')
            ->queryRow();

        if ($serialNumber != null) {
            return $serialNumber['serial_number'] + 1;
        } else {
            return 1;
        }
    }

    public function addDetailByPurchase($id) {
        $sql = SqlViewGenerator::purchaseQuantityRemaining() . "
            WHERE p.purchase_header_id = :purchase_header_id AND p.is_inactive = 0
            HAVING quantity_purchased > 0
            ORDER BY p.id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':purchase_header_id' => $id));

        $this->details = array(); //reset detail

        foreach ($resultSet as $row) {
            $detailsCount = $row['quantity_purchased'];

            $purchaseDetail = PurchaseDetail::model()->findByPk($row['purchase_detail_id']);

            for ($i = 1; $i <= $detailsCount; $i++) {
                $detail = new ReceiveDetail();
                $detail->product_name = $purchaseDetail->product_name;
                $detail->product_category_id = $purchaseDetail->product_category_id;
                $detail->purchase_detail_id = $purchaseDetail->id;
                $detail->weight = round($purchaseDetail->weight / $purchaseDetail->quantity, 2);
                $detail->height = $purchaseDetail->height;
                $detail->width = $purchaseDetail->width;
                $detail->length = $purchaseDetail->length;
                $this->details[] = $detail;
            }
        }

    }

    public function addDetail($id) {
        $productSize = ProductSize::model()->findByPk($id);

        if ($productSize !== null) {
            $detail = new ReceiveDetail();
            $detail->width = $productSize->width;
            $detail->height = $productSize->height;
            $detail->product_id = $productSize->product_id;
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
                $fields = array('length', 'width', 'height', 'purchase_detail_id', 'weight', 'location_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j) {
                    continue;
                }
            }
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function flush() {
        if ($this->header->receiving_type == 1) {
            $purchaseHeader = PurchaseHeader::model()->findByPk($this->header->purchase_header_id);
            $this->header->supplier_id = $purchaseHeader->supplier_id;
        } else if ($this->header->receiving_type == 2) {
            $this->header->purchase_header_id = null;
        }
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $serialNumber = $this->generateSerialNumber($detail->product_category_id);

                $detail->serial_number = $serialNumber;
                $serialNumber++;

                $detail->receive_header_id = $this->header->id;
            }

            $valid = $detail->save(false) && $valid;
        }

        return $valid;
    }

    public function getPurchaseHeaderNumber($receive) {
        $cnOrdinal = $receive->receiveDetails[0]->purchaseDetail->purchaseHeader->cn_ordinal;
        $cnMonth = $receive->receiveDetails[0]->purchaseDetail->purchaseHeader->cn_month;
        $cnYear = $receive->receiveDetails[0]->purchaseDetail->purchaseHeader->cn_year;

        $purchase = new PurchaseHeader();
        $purchase->setCodeNumber($cnOrdinal, $cnMonth, $cnYear);
        $purchaseNumber = $purchase->getCodeNumber(PurchaseHeader::CN_CONSTANT);

        return $purchaseNumber;
    }

}
