<?php

/**
 * @property integer $id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $quantity
 * @property integer $quantity_quality_control
 * @property string $weight
 * @property string $job_group
 * @property string $production_date
 * @property string $production_time_start
 * @property string $production_time_end
 * @property integer $production_cutting_header_id
 * @property integer $production_planning_cutting_detail_id
 * @property integer $machine_id
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property ProductionCuttingHeader $productionCuttingHeader
 * @property Machine $machine
 * @property Employee $employee
 * @property ProductionPlanningCuttingDetail $productionPlanningCuttingDetail
 * @property QualityControlCuttingDetail[] $qualityControlCuttingDetails
 */
class ProductionCuttingDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_production_cutting_detail';
    }

    public function rules() {
        return array(
            array('job_group, production_date, production_time_start, production_time_end, production_cutting_header_id, production_planning_cutting_detail_id, machine_id, employee_id', 'required'),
            array('quantity, quantity_quality_control, production_cutting_header_id, production_planning_cutting_detail_id, machine_id, employee_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('length, width, height, weight', 'length', 'max' => 10),
            array('job_group', 'length', 'max' => 20),
            // The following rule is used by search().
            array('id, length, width, height, quantity, quantity_quality_control, weight, job_group, production_date, production_time_start, production_time_end, production_cutting_header_id, production_planning_cutting_detail_id, machine_id, employee_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'productionCuttingHeader' => array(self::BELONGS_TO, 'ProductionCuttingHeader', 'production_cutting_header_id'),
            'machine' => array(self::BELONGS_TO, 'Machine', 'machine_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'productionPlanningCuttingDetail' => array(self::BELONGS_TO, 'ProductionPlanningCuttingDetail', 'production_planning_cutting_detail_id'),
            'qualityControlCuttingDetails' => array(self::HAS_MANY, 'QualityControlCuttingDetail', 'production_cutting_detail_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'quantity' => 'Quantity',
            'weight' => 'Weight',
            'job_group' => 'Job Group',
            'production_date' => 'Production Date',
            'production_time_start' => 'Production Time Start',
            'production_time_end' => 'Production Time End',
            'production_cutting_header_id' => 'Production Cutting Header',
            'production_planning_cutting_detail_id' => 'Production Planning Cutting Detail',
            'machine_id' => 'Machine',
            'employee_id' => 'Employee',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.length', $this->length, true);
        $criteria->compare('t.width', $this->width, true);
        $criteria->compare('t.height', $this->height, true);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.job_group', $this->job_group, true);
        $criteria->compare('t.production_date', $this->production_date, true);
        $criteria->compare('t.production_time_start', $this->production_time_start, true);
        $criteria->compare('t.production_time_end', $this->production_time_end, true);
        $criteria->compare('t.production_cutting_header_id', $this->production_cutting_header_id);
        $criteria->compare('t.production_planning_cutting_detail_id', $this->production_planning_cutting_detail_id);
        $criteria->compare('t.machine_id', $this->machine_id);
        $criteria->compare('t.employee_id', $this->employee_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}