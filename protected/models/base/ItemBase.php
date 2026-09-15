<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $item_category_id
 * @property integer $unit_id
 * @property integer $is_inactive
 * @property integer $account_id_expense
 * @property integer $account_id_inventory
 * @property string $type
 * @property integer $tax_category
 * @property string $tax_percentage
 * @property integer $account_id_cost_of_goods_sold
 * @property integer $account_id_goods_in_transit
 * @property integer $account_id_unbilled_goods
 * @property integer $account_id_sale_transaction
 * @property integer $account_id_sale_discount
 * @property integer $account_id_sale_return
 * @property integer $account_id_purchase_return
 *
 * @property Account $accountIdExpense
 * @property Account $accountIdInventory
 * @property Account $accountIdCostOfGoodsSold
 * @property Account $accountIdGoodsInTransit
 * @property Account $accountIdUnbilledGoods
 * @property Account $accountIdSaleTransaction
 * @property Account $accountIdSaleDiscount
 * @property Account $accountIdSaleReturn
 * @property Account $accountIdPurchaseReturn
 * @property ItemCategory $itemCategory
 * @property Unit $unit
 * @property PurchaseItemDetail[] $purchaseItemDetails
 */
class ItemBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_item';
    }

    public function rules() {
        return array(
            array('code, name, item_category_id, unit_id', 'required'),
            array('item_category_id, unit_id, is_inactive, account_id_expense, account_id_inventory, tax_category, account_id_cost_of_goods_sold, account_id_goods_in_transit, account_id_unbilled_goods, account_id_sale_transaction, account_id_sale_discount, account_id_sale_return, account_id_purchase_return', 'numerical', 'integerOnly' => true),
            array('code, name', 'length', 'max' => 60),
            array('description', 'length', 'max' => 100),
            array('type', 'length', 'max' => 20),
            array('tax_percentage', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, code, name, description, item_category_id, unit_id, is_inactive, account_id_expense, account_id_inventory, type, tax_category, tax_percentage, account_id_cost_of_goods_sold, account_id_goods_in_transit, account_id_unbilled_goods, account_id_sale_transaction, account_id_sale_discount, account_id_sale_return, account_id_purchase_return', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'accountIdExpense' => array(self::BELONGS_TO, 'Account', 'account_id_expense'),
            'accountIdInventory' => array(self::BELONGS_TO, 'Account', 'account_id_inventory'),
            'accountIdCostOfGoodsSold' => array(self::BELONGS_TO, 'Account', 'account_id_cost_of_goods_sold'),
            'accountIdGoodsInTransit' => array(self::BELONGS_TO, 'Account', 'account_id_goods_in_transit'),
            'accountIdUnbilledGoods' => array(self::BELONGS_TO, 'Account', 'account_id_unbilled_goods'),
            'accountIdSaleTransaction' => array(self::BELONGS_TO, 'Account', 'account_id_sale_transaction'),
            'accountIdSaleDiscount' => array(self::BELONGS_TO, 'Account', 'account_id_sale_discount'),
            'accountIdSaleReturn' => array(self::BELONGS_TO, 'Account', 'account_id_sale_return'),
            'accountIdPurchaseReturn' => array(self::BELONGS_TO, 'Account', 'account_id_purchase_return'),
            'itemCategory' => array(self::BELONGS_TO, 'ItemCategory', 'item_category_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'purchaseItemDetails' => array(self::HAS_MANY, 'PurchaseItemDetail', 'item_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'item_category_id' => 'Item Category',
            'unit_id' => 'Unit',
            'is_inactive' => 'Is Inactive',
            'account_id_expense' => 'Account Id Expense',
            'account_id_inventory' => 'Account Id Inventory',
            'type' => 'Type',
            'tax_category' => 'Tax Category',
            'tax_percentage' => 'Tax Percentage',
            'account_id_cost_of_goods_sold' => 'Account Id Cost Of Goods Sold',
            'account_id_goods_in_transit' => 'Account Id Goods In Transit',
            'account_id_unbilled_goods' => 'Account Id Unbilled Goods',
            'account_id_sale_transaction' => 'Account Id Sale Transaction',
            'account_id_sale_discount' => 'Account Id Sale Discount',
            'account_id_sale_return' => 'Account Id Sale Return',
            'account_id_purchase_return' => 'Account Id Purchase Return',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.item_category_id', $this->item_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.account_id_expense', $this->account_id_expense);
        $criteria->compare('t.account_id_inventory', $this->account_id_inventory);
        $criteria->compare('t.type', $this->type, true);
        $criteria->compare('t.tax_category', $this->tax_category);
        $criteria->compare('t.tax_percentage', $this->tax_percentage, true);
        $criteria->compare('t.account_id_cost_of_goods_sold', $this->account_id_cost_of_goods_sold);
        $criteria->compare('t.account_id_goods_in_transit', $this->account_id_goods_in_transit);
        $criteria->compare('t.account_id_unbilled_goods', $this->account_id_unbilled_goods);
        $criteria->compare('t.account_id_sale_transaction', $this->account_id_sale_transaction);
        $criteria->compare('t.account_id_sale_discount', $this->account_id_sale_discount);
        $criteria->compare('t.account_id_sale_return', $this->account_id_sale_return);
        $criteria->compare('t.account_id_purchase_return', $this->account_id_purchase_return);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
