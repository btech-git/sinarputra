<?php

class QualityControlMilingDetail extends QualityControlMilingDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getMilingStatus() {
        return ((int)$this->is_miling == 1) ? "Yes" : "";
    }
    public function getSidemilStatus() {
        return ((int)$this->is_sidemiling == 1) ? "Yes" : "";
    }
    public function getGrindingStatus() {
        return ((int)$this->is_grinding == 1) ? "Yes" : "";
    }
    public function getHardenessStatus() {
        return ((int)$this->is_hardness == 1) ? "Yes" : "";
    }
    public function getAnnelyingStatus() {
        return ((int)$this->is_annelying == 1) ? "Yes" : "";
    }
    
    public function getQuantityRemaining() {
        return $this->workOrderCuttingDetail->quantity - $this->quantity;
    }
}