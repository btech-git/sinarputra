<?php

/**
 * @property integer $id
 * @property string $debit
 * @property string $credit
 * @property string $memo
 * @property integer $account_id
 * @property integer $adjustment_journal_header_id
 * @property integer $is_inactive
 *
 * @property AdjustmentJournalHeader $adjustmentJournalHeader
 * @property Account $account
 */
class AdjustmentJournalDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_adjustment_journal_detail';
	}

	public function rules()
	{
		return array(
			array('account_id, adjustment_journal_header_id', 'required'),
			array('account_id, adjustment_journal_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('debit, credit', 'length', 'max'=>18),
			array('memo', 'safe'),
			// The following rule is used by search().
			array('id, debit, credit, memo, account_id, adjustment_journal_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'adjustmentJournalHeader' => array(self::BELONGS_TO, 'AdjustmentJournalHeader', 'adjustment_journal_header_id'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'memo' => 'Memo',
			'account_id' => 'Account',
			'adjustment_journal_header_id' => 'Adjustment Journal Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.debit', $this->debit, true);
		$criteria->compare('t.credit', $this->credit, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.account_id', $this->account_id);
		$criteria->compare('t.adjustment_journal_header_id', $this->adjustment_journal_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
