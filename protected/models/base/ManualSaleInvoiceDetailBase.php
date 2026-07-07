<?php

/**
 * @property integer $id
 * @property string $grade_name
 * @property integer $quantity
 * @property string $weight
 * @property string $unit_price
 * @property string $rounding_amount
 * @property integer $manual_sale_invoice_header_id
 * @property integer $delivery_detail_id
 * @property integer $is_using_weight
 * @property integer $is_inactive
 *
 * @property DeliveryDetail $deliveryDetail
 * @property ManualSaleInvoiceHeader $manualSaleInvoiceHeader
 */
class ManualSaleInvoiceDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_manual_sale_invoice_detail';
	}

	public function rules()
	{
		return array(
			array('manual_sale_invoice_header_id, delivery_detail_id', 'required'),
			array('quantity, manual_sale_invoice_header_id, delivery_detail_id, is_using_weight, is_inactive', 'numerical', 'integerOnly'=>true),
			array('grade_name', 'length', 'max'=>100),
			array('weight', 'length', 'max'=>10),
			array('unit_price, rounding_amount', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, grade_name, quantity, weight, unit_price, manual_sale_invoice_header_id, delivery_detail_id, is_using_weight, is_inactive, rounding_amount', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryDetail' => array(self::BELONGS_TO, 'DeliveryDetail', 'delivery_detail_id'),
			'manualSaleInvoiceHeader' => array(self::BELONGS_TO, 'ManualSaleInvoiceHeader', 'manual_sale_invoice_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'grade_name' => 'Grade Name',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'unit_price' => 'Unit Price',
			'manual_sale_invoice_header_id' => 'Manual Sale Invoice Header',
			'delivery_detail_id' => 'Delivery Detail',
			'is_using_weight' => 'Is Using Weight',
			'is_inactive' => 'Is Inactive',
			'rounding_amount' => 'Rounding Amount',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.grade_name', $this->grade_name, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.unit_price', $this->unit_price, true);
		$criteria->compare('t.manual_sale_invoice_header_id', $this->manual_sale_invoice_header_id);
		$criteria->compare('t.delivery_detail_id', $this->delivery_detail_id);
		$criteria->compare('t.is_using_weight', $this->is_using_weight);
		$criteria->compare('t.is_inactive', $this->is_inactive);
		$criteria->compare('t.rounding_amount', $this->rounding_amount, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
