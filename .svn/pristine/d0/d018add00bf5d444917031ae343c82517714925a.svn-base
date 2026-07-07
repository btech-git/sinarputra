<?php

/**
 * @property integer $id
 * @property string $length_request
 * @property string $width_request
 * @property string $height_request
 * @property string $length_quote
 * @property string $width_quote
 * @property string $height_quote
 * @property integer $quantity
 * @property string $weight
 * @property string $planning_date_facemil
 * @property string $planning_date_sidemil
 * @property string $planning_date_grinding
 * @property string $job_group_facemil
 * @property string $job_group_sidemil
 * @property string $job_group_grinding
 * @property integer $production_planning_miling_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $work_order_replacement_detail_id
 * @property integer $machine_id_facemil
 * @property integer $machine_id_sidemil
 * @property integer $machine_id_grinding
 * @property integer $is_inactive
 *
 * @property ProductionMilingDetail[] $productionMilingDetails
 * @property WorkOrderReplacementDetail $workOrderReplacementDetail
 * @property ProductionPlanningMilingHeader $productionPlanningMilingHeader
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property Machine $machineIdFacemil
 * @property Machine $machineIdSidemil
 * @property Machine $machineIdGrinding
 */
class ProductionPlanningMilingDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_production_planning_miling_detail';
	}

	public function rules()
	{
		return array(
			array('production_planning_miling_header_id', 'required'),
			array('quantity, production_planning_miling_header_id, work_order_cutting_detail_id, work_order_replacement_detail_id, machine_id_facemil, machine_id_sidemil, machine_id_grinding, is_inactive', 'numerical', 'integerOnly'=>true),
			array('length_request, width_request, height_request, length_quote, width_quote, height_quote, weight', 'length', 'max'=>10),
			array('job_group_facemil, job_group_sidemil, job_group_grinding', 'length', 'max'=>20),
			array('planning_date_facemil, planning_date_sidemil, planning_date_grinding', 'safe'),
			// The following rule is used by search().
			array('id, length_request, width_request, height_request, length_quote, width_quote, height_quote, quantity, weight, planning_date_facemil, planning_date_sidemil, planning_date_grinding, job_group_facemil, job_group_sidemil, job_group_grinding, production_planning_miling_header_id, work_order_cutting_detail_id, work_order_replacement_detail_id, machine_id_facemil, machine_id_sidemil, machine_id_grinding, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'productionMilingDetails' => array(self::HAS_MANY, 'ProductionMilingDetail', 'production_planning_miling_detail_id'),
			'workOrderReplacementDetail' => array(self::BELONGS_TO, 'WorkOrderReplacementDetail', 'work_order_replacement_detail_id'),
			'productionPlanningMilingHeader' => array(self::BELONGS_TO, 'ProductionPlanningMilingHeader', 'production_planning_miling_header_id'),
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'machineIdFacemil' => array(self::BELONGS_TO, 'Machine', 'machine_id_facemil'),
			'machineIdSidemil' => array(self::BELONGS_TO, 'Machine', 'machine_id_sidemil'),
			'machineIdGrinding' => array(self::BELONGS_TO, 'Machine', 'machine_id_grinding'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'length_request' => 'Length Request',
			'width_request' => 'Width Request',
			'height_request' => 'Height Request',
			'length_quote' => 'Length Quote',
			'width_quote' => 'Width Quote',
			'height_quote' => 'Height Quote',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'planning_date_facemil' => 'Planning Date Facemil',
			'planning_date_sidemil' => 'Planning Date Sidemil',
			'planning_date_grinding' => 'Planning Date Grinding',
			'job_group_facemil' => 'Job Group Facemil',
			'job_group_sidemil' => 'Job Group Sidemil',
			'job_group_grinding' => 'Job Group Grinding',
			'production_planning_miling_header_id' => 'Production Planning Miling Header',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'work_order_replacement_detail_id' => 'Work Order Replacement Detail',
			'machine_id_facemil' => 'Machine Id Facemil',
			'machine_id_sidemil' => 'Machine Id Sidemil',
			'machine_id_grinding' => 'Machine Id Grinding',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.length_request', $this->length_request, true);
		$criteria->compare('t.width_request', $this->width_request, true);
		$criteria->compare('t.height_request', $this->height_request, true);
		$criteria->compare('t.length_quote', $this->length_quote, true);
		$criteria->compare('t.width_quote', $this->width_quote, true);
		$criteria->compare('t.height_quote', $this->height_quote, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.planning_date_facemil', $this->planning_date_facemil, true);
		$criteria->compare('t.planning_date_sidemil', $this->planning_date_sidemil, true);
		$criteria->compare('t.planning_date_grinding', $this->planning_date_grinding, true);
		$criteria->compare('t.job_group_facemil', $this->job_group_facemil, true);
		$criteria->compare('t.job_group_sidemil', $this->job_group_sidemil, true);
		$criteria->compare('t.job_group_grinding', $this->job_group_grinding, true);
		$criteria->compare('t.production_planning_miling_header_id', $this->production_planning_miling_header_id);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.work_order_replacement_detail_id', $this->work_order_replacement_detail_id);
		$criteria->compare('t.machine_id_facemil', $this->machine_id_facemil);
		$criteria->compare('t.machine_id_sidemil', $this->machine_id_sidemil);
		$criteria->compare('t.machine_id_grinding', $this->machine_id_grinding);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
