<?php

/**
 * @property integer $id
 * @property string $transaction_number
 * @property string $date
 * @property integer $transaction_type
 * @property string $transaction_subject
 * @property string $note
 * @property string $debit
 * @property string $credit
 * @property integer $account_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property Account $account
 * @property Admin $admin
 */
class JournalAccountingBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_journal_accounting';
	}

	public function rules()
	{
		return array(
			array('transaction_number, date, transaction_subject, admin_id', 'required'),
			array('transaction_type, account_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('transaction_number, transaction_subject', 'length', 'max'=>60),
			array('debit, credit', 'length', 'max'=>18),
			array('note', 'safe'),
			// The following rule is used by search().
			array('id, transaction_number, date, transaction_type, transaction_subject, note, debit, credit, account_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_number' => 'Transaction Number',
			'date' => 'Date',
			'transaction_type' => 'Transaction Type',
			'transaction_subject' => 'Transaction Subject',
			'note' => 'Note',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'account_id' => 'Account',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.transaction_number', $this->transaction_number, true);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('t.transaction_type', $this->transaction_type);
		$criteria->compare('t.transaction_subject', $this->transaction_subject, true);
		$criteria->compare('t.note', $this->note, true);
		$criteria->compare('t.debit', $this->debit, true);
		$criteria->compare('t.credit', $this->credit, true);
		$criteria->compare('t.account_id', $this->account_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
