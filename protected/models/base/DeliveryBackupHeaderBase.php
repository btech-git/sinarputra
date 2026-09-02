<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $transaction_date
 * @property string $customer_address
 * @property string $customer_city
 * @property integer $employee_id_driver
 * @property string $note
 * @property integer $customer_id
 * @property integer $warehouse_id
 * @property integer $admin_id
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 * @property integer $is_inactive
 * @property string $purchase_order_number
 * @property string $work_order_number
 *
 * @property DeliveryBackupDetail[] $deliveryBackupDetails
 * @property Customer $customer
 * @property Warehouse $warehouse
 * @property Admin $admin
 * @property Admin $adminIdUpdated
 * @property Employee $employeeIdDriver
 */
class DeliveryBackupHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_delivery_backup_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, transaction_date, customer_id, admin_id, created_datetime', 'required'),
            array('cn_ordinal, cn_month, cn_year, employee_id_driver, customer_id, warehouse_id, admin_id, admin_id_updated, is_inactive', 'numerical', 'integerOnly' => true),
            array('customer_city', 'length', 'max' => 60),
            array('purchase_order_number, work_order_number', 'length', 'max' => 20),
            array('customer_address, note, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, transaction_date, customer_address, customer_city, employee_id_driver, note, customer_id, warehouse_id, admin_id, created_datetime, admin_id_updated, updated_datetime, is_inactive, purchase_order_number, work_order_number', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'deliveryBackupDetails' => array(self::HAS_MANY, 'DeliveryBackupDetail', 'delivery_backup_header_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'employeeIdDriver' => array(self::BELONGS_TO, 'Employee', 'employee_id_driver'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'transaction_date' => 'Transaction Date',
            'customer_address' => 'Customer Address',
            'customer_city' => 'Customer City',
            'employee_id_driver' => 'Employee Id Driver',
            'note' => 'Note',
            'customer_id' => 'Customer',
            'warehouse_id' => 'Warehouse',
            'admin_id' => 'Admin',
            'created_datetime' => 'Created Datetime',
            'admin_id_updated' => 'Admin Id Updated',
            'updated_datetime' => 'Updated Datetime',
            'is_inactive' => 'Is Inactive',
            'purchase_order_number' => 'Purchase Order Number',
            'work_order_number' => 'Work Order Number',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.transaction_date', $this->transaction_date, true);
        $criteria->compare('t.customer_address', $this->customer_address, true);
        $criteria->compare('t.customer_city', $this->customer_city, true);
        $criteria->compare('t.employee_id_driver', $this->employee_id_driver);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.created_datetime', $this->created_datetime, true);
        $criteria->compare('t.admin_id_updated', $this->admin_id_updated);
        $criteria->compare('t.updated_datetime', $this->updated_datetime, true);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.purchase_order_number', $this->purchase_order_number, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}