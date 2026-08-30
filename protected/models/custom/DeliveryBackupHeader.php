<?php

class DeliveryBackupHeader extends DeliveryBackupHeaderBase {

    const CN_CONSTANT = 'DBU';
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalQuantity() {
        $total = '0.00';

        foreach ($this->deliveryBackupDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }

    public function getTotalWeight() {
        $total = '0.00';

        foreach ($this->deliveryBackupDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->weight;
            }
        }

        return $total;
    }
}