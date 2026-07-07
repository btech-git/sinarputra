<?php

class ReceiveItemDetail extends ReceiveItemDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
        
        public function getTotal() {
		return $this->quantity * $this->purchaseItemDetail->unit_price;
	}
}