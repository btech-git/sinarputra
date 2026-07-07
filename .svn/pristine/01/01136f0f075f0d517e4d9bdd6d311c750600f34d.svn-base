<?php

class QuotationReturnDetail extends QuotationReturnDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getTotal()
	{
		return $this->quantity * $this->unit_price;
	}
}