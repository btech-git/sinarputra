<?php

class AccountingJournalHelper extends CComponent
{
	const PURCHASE_INVOICE = 1;
	const PURCHASE_PAYMENT = 2;
	const SALE_INVOICE = 3;
	const SALE_PAYMENT = 4;
	const DEPOSIT = 5;
	const EXPENSE = 6;
	const ADJUSTMENT = 7;

	public static function make($type, $transactionNumber, $transactionType, $accountId, $total, $transactionSubject, $transactionNote, $transactionDate, $transactionAdmin)
	{
		$accountingJournal = new JournalAccounting();
		$accountingJournal->transaction_number = $transactionNumber;
		$accountingJournal->transaction_type = $transactionType;
		$accountingJournal->transaction_subject = $transactionSubject;
		$accountingJournal->note = $transactionNote;
		$accountingJournal->account_id = $accountId;
		$accountingJournal->date = $transactionDate; 
		$accountingJournal->admin_id = $transactionAdmin;

		$accountingJournal->$type = $total;

		return $accountingJournal;
	}
}