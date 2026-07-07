<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $note
 * @property integer $total_quantity_production_remaining
 * @property integer $work_order_cutting_header_id
 * @property integer $work_order_replacement_header_id
 * @property integer $customer_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property ProductionCuttingHeader[] $productionCuttingHeaders
 * @property ProductionPlanningCuttingDetail[] $productionPlanningCuttingDetails
 * @property Customer $customer
 * @property WorkOrderCuttingHeader $workOrderCuttingHeader
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property WorkOrderReplacementHeader $workOrderReplacementHeader
 */
class ProductionPlanningCuttingHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_production_planning_cutting_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, customer_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, work_order_cutting_header_id, work_order_replacement_header_id, customer_id, admin_id, is_inactive, total_quantity_production_remaining, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, note, work_order_cutting_header_id, work_order_replacement_header_id, customer_id, admin_id, is_inactive, total_quantity_production_remaining, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'productionCuttingHeaders' => array(self::HAS_MANY, 'ProductionCuttingHeader', 'production_planning_cutting_header_id'),
            'productionPlanningCuttingDetails' => array(self::HAS_MANY, 'ProductionPlanningCuttingDetail', 'production_planning_cutting_header_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'workOrderCuttingHeader' => array(self::BELONGS_TO, 'WorkOrderCuttingHeader', 'work_order_cutting_header_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'workOrderReplacementHeader' => array(self::BELONGS_TO, 'WorkOrderReplacementHeader', 'work_order_replacement_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'note' => 'Note',
            'work_order_cutting_header_id' => 'Work Order Cutting Header',
            'work_order_replacement_header_id' => 'Work Order Replacement Header',
            'customer_id' => 'Customer',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
            'total_quantity_production_remaining' => 'Total Quantity Production Remaining',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.total_quantity_production_remaining', $this->total_quantity_production_remaining);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.work_order_replacement_header_id', $this->work_order_replacement_header_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
