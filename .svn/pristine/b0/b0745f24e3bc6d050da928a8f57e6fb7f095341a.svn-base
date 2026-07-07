<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $control_date
 * @property string $control_time
 * @property string $control_result
 * @property string $job_group
 * @property string $memo
 * @property integer $quality_control_cutting_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $production_cutting_detail_id
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property DeliveryDetail[] $deliveryDetails
 * @property QualityControlCuttingHeader $qualityControlCuttingHeader
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property Employee $employee
 * @property ProductionCuttingDetail $productionCuttingDetail
 * @property WorkOrderReplacementDetail[] $workOrderReplacementDetails
 */
class QualityControlCuttingDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_quality_control_cutting_detail';
	}

	public function rules()
	{
		return array(
			array('control_date, control_time, control_result, job_group, quality_control_cutting_header_id, work_order_cutting_detail_id, production_cutting_detail_id, employee_id', 'required'),
			array('quantity, quality_control_cutting_header_id, work_order_cutting_detail_id, production_cutting_detail_id, employee_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('control_result, job_group', 'length', 'max'=>20),
			array('memo', 'length', 'max'=>100),
			// The following rule is used by search().
			array('id, quantity, control_date, control_time, control_result, job_group, memo, quality_control_cutting_header_id, work_order_cutting_detail_id, production_cutting_detail_id, employee_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryDetails' => array(self::HAS_MANY, 'DeliveryDetail', 'quality_control_cutting_detail_id'),
			'qualityControlCuttingHeader' => array(self::BELONGS_TO, 'QualityControlCuttingHeader', 'quality_control_cutting_header_id'),
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
			'productionCuttingDetail' => array(self::BELONGS_TO, 'ProductionCuttingDetail', 'production_cutting_detail_id'),
			'workOrderReplacementDetails' => array(self::HAS_MANY, 'WorkOrderReplacementDetail', 'quality_control_cutting_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quantity' => 'Quantity',
			'control_date' => 'Control Date',
			'control_time' => 'Control Time',
			'control_result' => 'Control Result',
			'job_group' => 'Job Group',
			'memo' => 'Memo',
			'quality_control_cutting_header_id' => 'Quality Control Cutting Header',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'production_cutting_detail_id' => 'Production Cutting Detail',
			'employee_id' => 'Employee',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.control_date', $this->control_date, true);
		$criteria->compare('t.control_time', $this->control_time, true);
		$criteria->compare('t.control_result', $this->control_result, true);
		$criteria->compare('t.job_group', $this->job_group, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.quality_control_cutting_header_id', $this->quality_control_cutting_header_id);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.production_cutting_detail_id', $this->production_cutting_detail_id);
		$criteria->compare('t.employee_id', $this->employee_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
