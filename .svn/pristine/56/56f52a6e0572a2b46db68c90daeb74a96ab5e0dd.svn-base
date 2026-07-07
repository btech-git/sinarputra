<?php

class ProductionPlanningMilingDetail extends ProductionPlanningMilingDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function searchForProductionMiling() {
        $dataProvider = $this->search();
        $dataProvider->criteria->addCondition("EXISTS (
            SELECT pp.quantity - COALESCE(SUM(pr.quantity), 0) AS quantity_remaining, 
            pp.id AS work_order_cutting_detail_id
            FROM " . ProductionPlanningMilingDetail::model()->tableName() . " pp
            LEFT OUTER JOIN " . ProductionMilingDetail::model()->tableName() . " pr
            ON pp.id = pr.work_order_cutting_detail_id
            WHERE t.id = pp.id AND t.is_inactive = 0
            GROUP BY pp.id
            HAVING quantity_remaining > 0
        )");
        $dataProvider->criteria->compare('t.is_inactive', 0);

        return $dataProvider;
    }

    public function getTotalQuantityMilingProduction() {
        $total = 0;

        foreach ($this->productionMilingDetails as $detail)
            $total += $detail->quantity;

        return $total;
    }

    public function getQuantityMilingProductionRemaining() {

        return $this->quantity - $this->totalQuantityMilingProduction;
    }

}