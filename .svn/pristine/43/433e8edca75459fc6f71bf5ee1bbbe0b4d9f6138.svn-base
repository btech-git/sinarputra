<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $account_category_id
 * @property integer $is_inactive
 *
 * @property AccountCategory $accountCategory
 * @property Customer[] $customers
 * @property DepositDetail[] $depositDetails
 * @property DepositHeader[] $depositHeaders
 * @property ExpenseDetail[] $expenseDetails
 * @property ExpenseHeader[] $expenseHeaders
 * @property JournalAccounting[] $journalAccountings
 * @property JournalVoucherDetail[] $journalVoucherDetails
 * @property ManualSalePaymentDetail[] $manualSalePaymentDetails
 * @property ManualSalePaymentHeader[] $manualSalePaymentHeaders
 * @property ManualSalePaymentHeader[] $manualSalePaymentHeaders1
 * @property PurchasePaymentDetail[] $purchasePaymentDetails
 * @property SalePaymentDetail[] $salePaymentDetails
 * @property SalePaymentDetail[] $salePaymentDetails1
 * @property SalePaymentDetail[] $salePaymentDetails2
 * @property SalePaymentHeader[] $salePaymentHeaders
 * @property SalePaymentHeader[] $salePaymentHeaders1
 * @property Supplier[] $suppliers
 */
class AccountBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_account';
	}

	public function rules()
	{
		return array(
			array('name, account_category_id', 'required'),
			array('account_category_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('code, name', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, code, name, account_category_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'accountCategory' => array(self::BELONGS_TO, 'AccountCategory', 'account_category_id'),
			'customers' => array(self::HAS_MANY, 'Customer', 'account_id_receivable'),
			'depositDetails' => array(self::HAS_MANY, 'DepositDetail', 'account_id'),
			'depositHeaders' => array(self::HAS_MANY, 'DepositHeader', 'account_id'),
			'expenseDetails' => array(self::HAS_MANY, 'ExpenseDetail', 'account_id'),
			'expenseHeaders' => array(self::HAS_MANY, 'ExpenseHeader', 'account_id'),
			'journalAccountings' => array(self::HAS_MANY, 'JournalAccounting', 'account_id'),
			'journalVoucherDetails' => array(self::HAS_MANY, 'JournalVoucherDetail', 'account_id'),
			'manualSalePaymentDetails' => array(self::HAS_MANY, 'ManualSalePaymentDetail', 'account_id'),
			'manualSalePaymentHeaders' => array(self::HAS_MANY, 'ManualSalePaymentHeader', 'account_id_additional_payment_1'),
			'manualSalePaymentHeaders1' => array(self::HAS_MANY, 'ManualSalePaymentHeader', 'account_id_additional_payment_2'),
			'purchasePaymentDetails' => array(self::HAS_MANY, 'PurchasePaymentDetail', 'account_id'),
			'salePaymentDetails' => array(self::HAS_MANY, 'SalePaymentDetail', 'account_id'),
			'salePaymentDetails1' => array(self::HAS_MANY, 'SalePaymentDetail', 'account_id_additional_payment_1'),
			'salePaymentDetails2' => array(self::HAS_MANY, 'SalePaymentDetail', 'account_id_additional_payment_2'),
			'salePaymentHeaders' => array(self::HAS_MANY, 'SalePaymentHeader', 'account_id_additional_payment_1'),
			'salePaymentHeaders1' => array(self::HAS_MANY, 'SalePaymentHeader', 'account_id_additional_payment_2'),
			'suppliers' => array(self::HAS_MANY, 'Supplier', 'account_id_payable'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'account_category_id' => 'Account Category',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.code', $this->code, true);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.account_category_id', $this->account_category_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
