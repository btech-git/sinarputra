<?php

class DeliveryBackup extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $deliveryBackupHeader = DeliveryBackupHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($deliveryBackupHeader !== null) {
            $this->header->setCodeNumber($deliveryBackupHeader->cn_ordinal, $deliveryBackupHeader->cn_month, $deliveryBackupHeader->cn_year);
        }

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('length', 'width', 'height', 'weight', 'quantity');
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
        $valid = $this->header->save(false);
        
        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $detail->delivery_backup_header_id = $this->header->id;
            }
            
            $valid = $detail->save(false) && $valid;
        }

        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;
            if ($details != NULL) {
                foreach ($details as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $valid = $valid && $detail->update(array('is_inactive'));
                }
            }

            $this->header->is_inactive = ActiveRecord::INACTIVE;
            $valid = $valid && $this->header->update(array('is_inactive'));
        
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollBack();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
        }

        return $valid;
    }
}