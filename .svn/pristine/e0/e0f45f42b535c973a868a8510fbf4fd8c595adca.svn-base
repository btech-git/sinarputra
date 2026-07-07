<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $stock_minimum
 * @property string $purchasing_price
 * @property string $selling_price
 * @property string $description
 * @property integer $product_category_id
 * @property integer $unit_id
 * @property integer $is_inactive
 *
 * @property AdjustmentDetail[] $adjustmentDetails
 * @property Inventory[] $inventories
 * @property ProductCategory $productCategory
 * @property Unit $unit
 * @property ProductSize[] $productSizes
 * @property QuotationReturnDetail[] $quotationReturnDetails
 */
class ProductBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_product';
    }

    public function rules() {
        return array(
            array('code, name, product_category_id, unit_id', 'required'),
            array('stock_minimum, product_category_id, unit_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 20),
            array('name', 'length', 'max' => 60),
            array('purchasing_price, selling_price', 'length', 'max' => 18),
            array('description', 'safe'),
            // The following rule is used by search().
            array('id, code, name, stock_minimum, purchasing_price, selling_price, description, product_category_id, unit_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'adjustmentDetails' => array(self::HAS_MANY, 'AdjustmentDetail', 'product_id'),
            'inventories' => array(self::HAS_MANY, 'Inventory', 'product_id'),
            'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'productSizes' => array(self::HAS_MANY, 'ProductSize', 'product_id'),
            'quotationReturnDetails' => array(self::HAS_MANY, 'QuotationReturnDetail', 'product_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'stock_minimum' => 'Stock Minimum',
            'purchasing_price' => 'Purchasing Price',
            'selling_price' => 'Selling Price',
            'description' => 'Description',
            'product_category_id' => 'Product Category',
            'unit_id' => 'Unit',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.stock_minimum', $this->stock_minimum);
        $criteria->compare('t.purchasing_price', $this->purchasing_price, true);
        $criteria->compare('t.selling_price', $this->selling_price, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
