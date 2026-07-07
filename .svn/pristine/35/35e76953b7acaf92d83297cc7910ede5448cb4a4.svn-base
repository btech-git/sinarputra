<?php

/**
 * @property integer $id
 * @property string $total_invoice
 * @property string $memo
 * @property integer $manual_sale_receipt_header_id
 * @property integer $manual_sale_invoice_header_id
 * @property integer $is_inactive
 *
 * @property ManualSaleReceiptHeader $manualSaleReceiptHeader
 * @property ManualSaleInvoiceHeader $manualSaleInvoiceHeader
 */
class ManualSaleReceiptDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_manual_sale_receipt_detail';
	}

	public function rules()
	{
		return array(
			array('manual_sale_receipt_header_id, manual_sale_invoice_header_id', 'required'),
			array('manual_sale_receipt_header_id, manual_sale_invoice_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('total_invoice', 'length', 'max'=>18),
			array('memo', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, total_invoice, memo, manual_sale_receipt_header_id, manual_sale_invoice_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'manualSaleReceiptHeader' => array(self::BELONGS_TO, 'ManualSaleReceiptHeader', 'manual_sale_receipt_header_id'),
			'manualSaleInvoiceHeader' => array(self::BELONGS_TO, 'ManualSaleInvoiceHeader', 'manual_sale_invoice_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'total_invoice' => 'Total Invoice',
			'memo' => 'Memo',
			'manual_sale_receipt_header_id' => 'Manual Sale Receipt Header',
			'manual_sale_invoice_header_id' => 'Manual Sale Invoice Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.total_invoice', $this->total_invoice, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.manual_sale_receipt_header_id', $this->manual_sale_receipt_header_id);
		$criteria->compare('t.manual_sale_invoice_header_id', $this->manual_sale_invoice_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
