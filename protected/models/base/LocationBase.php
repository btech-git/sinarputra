<?php

/**
 * @property integer $id
 * @property string $name
 * @property integer $is_inactive
 *
 * @property ReceiveDetail[] $receiveDetails
 * @property WorkOrderCuttingDetailMaterial[] $workOrderCuttingDetailMaterials
 */
class LocationBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_location';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, name, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'location_id'),
			'workOrderCuttingDetailMaterials' => array(self::HAS_MANY, 'WorkOrderCuttingDetailMaterial', 'location_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
