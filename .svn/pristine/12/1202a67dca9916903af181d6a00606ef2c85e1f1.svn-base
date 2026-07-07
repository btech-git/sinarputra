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
 * @property integer $quantity_quality_control
 * @property string $weight
 * @property string $job_group_facemil
 * @property string $job_group_sidemil
 * @property string $job_group_grinding
 * @property string $production_date_facemil
 * @property string $production_date_sidemil
 * @property string $production_date_grinding
 * @property string $production_time_start
 * @property string $production_time_end
 * @property integer $production_miling_header_id
 * @property integer $production_planning_miling_detail_id
 * @property integer $machine_id_facemil
 * @property integer $machine_id_sidemil
 * @property integer $machine_id_grinding
 * @property integer $employee_id_facemil
 * @property integer $employee_id_sidemil
 * @property integer $employee_id_grinding
 * @property integer $is_inactive
 *
 * @property ProductionMilingHeader $productionMilingHeader
 * @property Machine $machineIdGrinding
 * @property Employee $employeeIdFacemil
 * @property Employee $employeeIdSidemil
 * @property Employee $employeeIdGrinding
 * @property ProductionPlanningMilingDetail $productionPlanningMilingDetail
 * @property Machine $machineIdFacemil
 * @property Machine $machineIdSidemil
 * @property QualityControlMilingDetail[] $qualityControlMilingDetails
 */
class ProductionMilingDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_production_miling_detail';
    }

    public function rules() {
        return array(
            array('production_time_start, production_time_end, production_miling_header_id, production_planning_miling_detail_id', 'required'),
            array('quantity, quantity_quality_control, production_miling_header_id, production_planning_miling_detail_id, machine_id_facemil, machine_id_sidemil, machine_id_grinding, employee_id_facemil, employee_id_sidemil, employee_id_grinding, is_inactive', 'numerical', 'integerOnly' => true),
            array('length_request, width_request, height_request, length_quote, width_quote, height_quote, weight', 'length', 'max' => 10),
            array('job_group_facemil, job_group_sidemil, job_group_grinding', 'length', 'max' => 20),
            array('production_date_facemil, production_date_sidemil, production_date_grinding', 'safe'),
            // The following rule is used by search().
            array('id, length_request, width_request, height_request, length_quote, width_quote, height_quote, quantity, quantity_quality_control, weight, job_group_facemil, job_group_sidemil, job_group_grinding, production_date_facemil, production_date_sidemil, production_date_grinding, production_time_start, production_time_end, production_miling_header_id, production_planning_miling_detail_id, machine_id_facemil, machine_id_sidemil, machine_id_grinding, employee_id_facemil, employee_id_sidemil, employee_id_grinding, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'productionMilingHeader' => array(self::BELONGS_TO, 'ProductionMilingHeader', 'production_miling_header_id'),
            'machineIdGrinding' => array(self::BELONGS_TO, 'Machine', 'machine_id_grinding'),
            'employeeIdFacemil' => array(self::BELONGS_TO, 'Employee', 'employee_id_facemil'),
            'employeeIdSidemil' => array(self::BELONGS_TO, 'Employee', 'employee_id_sidemil'),
            'employeeIdGrinding' => array(self::BELONGS_TO, 'Employee', 'employee_id_grinding'),
            'productionPlanningMilingDetail' => array(self::BELONGS_TO, 'ProductionPlanningMilingDetail', 'production_planning_miling_detail_id'),
            'machineIdFacemil' => array(self::BELONGS_TO, 'Machine', 'machine_id_facemil'),
            'machineIdSidemil' => array(self::BELONGS_TO, 'Machine', 'machine_id_sidemil'),
            'qualityControlMilingDetails' => array(self::HAS_MANY, 'QualityControlMilingDetail', 'production_miling_detail_id'),
        );
    }

    public function attributeLabels() {
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
            'job_group_facemil' => 'Job Group Facemil',
            'job_group_sidemil' => 'Job Group Sidemil',
            'job_group_grinding' => 'Job Group Grinding',
            'production_date_facemil' => 'Production Date Facemil',
            'production_date_sidemil' => 'Production Date Sidemil',
            'production_date_grinding' => 'Production Date Grinding',
            'production_time_start' => 'Production Time Start',
            'production_time_end' => 'Production Time End',
            'production_miling_header_id' => 'Production Miling Header',
            'production_planning_miling_detail_id' => 'Production Planning Miling Detail',
            'machine_id_facemil' => 'Machine Id Facemil',
            'machine_id_sidemil' => 'Machine Id Sidemil',
            'machine_id_grinding' => 'Machine Id Grinding',
            'employee_id_facemil' => 'Employee Id Facemil',
            'employee_id_sidemil' => 'Employee Id Sidemil',
            'employee_id_grinding' => 'Employee Id Grinding',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
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
        $criteria->compare('t.job_group_facemil', $this->job_group_facemil, true);
        $criteria->compare('t.job_group_sidemil', $this->job_group_sidemil, true);
        $criteria->compare('t.job_group_grinding', $this->job_group_grinding, true);
        $criteria->compare('t.production_date_facemil', $this->production_date_facemil, true);
        $criteria->compare('t.production_date_sidemil', $this->production_date_sidemil, true);
        $criteria->compare('t.production_date_grinding', $this->production_date_grinding, true);
        $criteria->compare('t.production_time_start', $this->production_time_start, true);
        $criteria->compare('t.production_time_end', $this->production_time_end, true);
        $criteria->compare('t.production_miling_header_id', $this->production_miling_header_id);
        $criteria->compare('t.production_planning_miling_detail_id', $this->production_planning_miling_detail_id);
        $criteria->compare('t.machine_id_facemil', $this->machine_id_facemil);
        $criteria->compare('t.machine_id_sidemil', $this->machine_id_sidemil);
        $criteria->compare('t.machine_id_grinding', $this->machine_id_grinding);
        $criteria->compare('t.employee_id_facemil', $this->employee_id_facemil);
        $criteria->compare('t.employee_id_sidemil', $this->employee_id_sidemil);
        $criteria->compare('t.employee_id_grinding', $this->employee_id_grinding);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
