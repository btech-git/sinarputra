<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property integer $receive_item_header_id
 * @property integer $purchase_item_detail_id
 * @property integer $is_inactive
 *
 * @property ReceiveItemHeader $receiveItemHeader
 * @property PurchaseItemDetail $purchaseItemDetail
 */
class ReceiveItemDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_receive_item_detail';
	}

	public function rules()
	{
		return array(
			array('quantity, receive_item_header_id, purchase_item_detail_id', 'required'),
			array('quantity, receive_item_header_id, purchase_item_detail_id, is_inactive', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, quantity, receive_item_header_id, purchase_item_detail_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'receiveItemHeader' => array(self::BELONGS_TO, 'ReceiveItemHeader', 'receive_item_header_id'),
			'purchaseItemDetail' => array(self::BELONGS_TO, 'PurchaseItemDetail', 'purchase_item_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'receive_item_header_id' => 'Receive Item Header',
			'purchase_item_detail_id' => 'Purchase Item Detail',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.receive_item_header_id', $this->receive_item_header_id);
		$criteria->compare('t.purchase_item_detail_id', $this->purchase_item_detail_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
