<?php

/**
 * @property integer $id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $quantity
 * @property string $weight
 * @property string $planning_date
 * @property string $job_group
 * @property integer $production_planning_cutting_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $work_order_replacement_detail_id
 * @property integer $machine_id
 * @property integer $is_inactive
 *
 * @property ProductionCuttingDetail[] $productionCuttingDetails
 * @property WorkOrderReplacementDetail $workOrderReplacementDetail
 * @property ProductionPlanningCuttingHeader $productionPlanningCuttingHeader
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property Machine $machine
 */
class ProductionPlanningCuttingDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_production_planning_cutting_detail';
	}

	public function rules()
	{
		return array(
			array('planning_date, job_group, production_planning_cutting_header_id, machine_id', 'required'),
			array('quantity, production_planning_cutting_header_id, work_order_cutting_detail_id, work_order_replacement_detail_id, machine_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('length, width, height, weight', 'length', 'max'=>10),
			array('job_group', 'length', 'max'=>20),
			// The following rule is used by search().
			array('id, length, width, height, quantity, weight, planning_date, job_group, production_planning_cutting_header_id, work_order_cutting_detail_id, work_order_replacement_detail_id, machine_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'productionCuttingDetails' => array(self::HAS_MANY, 'ProductionCuttingDetail', 'production_planning_cutting_detail_id'),
			'workOrderReplacementDetail' => array(self::BELONGS_TO, 'WorkOrderReplacementDetail', 'work_order_replacement_detail_id'),
			'productionPlanningCuttingHeader' => array(self::BELONGS_TO, 'ProductionPlanningCuttingHeader', 'production_planning_cutting_header_id'),
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'machine' => array(self::BELONGS_TO, 'Machine', 'machine_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'length' => 'Length',
			'width' => 'Width',
			'height' => 'Height',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'planning_date' => 'Planning Date',
			'job_group' => 'Job Group',
			'production_planning_cutting_header_id' => 'Production Planning Cutting Header',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'work_order_replacement_detail_id' => 'Work Order Replacement Detail',
			'machine_id' => 'Machine',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.length', $this->length, true);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.planning_date', $this->planning_date, true);
		$criteria->compare('t.job_group', $this->job_group, true);
		$criteria->compare('t.production_planning_cutting_header_id', $this->production_planning_cutting_header_id);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.work_order_replacement_detail_id', $this->work_order_replacement_detail_id);
		$criteria->compare('t.machine_id', $this->machine_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
