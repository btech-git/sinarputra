<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $date_invoice_sent
 * @property string $customer_address
 * @property string $customer_city
 * @property string $driver
 * @property string $delivery_status
 * @property string $note
 * @property integer $work_order_cutting_header_id
 * @property integer $warehouse_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property ManualDeliveryDetail[] $manualDeliveryDetails
 * @property WorkOrderCuttingHeader $workOrderCuttingHeader
 * @property Warehouse $warehouse
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 */
class ManualDeliveryHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_manual_delivery_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, work_order_cutting_header_id, warehouse_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, work_order_cutting_header_id, warehouse_id, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('customer_city, driver, delivery_status', 'length', 'max' => 60),
            array('customer_address, note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, date_invoice_sent, customer_address, customer_city, driver, delivery_status, note, work_order_cutting_header_id, warehouse_id, admin_id, is_inactive, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'manualDeliveryDetails' => array(self::HAS_MANY, 'ManualDeliveryDetail', 'manual_delivery_header_id'),
            'workOrderCuttingHeader' => array(self::BELONGS_TO, 'WorkOrderCuttingHeader', 'work_order_cutting_header_id'),
            'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'date_invoice_sent' => 'Date Invoice Sent',
            'customer_address' => 'Customer Address',
            'customer_city' => 'Customer City',
            'driver' => 'Driver',
            'delivery_status' => 'Delivery Status',
            'note' => 'Note',
            'work_order_cutting_header_id' => 'Work Order Cutting Header',
            'warehouse_id' => 'Warehouse',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.date_invoice_sent', $this->date_invoice_sent, true);
        $criteria->compare('t.customer_address', $this->customer_address, true);
        $criteria->compare('t.customer_city', $this->customer_city, true);
        $criteria->compare('t.driver', $this->driver, true);
        $criteria->compare('t.delivery_status', $this->delivery_status, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
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
