<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $company
 * @property string $address_main
 * @property string $address_secondary
 * @property string $city
 * @property string $province
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $bank_account
 * @property integer $invoice_due_days
 * @property string $note
 * @property string $available_credit
 * @property string $credit_limit
 * @property integer $term_of_payment
 * @property string $tax_registration_number
 * @property integer $account_id_payable
 * @property integer $is_tax
 * @property integer $is_inactive
 *
 * @property PurchaseHeader[] $purchaseHeaders
 * @property PurchaseInvoice[] $purchaseInvoices
 * @property PurchaseItemHeader[] $purchaseItemHeaders
 * @property PurchaseReceiptHeader[] $purchaseReceiptHeaders
 * @property ReceiveHeader[] $receiveHeaders
 * @property Account $accountIdPayable
 */
class SupplierBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_supplier';
    }

    public function rules() {
        return array(
            array('name, company, account_id_payable', 'required'),
            array('email', 'email'),
            array('invoice_due_days, term_of_payment, account_id_payable, is_tax, is_inactive', 'numerical', 'integerOnly' => true),
            array('code, tax_registration_number', 'length', 'max' => 20),
            array('name, company, city, province, phone, fax, email, bank_account', 'length', 'max' => 60),
            array('available_credit, credit_limit', 'length', 'max' => 18),
            array('address_main, address_secondary, note', 'safe'),
            // The following rule is used by search().
            array('id, code, name, company, address_main, address_secondary, city, province, phone, fax, email, bank_account, invoice_due_days, note, available_credit, credit_limit, term_of_payment, tax_registration_number, account_id_payable, is_tax, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'supplier_id'),
            'purchaseInvoices' => array(self::HAS_MANY, 'PurchaseInvoice', 'supplier_id'),
            'purchaseItemHeaders' => array(self::HAS_MANY, 'PurchaseItemHeader', 'supplier_id'),
            'purchaseReceiptHeaders' => array(self::HAS_MANY, 'PurchaseReceiptHeader', 'supplier_id'),
            'receiveHeaders' => array(self::HAS_MANY, 'ReceiveHeader', 'supplier_id'),
            'accountIdPayable' => array(self::BELONGS_TO, 'Account', 'account_id_payable'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'company' => 'Company',
            'address_main' => 'Address Main',
            'address_secondary' => 'Address Secondary',
            'city' => 'City',
            'province' => 'Province',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'bank_account' => 'Bank Account',
            'invoice_due_days' => 'Invoice Due Days',
            'note' => 'Note',
            'available_credit' => 'Available Credit',
            'credit_limit' => 'Credit Limit',
            'term_of_payment' => 'Term Of Payment',
            'tax_registration_number' => 'Tax Registration Number',
            'account_id_payable' => 'Account Id Payable',
            'is_tax' => 'Is Tax',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.company', $this->company, true);
        $criteria->compare('t.address_main', $this->address_main, true);
        $criteria->compare('t.address_secondary', $this->address_secondary, true);
        $criteria->compare('t.city', $this->city, true);
        $criteria->compare('t.province', $this->province, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.fax', $this->fax, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.bank_account', $this->bank_account, true);
        $criteria->compare('t.invoice_due_days', $this->invoice_due_days);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.available_credit', $this->available_credit, true);
        $criteria->compare('t.credit_limit', $this->credit_limit, true);
        $criteria->compare('t.term_of_payment', $this->term_of_payment);
        $criteria->compare('t.tax_registration_number', $this->tax_registration_number, true);
        $criteria->compare('t.account_id_payable', $this->account_id_payable);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
