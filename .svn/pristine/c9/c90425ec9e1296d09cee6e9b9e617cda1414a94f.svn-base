<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $note
 * @property string $time_created
 * @property integer $total_quantity_cutting_planning_remaining
 * @property integer $total_quantity_delivery_remaining
 * @property integer $sale_header_id
 * @property integer $admin_id
 * @property integer $is_service
 * @property integer $is_miling_additional
 * @property integer $is_pending
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property DeliveryHeader[] $deliveryHeaders
 * @property ProductionPlanningCuttingHeader[] $productionPlanningCuttingHeaders
 * @property ProductionPlanningMilingHeader[] $productionPlanningMilingHeaders
 * @property QualityControlCuttingHeader[] $qualityControlCuttingHeaders
 * @property QualityControlMilingHeader[] $qualityControlMilingHeaders
 * @property SaleInvoiceHeader[] $saleInvoiceHeaders
 * @property ManualSaleInvoiceHeader[] $manualSaleInvoiceHeaders
 * @property WorkOrderCuttingDetail[] $workOrderCuttingDetails
 * @property SaleHeader $saleHeader
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property WorkOrderReplacementHeader[] $workOrderReplacementHeaders
 */
class WorkOrderCuttingHeaderBase extends MonthlyTransactionActiveRecord {

    public $search_sale_invoice_number;
    public $search_sale_invoice_date;
    public $search_sale_receipt_number;
    public $search_sale_receipt_date;
    public $search_manual_sale_invoice_number;
    public $search_manual_sale_invoice_date;
    public $search_manual_sale_receipt_number;
    public $search_manual_sale_receipt_date;
    public $search_quality_control_cutting_number;
    public $search_quality_control_cutting_date;
    public $search_delivery_cutting_number;
    public $search_delivery_cutting_date;
    public $search_quality_control_miling_number;
    public $search_quality_control_miling_date;
    public $search_delivery_miling_number;
    public $search_delivery_miling_date;
    
    public function tableName() {
        return 'tblsp_work_order_cutting_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, time_created, sale_header_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, sale_header_id, admin_id, is_service, is_miling_additional, is_pending, is_inactive, total_quantity_delivery_remaining, total_quantity_cutting_planning_remaining, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('cn_ordinal', 'uniqueValidator', 'attributeName' => array('cn_ordinal', 'cn_month', 'cn_year'), 'on' => 'insert'),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, note, time_created, sale_header_id, admin_id, is_service, is_miling_additional, is_pending, is_inactive, total_quantity_delivery_remaining, total_quantity_cutting_planning_remaining, search_sale_invoice_number, search_sale_invoice_date, search_manual_sale_invoice_number, search_manual_sale_invoice_date, search_sale_receipt_number, search_sale_receipt_date, search_manual_sale_receipt_number, search_manual_sale_receipt_date, search_quality_control_cutting_number, search_quality_control_cutting_date, search_delivery_cutting_number, search_delivery_cutting_date, search_quality_control_miling_number, search_quality_control_miling_date, search_delivery_miling_number, search_delivery_miling_date, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'work_order_cutting_header_id'),
            'productionPlanningCuttingHeaders' => array(self::HAS_MANY, 'ProductionPlanningCuttingHeader', 'work_order_cutting_header_id'),
            'productionPlanningMilingHeaders' => array(self::HAS_MANY, 'ProductionPlanningMilingHeader', 'work_order_cutting_header_id'),
            'qualityControlCuttingHeaders' => array(self::HAS_MANY, 'QualityControlCuttingHeader', 'work_order_cutting_header_id'),
            'qualityControlMilingHeaders' => array(self::HAS_MANY, 'QualityControlMilingHeader', 'work_order_cutting_header_id'),
            'saleInvoiceHeaders' => array(self::HAS_MANY, 'SaleInvoiceHeader', 'work_order_cutting_header_id'),
            'manualSaleInvoiceHeaders' => array(self::HAS_MANY, 'ManualSaleInvoiceHeader', 'work_order_cutting_header_id'),
            'workOrderCuttingDetails' => array(self::HAS_MANY, 'WorkOrderCuttingDetail', 'work_order_cutting_header_id'),
            'saleHeader' => array(self::BELONGS_TO, 'SaleHeader', 'sale_header_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'workOrderReplacementHeaders' => array(self::HAS_MANY, 'WorkOrderReplacementHeader', 'work_order_cutting_header_id'),
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
            'time_created' => 'Time Created',
            'sale_header_id' => 'Sale Header',
            'admin_id' => 'Admin',
            'is_service' => 'Is Service',
            'is_miling_additional' => 'Is Miling Additional',
            'is_pending' => 'Is Pending',
            'is_inactive' => 'Is Inactive',
            'total_quantity_delivery_remaining' => 'Total Delivery Remaining',
            'total_quantity_cutting_planning_remaining' => 'Total Production Cutting Remaining',
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
        $criteria->compare('t.time_created', $this->time_created, true);
        $criteria->compare('t.sale_header_id', $this->sale_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_miling_additional', $this->is_miling_additional);
        $criteria->compare('t.is_pending', $this->is_pending);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.total_quantity_delivery_remaining', $this->total_quantity_delivery_remaining);
        $criteria->compare('t.total_quantity_cutting_planning_remaining', $this->total_quantity_cutting_planning_remaining);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
}