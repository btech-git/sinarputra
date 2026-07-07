<?php

class ProductionCuttingDetail extends ProductionCuttingDetailBase {

    public $productionPlanningQuantity;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalQuantityCuttingControl() {
        $total = 0;

        foreach ($this->qualityControlCuttingDetails as $detail) {
            $total += $detail->quantity;
        }

        return $total;
    }

    public function getQuantityCuttingControlRemaining() {

        return $this->quantity - $this->quantity_quality_control;
    }

}
