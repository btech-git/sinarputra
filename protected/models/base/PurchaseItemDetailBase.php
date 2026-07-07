<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $purchase_item_header_id
 * @property integer $item_id
 * @property integer $is_inactive
 *
 * @property PurchaseItemHeader $purchaseItemHeader
 * @property Item $item
 * @property ReceiveItemDetail[] $receiveItemDetails
 */
class PurchaseItemDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_purchase_item_detail';
	}

	public function rules()
	{
		return array(
			array('purchase_item_header_id, item_id', 'required'),
			array('quantity, purchase_item_header_id, item_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, quantity, unit_price, purchase_item_header_id, item_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseItemHeader' => array(self::BELONGS_TO, 'PurchaseItemHeader', 'purchase_item_header_id'),
			'item' => array(self::BELONGS_TO, 'Item', 'item_id'),
			'receiveItemDetails' => array(self::HAS_MANY, 'ReceiveItemDetail', 'purchase_item_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'purchase_item_header_id' => 'Purchase Item Header',
			'item_id' => 'Item',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.unit_price', $this->unit_price, true);
		$criteria->compare('t.purchase_item_header_id', $this->purchase_item_header_id);
		$criteria->compare('t.item_id', $this->item_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
