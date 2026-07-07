<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $serial_number
 * @property string $grade_classification
 * @property string $cutting_capacity
 * @property string $purchase_year
 * @property string $position
 * @property string $blade_size
 * @property string $cutting_speed
 * @property string $hydrolic_oil_capacity
 * @property string $cutting_oil_capacity
 * @property string $cutting_table_height
 * @property integer $net_weight
 * @property string $machine_size
 * @property string $milling_max_capacity
 * @property string $milling_min_capacity
 * @property integer $machine_type_id
 * @property integer $is_milling
 * @property integer $is_inactive
 *
 * @property MachineType $machineType
 * @property ProductionCuttingDetail[] $productionCuttingDetails
 * @property ProductionMilingDetail[] $productionMilingDetails
 * @property ProductionMilingDetail[] $productionMilingDetails1
 * @property ProductionMilingDetail[] $productionMilingDetails2
 * @property ProductionPlanningCuttingDetail[] $productionPlanningCuttingDetails
 * @property ProductionPlanningMilingDetail[] $productionPlanningMilingDetails
 * @property ProductionPlanningMilingDetail[] $productionPlanningMilingDetails1
 * @property ProductionPlanningMilingDetail[] $productionPlanningMilingDetails2
 */
class MachineBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_machine';
	}

	public function rules()
	{
		return array(
			array('name, serial_number, purchase_year, position, machine_type_id', 'required'),
			array('net_weight, machine_type_id, is_milling, is_inactive', 'numerical', 'integerOnly'=>true),
			array('name, serial_number, hydrolic_oil_capacity, cutting_oil_capacity, cutting_table_height', 'length', 'max'=>60),
			array('grade_classification, cutting_capacity, blade_size, cutting_speed, machine_size, milling_max_capacity, milling_min_capacity', 'length', 'max'=>100),
			array('purchase_year, position', 'length', 'max'=>20),
			// The following rule is used by search().
			array('id, name, serial_number, grade_classification, cutting_capacity, purchase_year, position, blade_size, cutting_speed, hydrolic_oil_capacity, cutting_oil_capacity, cutting_table_height, net_weight, machine_size, milling_max_capacity, milling_min_capacity, machine_type_id, is_milling, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'machineType' => array(self::BELONGS_TO, 'MachineType', 'machine_type_id'),
			'productionCuttingDetails' => array(self::HAS_MANY, 'ProductionCuttingDetail', 'machine_id'),
			'productionMilingDetails' => array(self::HAS_MANY, 'ProductionMilingDetail', 'machine_id_grinding'),
			'productionMilingDetails1' => array(self::HAS_MANY, 'ProductionMilingDetail', 'machine_id_facemil'),
			'productionMilingDetails2' => array(self::HAS_MANY, 'ProductionMilingDetail', 'machine_id_sidemil'),
			'productionPlanningCuttingDetails' => array(self::HAS_MANY, 'ProductionPlanningCuttingDetail', 'machine_id'),
			'productionPlanningMilingDetails' => array(self::HAS_MANY, 'ProductionPlanningMilingDetail', 'machine_id_facemil'),
			'productionPlanningMilingDetails1' => array(self::HAS_MANY, 'ProductionPlanningMilingDetail', 'machine_id_sidemil'),
			'productionPlanningMilingDetails2' => array(self::HAS_MANY, 'ProductionPlanningMilingDetail', 'machine_id_grinding'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'serial_number' => 'Serial Number',
			'grade_classification' => 'Grade Classification',
			'cutting_capacity' => 'Cutting Capacity',
			'purchase_year' => 'Purchase Year',
			'position' => 'Position',
			'blade_size' => 'Blade Size',
			'cutting_speed' => 'Cutting Speed',
			'hydrolic_oil_capacity' => 'Hydrolic Oil Capacity',
			'cutting_oil_capacity' => 'Cutting Oil Capacity',
			'cutting_table_height' => 'Cutting Table Height',
			'net_weight' => 'Net Weight',
			'machine_size' => 'Machine Size',
			'milling_max_capacity' => 'Milling Max Capacity',
			'milling_min_capacity' => 'Milling Min Capacity',
			'machine_type_id' => 'Machine Type',
			'is_milling' => 'Is Milling',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.serial_number', $this->serial_number, true);
		$criteria->compare('t.grade_classification', $this->grade_classification, true);
		$criteria->compare('t.cutting_capacity', $this->cutting_capacity, true);
		$criteria->compare('t.purchase_year', $this->purchase_year, true);
		$criteria->compare('t.position', $this->position, true);
		$criteria->compare('t.blade_size', $this->blade_size, true);
		$criteria->compare('t.cutting_speed', $this->cutting_speed, true);
		$criteria->compare('t.hydrolic_oil_capacity', $this->hydrolic_oil_capacity, true);
		$criteria->compare('t.cutting_oil_capacity', $this->cutting_oil_capacity, true);
		$criteria->compare('t.cutting_table_height', $this->cutting_table_height, true);
		$criteria->compare('t.net_weight', $this->net_weight);
		$criteria->compare('t.machine_size', $this->machine_size, true);
		$criteria->compare('t.milling_max_capacity', $this->milling_max_capacity, true);
		$criteria->compare('t.milling_min_capacity', $this->milling_min_capacity, true);
		$criteria->compare('t.machine_type_id', $this->machine_type_id);
		$criteria->compare('t.is_milling', $this->is_milling);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
