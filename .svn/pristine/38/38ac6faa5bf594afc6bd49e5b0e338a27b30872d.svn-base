<?php

class AccountCategory extends AccountCategoryBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
        
        public function getBalanceTotal($startDate, $endDate)
	{
		$balanceTotal = 0.00;

		foreach ($this->accounts as $account)
			$balanceTotal += $account->getBalanceTotal($startDate, $endDate);

		return $balanceTotal;
	}
}