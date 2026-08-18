<?php

class WorkOrderCuttingDetail extends WorkOrderCuttingDetailBase {
    const NON_DELIVERY = 0;
    const DELIVERY = 1;

    const NOT_URGENT = 0;
    const URGENT = 1;
    
    const INTERNAL_ORDER = 0;
    const EXTERNAL_ORDER = 1;

    const IS_UNCUT = 0;
    const IS_CUT = 1;

    const NON_DELIVERY_LITERAL = 'N/A';
    const DELIVERY_LITERAL = 'KRM';

    const NOT_URGENT_LITERAL = 'Not Urgent';
    const URGENT_LITERAL = 'Urgent';

    const INTERNAL_ORDER_LITERAL = 'N/A';
    const EXTERNAL_ORDER_LITERAL = 'Order Luar';
    
    const IS_UNCUT_LITERAL = 'N/A';
    const IS_CUT_LITERAL = 'Potong';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUrgentStatus() {
        return ($this->is_urgent) ? self::URGENT_LITERAL : self::NOT_URGENT_LITERAL;
    }

    public function getDeliveryStatus() {
        return ($this->is_delivery) ? self::DELIVERY_LITERAL : self::NON_DELIVERY_LITERAL;
    }

    public function getExternalOrderStatus() {
        return ($this->is_external_order) ? self::EXTERNAL_ORDER_LITERAL : self::INTERNAL_ORDER_LITERAL;
    }

    public function getCuttingStatus() {
        return ($this->is_cut) ? self::IS_CUT_LITERAL : self::IS_UNCUT_LITERAL;
    }
    
    public function getWorkOrderStatus() {
        if ($this->is_external_order) {
            return $this->getExternalOrderStatus();
        } elseif ($this->saleDetail->quotation_detail_product_id === NULL) {
            return 'Jasa Potong';
        } elseif ($this->is_delivery) {
            return $this->getDeliveryStatus();
        } else {
            return $this->getCuttingStatus();
        }
    }

    public function searchForProductionPlanningMiling() {
        $dataProvider = $this->search();
        $dataProvider->criteria->addCondition("t.id NOT IN (
            SELECT work_order_cutting_detail_id 
            FROM " . ProductionPlanningMilingDetail::model()->tableName() . "
        ) AND (t.is_miling = 1 OR t.is_sidemiling = 1 OR t.is_grinding = 1)");
        $dataProvider->criteria->compare('t.is_inactive', 0);

        return $dataProvider;
    }

    public function searchForPurchase() {
        $dataProvider = $this->search();
        $dataProvider->criteria->addCondition("t.id NOT IN (
            SELECT work_order_cutting_detail_id 
            FROM " . PurchaseDetail::model()->tableName() . " purchase
            WHERE purchase.is_inactive = 0 AND t.id = work_order_cutting_detail_id
        )");
        $dataProvider->criteria->compare('t.is_inactive', 0);
        $dataProvider->criteria->compare('t.is_external_order', 1);

        return $dataProvider;
    }

    public function getTotalQuantityCuttingQualityControl() {
        $total = 0;

        foreach ($this->qualityControlCuttingDetails as $detail) {
            $total += $detail->quantity;
        }

        return $total;
    }

    public function getQuantityCuttingQualityControlRemaining() {

        return $this->quantity - $this->totalQuantityCuttingQualityControl;
    }
    
    public function getTotalQuantityMilingQualityControl() {
        $total = 0;

        foreach ($this->qualityControlMilingDetails as $detail) {
            $total += $detail->quantity;
        }

        return $total;
    }

    public function getQuantityMilingQualityControlRemaining() {

        return $this->quantity - $this->totalQuantityMilingQualityControl;
    }
    
    public function getTotalQuantityProductionPlanningCutting() {
        $total = 0;

        foreach ($this->productionPlanningCuttingDetails as $detail) {
            $total += $detail->quantity;
        }

        return $total;
    }

    public function getQuantityProductionPlanningCuttingRemaining() {

        return $this->quantity - $this->totalQuantityProductionPlanningCutting;
    }

    public function getAccumulatedQuantityDelivery() {
        $total = 0;
        
        foreach($this->manualDeliveryDetails as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }
}