<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $date_created
 * @property string $name
 * @property string $company
 * @property string $address_main
 * @property string $address_secondary
 * @property string $city
 * @property string $province
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $note
 * @property integer $invoice_due_days
 * @property string $available_credit
 * @property string $credit_limit
 * @property string $discount_default
 * @property string $tax_registration_number
 * @property string $tax_name
 * @property string $tax_address_main
 * @property string $tax_address_secondary
 * @property integer $customer_type
 * @property integer $employee_id
 * @property integer $account_id_receivable
 * @property integer $customer_area_id
 * @property integer $is_tax
 * @property integer $is_delivery_approval_needed
 * @property integer $is_inactive
 * @property integer $admin_id_updated
 * @property string $date_updated
 *
 * @property Employee $employee
 * @property Account $accountIdReceivable
 * @property CustomerArea $customerArea
 * @property ManualSaleInvoiceHeader[] $manualSaleInvoiceHeaders
 * @property ManualSalePaymentHeader[] $manualSalePaymentHeaders
 * @property ManualSaleReceiptHeader[] $manualSaleReceiptHeaders
 * @property ProductionPlanningCuttingHeader[] $productionPlanningCuttingHeaders
 * @property ProductionPlanningMilingHeader[] $productionPlanningMilingHeaders
 * @property QuotationHeader[] $quotationHeaders
 * @property QuotationReturnHeader[] $quotationReturnHeaders
 * @property SaleHeader[] $saleHeaders
 * @property SaleInvoiceHeader[] $saleInvoiceHeaders
 * @property SalePaymentHeader[] $salePaymentHeaders
 * @property SaleReceiptHeader[] $saleReceiptHeaders
 * @property Admin $adminIdUpdated
 */
class CustomerBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_customer';
    }

    public function rules() {
        return array(
            array('code, date_created, name, company, account_id_receivable, customer_area_id', 'required'),
            array('email', 'email'),
            array('invoice_due_days, customer_type, employee_id, account_id_receivable, customer_area_id, is_tax, is_delivery_approval_needed, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('code, phone, fax', 'length', 'max' => 20),
            array('name, company, city, province, email, tax_name, tax_registration_number', 'length', 'max' => 60),
            array('available_credit, credit_limit', 'length', 'max' => 18),
            array('discount_default', 'length', 'max' => 10),
            array('address_main, address_secondary, note, tax_address_main, tax_address_secondary, date_updated', 'safe'),
            // The following rule is used by search().
            array('id, code, date_created, name, company, address_main, address_secondary, city, province, phone, fax, email, note, invoice_due_days, available_credit, credit_limit, discount_default, tax_registration_number, tax_name, tax_address_main, tax_address_secondary, customer_type, employee_id, account_id_receivable, customer_area_id, is_tax, is_delivery_approval_needed, is_inactive, admin_id_updated, date_updated', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'accountIdReceivable' => array(self::BELONGS_TO, 'Account', 'account_id_receivable'),
            'customerArea' => array(self::BELONGS_TO, 'CustomerArea', 'customer_area_id'),
            'manualSaleInvoiceHeaders' => array(self::HAS_MANY, 'ManualSaleInvoiceHeader', 'customer_id'),
            'manualSalePaymentHeaders' => array(self::HAS_MANY, 'ManualSalePaymentHeader', 'customer_id'),
            'manualSaleReceiptHeaders' => array(self::HAS_MANY, 'ManualSaleReceiptHeader', 'customer_id'),
            'productionPlanningCuttingHeaders' => array(self::HAS_MANY, 'ProductionPlanningCuttingHeader', 'customer_id'),
            'productionPlanningMilingHeaders' => array(self::HAS_MANY, 'ProductionPlanningMilingHeader', 'customer_id'),
            'quotationHeaders' => array(self::HAS_MANY, 'QuotationHeader', 'customer_id'),
            'quotationReturnHeaders' => array(self::HAS_MANY, 'QuotationReturnHeader', 'customer_id'),
            'saleHeaders' => array(self::HAS_MANY, 'SaleHeader', 'customer_id'),
            'saleInvoiceHeaders' => array(self::HAS_MANY, 'SaleInvoiceHeader', 'customer_id'),
            'salePaymentHeaders' => array(self::HAS_MANY, 'SalePaymentHeader', 'customer_id'),
            'saleReceiptHeaders' => array(self::HAS_MANY, 'SaleReceiptHeader', 'customer_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'date_created' => 'Date Created',
            'name' => 'Name',
            'company' => 'Company',
            'address_main' => 'Address Main',
            'address_secondary' => 'Address Secondary',
            'city' => 'City',
            'province' => 'Province',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'note' => 'Note',
            'invoice_due_days' => 'Invoice Due Days',
            'available_credit' => 'Available Credit',
            'credit_limit' => 'Credit Limit',
            'discount_default' => 'Discount Default',
            'tax_registration_number' => 'Tax Registration Number',
            'tax_name' => 'Tax Name',
            'tax_address_main' => 'Tax Address Main',
            'tax_address_secondary' => 'Tax Address Secondary',
            'customer_type' => 'Customer Type',
            'employee_id' => 'Employee',
            'account_id_receivable' => 'Account Id Receivable',
            'customer_area_id' => 'Customer Area',
            'is_tax' => 'Is Tax',
            'is_delivery_approval_needed' => 'Is Delivery Approval Needed',
            'is_inactive' => 'Is Inactive',
            'admin_id_updated' => 'User Updated',
            'date_updated' => 'Date Updated',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.date_created', $this->date_created, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.company', $this->company, true);
        $criteria->compare('t.address_main', $this->address_main, true);
        $criteria->compare('t.address_secondary', $this->address_secondary, true);
        $criteria->compare('t.city', $this->city, true);
        $criteria->compare('t.province', $this->province, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.fax', $this->fax, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.invoice_due_days', $this->invoice_due_days);
        $criteria->compare('t.available_credit', $this->available_credit, true);
        $criteria->compare('t.credit_limit', $this->credit_limit, true);
        $criteria->compare('t.discount_default', $this->discount_default, true);
        $criteria->compare('t.tax_registration_number', $this->tax_registration_number, true);
        $criteria->compare('t.tax_name', $this->tax_name, true);
        $criteria->compare('t.tax_address_main', $this->tax_address_main, true);
        $criteria->compare('t.tax_address_secondary', $this->tax_address_secondary, true);
        $criteria->compare('t.customer_type', $this->customer_type);
        $criteria->compare('t.employee_id', $this->employee_id);
        $criteria->compare('t.account_id_receivable', $this->account_id_receivable);
        $criteria->compare('t.customer_area_id', $this->customer_area_id);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_delivery_approval_needed', $this->is_delivery_approval_needed);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.date_updated', $this->date_updated, true);
        $criteria->compare('t.admin_id_updated', $this->admin_id_updated);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
