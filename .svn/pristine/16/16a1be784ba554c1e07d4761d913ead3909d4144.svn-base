<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $purchase_return_header_id
 * @property integer $receive_detail_id
 * @property integer $is_inactive
 *
 * @property ReceiveDetail $receiveDetail
 * @property PurchaseReturnHeader $purchaseReturnHeader
 */
class PurchaseReturnDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_purchase_return_detail';
	}

	public function rules()
	{
		return array(
			array('purchase_return_header_id, receive_detail_id', 'required'),
			array('quantity, purchase_return_header_id, receive_detail_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, quantity, unit_price, purchase_return_header_id, receive_detail_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'receiveDetail' => array(self::BELONGS_TO, 'ReceiveDetail', 'receive_detail_id'),
			'purchaseReturnHeader' => array(self::BELONGS_TO, 'PurchaseReturnHeader', 'purchase_return_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'purchase_return_header_id' => 'Purchase Return Header',
			'receive_detail_id' => 'Receive Detail',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.unit_price', $this->unit_price, true);
		$criteria->compare('t.purchase_return_header_id', $this->purchase_return_header_id);
		$criteria->compare('t.receive_detail_id', $this->receive_detail_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
