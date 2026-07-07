<?php

/**
 * @property integer $id
 * @property string $description
 * @property string $plate_number
 * @property integer $is_inactive
 *
 * @property DeliveryHeader[] $deliveryHeaders
 */
class DeliveryVehicleBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_delivery_vehicle';
	}

	public function rules()
	{
		return array(
			array('description, plate_number', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			array('plate_number', 'length', 'max'=>20),
			// The following rule is used by search().
			array('id, description, plate_number, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'delivery_vehicle_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => 'Description',
			'plate_number' => 'Plate Number',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.plate_number', $this->plate_number, true);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
