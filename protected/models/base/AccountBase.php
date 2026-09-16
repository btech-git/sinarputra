<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $account_category_id
 * @property integer $is_inactive
 * @property string $type
 * @property string $normal_balance
 *
 * @property AccountCategory $accountCategory
 * @property Customer[] $customers
 * @property DepositDetail[] $depositDetails
 * @property DepositHeader[] $depositHeaders
 * @property ExpenseDetail[] $expenseDetails
 * @property ExpenseHeader[] $expenseHeaders
 * @property Item[] $items
 * @property Item[] $items1
 * @property Item[] $items2
 * @property Item[] $items3
 * @property Item[] $items4
 * @property Item[] $items5
 * @property Item[] $items6
 * @property Item[] $items7
 * @property Item[] $items8
 * @property JournalAccounting[] $journalAccountings
 * @property JournalVoucherDetail[] $journalVoucherDetails
 * @property ManualSalePaymentDetail[] $manualSalePaymentDetails
 * @property ManualSalePaymentDetail[] $manualSalePaymentDetails1
 * @property ManualSalePaymentDetail[] $manualSalePaymentDetails2
 * @property ManualSalePaymentHeader[] $manualSalePaymentHeaders
 * @property ManualSalePaymentHeader[] $manualSalePaymentHeaders1
 * @property MaterialPaymentDetail[] $materialPaymentDetails
 * @property MaterialPaymentDetail[] $materialPaymentDetails1
 * @property MaterialPaymentDetail[] $materialPaymentDetails2
 * @property MaterialPaymentHeader[] $materialPaymentHeaders
 * @property MaterialPaymentHeader[] $materialPaymentHeaders1
 * @property PurchaseHeader[] $purchaseHeaders
 * @property PurchaseItemDetail[] $purchaseItemDetails
 * @property PurchaseItemHeader[] $purchaseItemHeaders
 * @property PurchasePaymentDetail[] $purchasePaymentDetails
 * @property SalePaymentDetail[] $salePaymentDetails
 * @property SalePaymentHeader[] $salePaymentHeaders
 * @property SalePaymentHeader[] $salePaymentHeaders1
 */
class AccountBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_account';
    }

    public function rules() {
        return array(
            array('name, account_category_id', 'required'),
            array('account_category_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('code, name, type, normal_balance', 'length', 'max' => 60),
            // The following rule is used by search().
            array('id, code, name, account_category_id, is_inactive, type, normal_balance', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'accountCategory' => array(self::BELONGS_TO, 'AccountCategory', 'account_category_id'),
            'customers' => array(self::HAS_MANY, 'Customer', 'account_id_receivable'),
            'depositDetails' => array(self::HAS_MANY, 'DepositDetail', 'account_id'),
            'depositHeaders' => array(self::HAS_MANY, 'DepositHeader', 'account_id'),
            'expenseDetails' => array(self::HAS_MANY, 'ExpenseDetail', 'account_id'),
            'expenseHeaders' => array(self::HAS_MANY, 'ExpenseHeader', 'account_id'),
            'items' => array(self::HAS_MANY, 'Item', 'account_id_expense'),
            'items1' => array(self::HAS_MANY, 'Item', 'account_id_inventory'),
            'items2' => array(self::HAS_MANY, 'Item', 'account_id_cost_of_goods_sold'),
            'items3' => array(self::HAS_MANY, 'Item', 'account_id_goods_in_transit'),
            'items4' => array(self::HAS_MANY, 'Item', 'account_id_unbilled_goods'),
            'items5' => array(self::HAS_MANY, 'Item', 'account_id_sale_transaction'),
            'items6' => array(self::HAS_MANY, 'Item', 'account_id_sale_discount'),
            'items7' => array(self::HAS_MANY, 'Item', 'account_id_sale_return'),
            'items8' => array(self::HAS_MANY, 'Item', 'account_id_purchase_return'),
            'journalAccountings' => array(self::HAS_MANY, 'JournalAccounting', 'account_id'),
            'journalVoucherDetails' => array(self::HAS_MANY, 'JournalVoucherDetail', 'account_id'),
            'manualSalePaymentDetails' => array(self::HAS_MANY, 'ManualSalePaymentDetail', 'account_id'),
            'manualSalePaymentDetails1' => array(self::HAS_MANY, 'ManualSalePaymentDetail', 'account_id_additional_payment_1'),
            'manualSalePaymentDetails2' => array(self::HAS_MANY, 'ManualSalePaymentDetail', 'account_id_additional_payment_2'),
            'manualSalePaymentHeaders' => array(self::HAS_MANY, 'ManualSalePaymentHeader', 'account_id_additional_payment_1'),
            'manualSalePaymentHeaders1' => array(self::HAS_MANY, 'ManualSalePaymentHeader', 'account_id_additional_payment_2'),
            'materialPaymentDetails' => array(self::HAS_MANY, 'MaterialPaymentDetail', 'account_id'),
            'materialPaymentDetails1' => array(self::HAS_MANY, 'MaterialPaymentDetail', 'account_id_additional_payment_1'),
            'materialPaymentDetails2' => array(self::HAS_MANY, 'MaterialPaymentDetail', 'account_id_additional_payment_2'),
            'materialPaymentHeaders' => array(self::HAS_MANY, 'MaterialPaymentHeader', 'account_id_additional_payment_1'),
            'materialPaymentHeaders1' => array(self::HAS_MANY, 'MaterialPaymentHeader', 'account_id_additional_payment_2'),
            'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'account_id_expense'),
            'purchaseItemDetails' => array(self::HAS_MANY, 'PurchaseItemDetail', 'account_id_expense'),
            'purchaseItemHeaders' => array(self::HAS_MANY, 'PurchaseItemHeader', 'account_id_expense'),
            'purchasePaymentDetails' => array(self::HAS_MANY, 'PurchasePaymentDetail', 'account_id'),
            'salePaymentDetails' => array(self::HAS_MANY, 'SalePaymentDetail', 'account_id'),
            'salePaymentHeaders' => array(self::HAS_MANY, 'SalePaymentHeader', 'account_id_additional_payment_1'),
            'salePaymentHeaders1' => array(self::HAS_MANY, 'SalePaymentHeader', 'account_id_additional_payment_2'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'account_category_id' => 'Account Category',
            'is_inactive' => 'Is Inactive',
            'type' => 'Type',
            'normal_balance' => 'Normal Balance',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.account_category_id', $this->account_category_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.type', $this->type, true);
        $criteria->compare('t.normal_balance', $this->normal_balance, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}