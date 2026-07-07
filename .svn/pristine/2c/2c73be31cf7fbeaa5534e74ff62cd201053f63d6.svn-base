<?php

class ProductionPlanningCuttingDetail extends ProductionPlanningCuttingDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getTotalQuantityCuttingProduction() {
        $total = 0;

        foreach ($this->productionCuttingDetails as $detail)
            $total += $detail->quantity;

        return $total;
    }

    public function getQuantityCuttingProductionRemaining() {

        return $this->quantity - $this->totalQuantityCuttingProduction;
    }
}