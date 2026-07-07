<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $control_date
 * @property string $control_time
 * @property string $control_result
 * @property string $job_group
 * @property string $memo
 * @property integer $quality_control_miling_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $production_miling_detail_id
 * @property integer $employee_id
 * @property integer $is_miling
 * @property integer $is_grinding
 * @property integer $is_hardness
 * @property integer $is_annelying
 * @property integer $is_sidemiling
 * @property integer $is_inactive
 * @property string $sidemiling_length_tolerance
 * @property string $sidemiling_width_tolerance
 * @property string $sidemiling_height_tolerance
 * @property string $grinding_length_tolerance
 * @property string $grinding_width_tolerance
 * @property string $grinding_height_tolerance
 *
 * @property DeliveryDetail[] $deliveryDetails
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property Employee $employee
 * @property QualityControlMilingHeader $qualityControlMilingHeader
 * @property ProductionMilingDetail $productionMilingDetail
 * @property WorkOrderReplacementDetail[] $workOrderReplacementDetails
 */
class QualityControlMilingDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_quality_control_miling_detail';
    }

    public function rules() {
        return array(
            array('control_date, control_time, control_result, job_group, quality_control_miling_header_id, work_order_cutting_detail_id, production_miling_detail_id, employee_id', 'required'),
            array('quantity, quality_control_miling_header_id, work_order_cutting_detail_id, production_miling_detail_id, employee_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_inactive', 'numerical', 'integerOnly' => true),
            array('control_result, job_group', 'length', 'max' => 20),
            array('sidemiling_length_tolerance, sidemiling_width_tolerance, sidemiling_height_tolerance, grinding_length_tolerance, grinding_width_tolerance, grinding_height_tolerance', 'length', 'max' => 10),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            array('id, quantity, control_date, control_time, control_result, job_group, memo, quality_control_miling_header_id, work_order_cutting_detail_id, production_miling_detail_id, employee_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_inactive, sidemiling_length_tolerance, sidemiling_width_tolerance, sidemiling_height_tolerance, grinding_length_tolerance, grinding_width_tolerance, grinding_height_tolerance', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryDetails' => array(self::HAS_MANY, 'DeliveryDetail', 'quality_control_miling_detail_id'),
            'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'qualityControlMilingHeader' => array(self::BELONGS_TO, 'QualityControlMilingHeader', 'quality_control_miling_header_id'),
            'productionMilingDetail' => array(self::BELONGS_TO, 'ProductionMilingDetail', 'production_miling_detail_id'),
            'workOrderReplacementDetails' => array(self::HAS_MANY, 'WorkOrderReplacementDetail', 'quality_control_miling_detail_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'control_date' => 'Control Date',
            'control_time' => 'Control Time',
            'control_result' => 'Control Result',
            'job_group' => 'Job Group',
            'memo' => 'Memo',
            'quality_control_miling_header_id' => 'Quality Control Miling Header',
            'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
            'production_miling_detail_id' => 'Production Miling Detail',
            'employee_id' => 'Employee',
            'is_miling' => 'Is Miling',
            'is_grinding' => 'Is Grinding',
            'is_hardness' => 'Is Hardness',
            'is_annelying' => 'Is Annelying',
            'is_sidemiling' => 'Is Sidemiling',
            'is_inactive' => 'Is Inactive',
            'sidemiling_length_tolerance' => 'Sidemiling Length Tolerance',
            'sidemiling_width_tolerance' => 'Sidemiling Width Tolerance',
            'sidemiling_height_tolerance' => 'Sidemiling Height Tolerance',
            'grinding_length_tolerance' => 'Grinding Length Tolerance',
            'grinding_width_tolerance' => 'Grinding Width Tolerance',
            'grinding_height_tolerance' => 'Grinding Height Tolerance',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.control_date', $this->control_date, true);
        $criteria->compare('t.control_time', $this->control_time, true);
        $criteria->compare('t.control_result', $this->control_result, true);
        $criteria->compare('t.job_group', $this->job_group, true);
        $criteria->compare('t.memo', $this->memo, true);
        $criteria->compare('t.quality_control_miling_header_id', $this->quality_control_miling_header_id);
        $criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
        $criteria->compare('t.production_miling_detail_id', $this->production_miling_detail_id);
        $criteria->compare('t.employee_id', $this->employee_id);
        $criteria->compare('t.is_miling', $this->is_miling);
        $criteria->compare('t.is_grinding', $this->is_grinding);
        $criteria->compare('t.is_hardness', $this->is_hardness);
        $criteria->compare('t.is_annelying', $this->is_annelying);
        $criteria->compare('t.is_sidemiling', $this->is_sidemiling);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.sidemiling_length_tolerance', $this->sidemiling_length_tolerance, true);
        $criteria->compare('t.sidemiling_width_tolerance', $this->sidemiling_width_tolerance, true);
        $criteria->compare('t.sidemiling_height_tolerance', $this->sidemiling_height_tolerance, true);
        $criteria->compare('t.grinding_length_tolerance', $this->grinding_length_tolerance, true);
        $criteria->compare('t.grinding_width_tolerance', $this->grinding_width_tolerance, true);
        $criteria->compare('t.grinding_height_tolerance', $this->grinding_height_tolerance, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
