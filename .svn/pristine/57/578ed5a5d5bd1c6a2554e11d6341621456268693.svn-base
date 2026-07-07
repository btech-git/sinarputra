<?php

/**
 * @property integer $id
 * @property string $amount
 * @property string $income_tax
 * @property string $memo
 * @property string $additional_payment_1
 * @property string $additional_payment_2
 * @property integer $account_id_additional_payment_1
 * @property integer $account_id_additional_payment_2
 * @property integer $sale_payment_header_id
 * @property integer $sale_invoice_header_id
 * @property integer $account_id
 * @property integer $payment_type_id
 * @property integer $is_inactive
 *
 * @property Account $accountIdAdditionalPayment2
 * @property Account $account
 * @property PaymentType $paymentType
 * @property SalePaymentHeader $salePaymentHeader
 * @property SaleInvoiceHeader $saleInvoiceHeader
 * @property Account $accountIdAdditionalPayment1
 */
class SalePaymentDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_sale_payment_detail';
	}

	public function rules()
	{
		return array(
			array('sale_payment_header_id, sale_invoice_header_id, account_id, payment_type_id', 'required'),
			array('account_id_additional_payment_1, account_id_additional_payment_2, sale_payment_header_id, sale_invoice_header_id, account_id, payment_type_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('amount, additional_payment_1, additional_payment_2', 'length', 'max'=>18),
			array('income_tax', 'length', 'max'=>10),
			array('memo', 'safe'),
			// The following rule is used by search().
			array('id, amount, income_tax, memo, additional_payment_1, additional_payment_2, account_id_additional_payment_1, account_id_additional_payment_2, sale_payment_header_id, sale_invoice_header_id, account_id, payment_type_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'accountIdAdditionalPayment2' => array(self::BELONGS_TO, 'Account', 'account_id_additional_payment_2'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
			'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
			'salePaymentHeader' => array(self::BELONGS_TO, 'SalePaymentHeader', 'sale_payment_header_id'),
			'saleInvoiceHeader' => array(self::BELONGS_TO, 'SaleInvoiceHeader', 'sale_invoice_header_id'),
			'accountIdAdditionalPayment1' => array(self::BELONGS_TO, 'Account', 'account_id_additional_payment_1'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'income_tax' => 'Income Tax',
			'memo' => 'Memo',
			'additional_payment_1' => 'Additional Payment 1',
			'additional_payment_2' => 'Additional Payment 2',
			'account_id_additional_payment_1' => 'Account Id Additional Payment 1',
			'account_id_additional_payment_2' => 'Account Id Additional Payment 2',
			'sale_payment_header_id' => 'Sale Payment Header',
			'sale_invoice_header_id' => 'Sale Invoice Header',
			'account_id' => 'Account',
			'payment_type_id' => 'Payment Type',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.amount', $this->amount, true);
		$criteria->compare('t.income_tax', $this->income_tax, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.additional_payment_1', $this->additional_payment_1, true);
		$criteria->compare('t.additional_payment_2', $this->additional_payment_2, true);
		$criteria->compare('t.account_id_additional_payment_1', $this->account_id_additional_payment_1);
		$criteria->compare('t.account_id_additional_payment_2', $this->account_id_additional_payment_2);
		$criteria->compare('t.sale_payment_header_id', $this->sale_payment_header_id);
		$criteria->compare('t.sale_invoice_header_id', $this->sale_invoice_header_id);
		$criteria->compare('t.account_id', $this->account_id);
		$criteria->compare('t.payment_type_id', $this->payment_type_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
