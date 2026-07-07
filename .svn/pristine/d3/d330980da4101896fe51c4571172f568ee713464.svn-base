<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $estimate_receive_date
 * @property integer $payment_period
 * @property string $discount
 * @property string $note
 * @property integer $supplier_id
 * @property integer $admin_id
 * @property integer $admin_purchasing_id
 * @property integer $admin_accounting_id
 * @property integer $admin_finance_id
 * @property integer $is_tax
 * @property integer $is_tax_income
 * @property integer $is_inactive
 * @property integer $tax_percentage
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property PurchaseItemDetail[] $purchaseItemDetails
 * @property Supplier $supplier
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property ReceiveItemHeader[] $receiveItemHeaders
 */
class PurchaseItemHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_purchase_item_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, estimate_receive_date, supplier_id, admin_id, admin_purchasing_id, admin_accounting_id, admin_finance_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, payment_period, supplier_id, admin_id, is_tax, is_tax_income, is_inactive, tax_percentage, admin_purchasing_id, admin_accounting_id, admin_finance_id, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('discount', 'length', 'max' => 18),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, estimate_receive_date, payment_period, discount, note, supplier_id, admin_id, is_tax, is_tax_income, is_inactive, tax_percentage, admin_purchasing_id, admin_accounting_id, admin_finance_id, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseItemDetails' => array(self::HAS_MANY, 'PurchaseItemDetail', 'purchase_item_header_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminPurchasing' => array(self::BELONGS_TO, 'Admin', 'admin_purchasing_id'),
            'adminAccounting' => array(self::BELONGS_TO, 'Admin', 'admin_accounting_id'),
            'adminFinance' => array(self::BELONGS_TO, 'Admin', 'admin_finance_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'receiveItemHeaders' => array(self::HAS_MANY, 'ReceiveItemHeader', 'purchase_item_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'estimate_receive_date' => 'Estimate Receive Date',
            'payment_period' => 'Payment Period',
            'discount' => 'Discount',
            'note' => 'Note',
            'supplier_id' => 'Supplier',
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
        $criteria->compare('t.estimate_receive_date', $this->estimate_receive_date, true);
        $criteria->compare('t.payment_period', $this->payment_period);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
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
