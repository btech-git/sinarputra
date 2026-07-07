<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $time_created
 * @property string $time_edited
 * @property string $customer_order_date
 * @property string $estimate_delivery_date
 * @property string $note
 * @property string $customer_order_number
 * @property integer $quotation_header_id
 * @property integer $customer_id
 * @property integer $employee_id_salesman
 * @property integer $admin_id
 * @property integer $admin_id_edit
 * @property integer $is_replacement
 * @property integer $is_service
 * @property integer $is_order_delayed
 * @property integer $is_original_material
 * @property integer $is_inactive
 *
 * @property SaleDetail[] $saleDetails
 * @property QuotationHeader $quotationHeader
 * @property Customer $customer
 * @property Employee $employeeIdSalesman
 * @property Admin $admin
 * @property Admin $adminIdEdit
 * @property WorkOrderCuttingHeader[] $workOrderCuttingHeaders
 */
class SaleHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_sale_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, customer_id, employee_id_salesman, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, quotation_header_id, customer_id, employee_id_salesman, admin_id, admin_id_edit, is_replacement, is_service, is_order_delayed, is_original_material, is_inactive', 'numerical', 'integerOnly' => true),
            array('customer_order_number', 'length', 'max' => 60),
            array('time_edited, customer_order_date, estimate_delivery_date, note', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, time_created, time_edited, customer_order_date, estimate_delivery_date, note, customer_order_number, quotation_header_id, customer_id, employee_id_salesman, admin_id, admin_id_edit, is_replacement, is_service, is_order_delayed, is_original_material, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'saleDetails' => array(self::HAS_MANY, 'SaleDetail', 'sale_header_id'),
            'quotationHeader' => array(self::BELONGS_TO, 'QuotationHeader', 'quotation_header_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'employeeIdSalesman' => array(self::BELONGS_TO, 'Employee', 'employee_id_salesman'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdEdit' => array(self::BELONGS_TO, 'Admin', 'admin_id_edit'),
            'workOrderCuttingHeaders' => array(self::HAS_MANY, 'WorkOrderCuttingHeader', 'sale_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'time_created' => 'Time Created',
            'time_edited' => 'Time Edited',
            'customer_order_date' => 'Customer Order Date',
            'estimate_delivery_date' => 'Estimate Delivery Date',
            'note' => 'Note',
            'customer_order_number' => 'Customer Order Number',
            'quotation_header_id' => 'Quotation Header',
            'customer_id' => 'Customer',
            'employee_id_salesman' => 'Employee Id Salesman',
            'admin_id' => 'Admin',
            'admin_id_edit' => 'Admin Id Edit',
            'is_replacement' => 'Is Replacement',
            'is_service' => 'Is Service',
            'is_order_delayed' => 'Is Order Delayed',
            'is_original_material' => 'Lembaran / Batang',
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
        $criteria->compare('t.time_created', $this->time_created, true);
        $criteria->compare('t.time_edited', $this->time_edited, true);
        $criteria->compare('t.customer_order_date', $this->customer_order_date, true);
        $criteria->compare('t.estimate_delivery_date', $this->estimate_delivery_date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_order_number', $this->customer_order_number, true);
        $criteria->compare('t.quotation_header_id', $this->quotation_header_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.employee_id_salesman', $this->employee_id_salesman);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.admin_id_edit', $this->admin_id_edit);
        $criteria->compare('t.is_replacement', $this->is_replacement);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_order_delayed', $this->is_order_delayed);
        $criteria->compare('t.is_original_material', $this->is_original_material);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
