<?php

/**
 * @property integer $id
 * @property string $total_invoice
 * @property string $memo
 * @property integer $sale_receipt_header_id
 * @property integer $sale_invoice_header_id
 * @property integer $is_inactive
 *
 * @property SaleReceiptHeader $saleReceiptHeader
 * @property SaleInvoiceHeader $saleInvoiceHeader
 */
class SaleReceiptDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_sale_receipt_detail';
	}

	public function rules()
	{
		return array(
			array('sale_receipt_header_id, sale_invoice_header_id', 'required'),
			array('sale_receipt_header_id, sale_invoice_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('total_invoice', 'length', 'max'=>18),
			array('memo', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, total_invoice, memo, sale_receipt_header_id, sale_invoice_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'saleReceiptHeader' => array(self::BELONGS_TO, 'SaleReceiptHeader', 'sale_receipt_header_id'),
			'saleInvoiceHeader' => array(self::BELONGS_TO, 'SaleInvoiceHeader', 'sale_invoice_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'total_invoice' => 'Total Invoice',
			'memo' => 'Memo',
			'sale_receipt_header_id' => 'Sale Receipt Header',
			'sale_invoice_header_id' => 'Sale Invoice Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.total_invoice', $this->total_invoice, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.sale_receipt_header_id', $this->sale_receipt_header_id);
		$criteria->compare('t.sale_invoice_header_id', $this->sale_invoice_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
