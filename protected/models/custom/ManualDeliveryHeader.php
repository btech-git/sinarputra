<?php

class ManualDeliveryHeader extends ManualDeliveryHeaderBase
{
    const CN_CONSTANT = 'SJM';

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getTotalQuantity() {
        $total = 0;
        
        foreach($this->manualDeliveryDetails as $detail) {
            if ($detail->is_inactive == 0)
                $total += $detail->quantity;
        }
        
        return $total;
    }
    
    public function getTotalWeight() {
        $total = 0;
        
        foreach($this->manualDeliveryDetails as $detail) {
            if ($detail->is_inactive == 0)
                $total += $detail->weight;
        }
        
        return $total;
    }
}