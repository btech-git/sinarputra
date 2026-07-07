<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property integer $is_inactive
 *
 * @property AdjustmentHeader[] $adjustmentHeaders
 * @property DeliveryHeader[] $deliveryHeaders
 * @property Inventory[] $inventories
 * @property ManualDeliveryHeader[] $manualDeliveryHeaders
 * @property ReceiveHeader[] $receiveHeaders
 */
class WarehouseBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_warehouse';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name, phone', 'length', 'max'=>60),
			array('address', 'safe'),
			// The following rule is used by search().
			array('id, name, address, phone, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'adjustmentHeaders' => array(self::HAS_MANY, 'AdjustmentHeader', 'warehouse_id'),
			'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'warehouse_id'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'warehouse_id'),
			'manualDeliveryHeaders' => array(self::HAS_MANY, 'ManualDeliveryHeader', 'warehouse_id'),
			'receiveHeaders' => array(self::HAS_MANY, 'ReceiveHeader', 'warehouse_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'address' => 'Address',
			'phone' => 'Phone',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.address', $this->address, true);
		$criteria->compare('t.phone', $this->phone, true);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
