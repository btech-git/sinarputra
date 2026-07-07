<?php

class Account extends AccountBase
{

	public $accountBalance;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function getBeginningBalance($accountId, $startDate)
	{
		$sql = SqlGenerator::beginningBalance();

		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
			':account_id' => $accountId,
			':start_date' => $startDate,
			));

		return ($value === false) ? 0 : $value;
	}

	public function getEndingBalance($accountId, $endDate)
	{
		$sql = SqlGenerator::endingBalance();

		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
			':account_id' => $accountId,
			':end_date' => $endDate,
			));

		return ($value === false) ? 0 : $value;
	}

	public function getBalanceTotal($startDate, $endDate)
	{
		$balanceTotal = 0.00;

		$accountingJournals = $this->getRelated('journalAccountings', false, array(
			'condition' => "date >= :startDate AND  date <= :endDate",
			'params' => array(
				':startDate' => $startDate,
				':endDate' => $endDate,
			),
			));

		if ($accountingJournals != null)
		{

			foreach ($accountingJournals as $accountingJournal)
				$balanceTotal += $accountingJournal->credit - $accountingJournal->debit;
		}

		return $balanceTotal;
	}

	public function getBeginningBalanceLedger($accountId, $startDate)
	{
		$sql = SqlGenerator::beginningBalanceLedger();

		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
			':account_id' => $accountId,
			':start_date' => $startDate,
			));

		$this->accountBalance = $value;

		return ($value === false) ? 0 : $value;
	}

	public function getEndBalanceLedger($accountId, $endDate)
	{
		$sql = SqlGenerator::endBalanceLedger();

		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
			':account_id' => $accountId,
			':end_date' => $endDate,
			));

		$this->accountBalance = $value;

		return ($value === false) ? 0 : $value;
	}

	public function getEndDebitLedger($accountId, $startDate, $endDate)
	{
		$sql = SqlGenerator::endDebitLedger();

		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
			':account_id' => $accountId,
			':end_date' => $endDate,
			':start_date' => $startDate,
			));

		return ($value === false) ? 0 : $value;
	}

	public function getEndCreditLedger($accountId, $startDate, $endDate)
	{
		$sql = SqlGenerator::endCreditLedger();

		$value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
			':account_id' => $accountId,
			':end_date' => $endDate,
			':start_date' => $startDate,
			));

		return ($value === false) ? 0 : $value;
	}

}