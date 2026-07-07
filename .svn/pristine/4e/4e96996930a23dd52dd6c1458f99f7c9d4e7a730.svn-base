<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $quotation_return_header_id
 * @property integer $product_id
 * @property integer $is_inactive
 *
 * @property QuotationReturnHeader $quotationReturnHeader
 * @property Product $product
 */
class QuotationReturnDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_quotation_return_detail';
	}

	public function rules()
	{
		return array(
			array('quantity, quotation_return_header_id, product_id', 'required'),
			array('quantity, quotation_return_header_id, product_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, quantity, unit_price, quotation_return_header_id, product_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'quotationReturnHeader' => array(self::BELONGS_TO, 'QuotationReturnHeader', 'quotation_return_header_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'quotation_return_header_id' => 'Quotation Return Header',
			'product_id' => 'Product',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.unit_price', $this->unit_price, true);
		$criteria->compare('t.quotation_return_header_id', $this->quotation_return_header_id);
		$criteria->compare('t.product_id', $this->product_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
