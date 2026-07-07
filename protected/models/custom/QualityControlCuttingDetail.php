<?php

class QualityControlCuttingDetail extends QualityControlCuttingDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getQuantityRemaining() {
        return $this->workOrderCuttingDetail->quantity - $this->quantity;
    }

    public function getWeightDetail() {
        return $this->quantity * ($this->workOrderCuttingDetail->weight / $this->workOrderCuttingDetail->quantity);
    }
}
