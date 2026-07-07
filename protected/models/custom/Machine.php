<?php

class Machine extends MachineBase
{
	const CUTTING = 1;
	const MILLING = 2;
	const EXTERNAL_ORDER = 3;
	const CUTTING_LITERAL = 'Cutting';
	const MILLING_LITERAL = 'Miling';
	const EXTERNAL_ORDER_LITERAL = 'Order Luar';

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getMachineType()
	{
		if (int($this->machine_type) === self::CUTTING)
			return self::CUTTING_LITERAL;
		elseif (int($this->machine_type) === self::MILLING)
			return self::MILLING_LITERAL;
		elseif (int($this->machine_type) === self::EXTERNAL_ORDER)
			return self::EXTERNAL_ORDER_LITERAL;
		else
			return '';
	}
	
	public function getFullSpecification()
	{
		return $this->serial_number . " - " . $this->name;
	}
}