<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $due_date
 * @property string $date_created
 * @property string $date_receipt
 * @property string $tax_number
 * @property string $note
 * @property string $discount
 * @property string $rounding_nominal
 * @property string $grand_total
 * @property string $total_return
 * @property string $total_payment
 * @property integer $service_type
 * @property integer $work_order_cutting_header_id
 * @property integer $customer_id
 * @property integer $employee_id_salesman
 * @property integer $admin_id
 * @property integer $is_tax
 * @property integer $is_tax_income
 * @property integer $is_inactive
 * @property integer $tax_percentage
 * @property string $time_created
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property SaleInvoiceDetail[] $saleInvoiceDetails
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property Customer $customer
 * @property Employee $employeeIdSalesman
 * @property WorkOrderCuttingHeader $workOrderCuttingHeader
 * @property SalePaymentDetail[] $salePaymentDetails
 * @property SaleReceiptDetail[] $saleReceiptDetails
 */
class SaleInvoiceHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_sale_invoice_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, due_date, date_created, work_order_cutting_header_id, customer_id, employee_id_salesman, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, service_type, work_order_cutting_header_id, customer_id, employee_id_salesman, admin_id, is_tax, is_tax_income, is_inactive, tax_percentage, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('tax_number', 'length', 'max' => 60),
            array('discount, rounding_nominal, grand_total, total_return, total_payment', 'length', 'max' => 18),
            array('date_receipt, note, time_created, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, due_date, date_created, date_receipt, tax_number, note, discount, rounding_nominal, grand_total, total_return, total_payment, service_type, work_order_cutting_header_id, customer_id, employee_id_salesman, admin_id, is_tax, is_tax_income, is_inactive, tax_percentage, admin_id_updated, time_created, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'saleInvoiceDetails' => array(self::HAS_MANY, 'SaleInvoiceDetail', 'sale_invoice_header_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'employeeIdSalesman' => array(self::BELONGS_TO, 'Employee', 'employee_id_salesman'),
            'workOrderCuttingHeader' => array(self::BELONGS_TO, 'WorkOrderCuttingHeader', 'work_order_cutting_header_id'),
            'salePaymentDetails' => array(self::HAS_MANY, 'SalePaymentDetail', 'sale_invoice_header_id'),
            'saleReceiptDetails' => array(self::HAS_MANY, 'SaleReceiptDetail', 'sale_invoice_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'due_date' => 'Due Date',
            'date_created' => 'Date Created',
            'date_receipt' => 'Date Receipt',
            'tax_number' => 'Tax Number',
            'note' => 'Note',
            'discount' => 'Discount',
            'rounding_nominal' => 'Rounding Nominal',
            'grand_total' => 'Grand Total',
            'total_return' => 'Total Return',
            'total_payment' => 'Total Payment',
            'service_type' => 'Service Type',
            'work_order_cutting_header_id' => 'Work Order Cutting Header',
            'customer_id' => 'Customer',
            'employee_id_salesman' => 'Employee Id Salesman',
            'admin_id' => 'Admin',
            'is_tax' => 'Is Tax',
            'is_tax_income' => 'Is Tax Income',
            'is_inactive' => 'Is Inactive',
            'tax_percentage' => 'Tax Percentage',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.due_date', $this->due_date, true);
        $criteria->compare('t.date_created', $this->date_created, true);
        $criteria->compare('t.date_receipt', $this->date_receipt, true);
        $criteria->compare('t.tax_number', $this->tax_number, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.rounding_nominal', $this->rounding_nominal, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.total_return', $this->total_return, true);
        $criteria->compare('t.total_payment', $this->total_payment, true);
        $criteria->compare('t.service_type', $this->service_type);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.employee_id_salesman', $this->employee_id_salesman);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_tax_income', $this->is_tax_income);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
