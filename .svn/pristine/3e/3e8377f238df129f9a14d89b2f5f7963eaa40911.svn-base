<?php

class Supplier extends SupplierBase
{
	const NO_TAX = 0;
	const FULL_TAX = 1;
	const NO_TAX_LITERAL = 'Tanpa PPn';
	const FULL_TAX_LITERAL = 'Dengan PPn';
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
	public function getTaxStatus()
	{
		return ($this->is_tax) ? self::FULL_TAX_LITERAL : self::NO_TAX_LITERAL;
	}

}