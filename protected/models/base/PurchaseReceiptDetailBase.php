<?php

/**
 * @property integer $id
 * @property string $total_invoice
 * @property string $total_payment
 * @property string $memo
 * @property integer $purchase_invoice_id
 * @property integer $purchase_receipt_header_id
 * @property integer $is_inactive
 *
 * @property PurchaseInvoice $purchaseInvoice
 * @property PurchaseReceiptHeader $purchaseReceiptHeader
 */
class PurchaseReceiptDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_purchase_receipt_detail';
	}

	public function rules()
	{
		return array(
			array('purchase_invoice_id, purchase_receipt_header_id', 'required'),
			array('purchase_invoice_id, purchase_receipt_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('total_invoice, total_payment', 'length', 'max'=>18),
			array('memo', 'safe'),
			// The following rule is used by search().
			array('id, total_invoice, total_payment, memo, purchase_invoice_id, purchase_receipt_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseInvoice' => array(self::BELONGS_TO, 'PurchaseInvoice', 'purchase_invoice_id'),
			'purchaseReceiptHeader' => array(self::BELONGS_TO, 'PurchaseReceiptHeader', 'purchase_receipt_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'total_invoice' => 'Total Invoice',
			'total_payment' => 'Total Payment',
			'memo' => 'Memo',
			'purchase_invoice_id' => 'Purchase Invoice',
			'purchase_receipt_header_id' => 'Purchase Receipt Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.total_invoice', $this->total_invoice, true);
		$criteria->compare('t.total_payment', $this->total_payment, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.purchase_invoice_id', $this->purchase_invoice_id);
		$criteria->compare('t.purchase_receipt_header_id', $this->purchase_receipt_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
