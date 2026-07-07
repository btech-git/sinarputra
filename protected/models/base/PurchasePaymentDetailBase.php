<?php

/**
 * @property integer $id
 * @property string $amount
 * @property string $memo
 * @property integer $account_id
 * @property integer $payment_type_id
 * @property integer $purchase_payment_header_id
 * @property integer $is_inactive
 *
 * @property PaymentType $paymentType
 * @property PurchasePaymentHeader $purchasePaymentHeader
 * @property Account $account
 */
class PurchasePaymentDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_purchase_payment_detail';
	}

	public function rules()
	{
		return array(
			array('amount, account_id, payment_type_id, purchase_payment_header_id', 'required'),
			array('account_id, payment_type_id, purchase_payment_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>18),
			array('memo', 'safe'),
			// The following rule is used by search().
			array('id, amount, memo, account_id, payment_type_id, purchase_payment_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
			'purchasePaymentHeader' => array(self::BELONGS_TO, 'PurchasePaymentHeader', 'purchase_payment_header_id'),
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'memo' => 'Memo',
			'account_id' => 'Account',
			'payment_type_id' => 'Payment Type',
			'purchase_payment_header_id' => 'Purchase Payment Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.amount', $this->amount, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.account_id', $this->account_id);
		$criteria->compare('t.payment_type_id', $this->payment_type_id);
		$criteria->compare('t.purchase_payment_header_id', $this->purchase_payment_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
