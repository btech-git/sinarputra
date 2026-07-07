<?php

/**
 * @property integer $id
 * @property integer $transaction_ordinal
 * @property integer $transaction_month
 * @property integer $transaction_year
 * @property integer $date
 * @property integer $transaction_type
 * @property string $transaction_subject
 * @property integer $quantity_in
 * @property integer $quantity_out
 * @property string $price
 * @property string $product_name
 * @property integer $product_id
 * @property integer $warehouse_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property Product $product
 * @property Warehouse $warehouse
 * @property Admin $admin
 */
class InventoryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_inventory';
	}

	public function rules()
	{
		return array(
			array('transaction_ordinal, transaction_month, transaction_year, date, transaction_type, transaction_subject, warehouse_id, admin_id', 'required'),
			array('transaction_ordinal, transaction_month, transaction_year, date, transaction_type, quantity_in, quantity_out, product_id, warehouse_id, admin_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('transaction_subject, product_name', 'length', 'max'=>60),
			array('price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, transaction_ordinal, transaction_month, transaction_year, date, transaction_type, transaction_subject, quantity_in, quantity_out, price, product_name, product_id, warehouse_id, admin_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
			'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_ordinal' => 'Transaction Ordinal',
			'transaction_month' => 'Transaction Month',
			'transaction_year' => 'Transaction Year',
			'date' => 'Date',
			'transaction_type' => 'Transaction Type',
			'transaction_subject' => 'Transaction Subject',
			'quantity_in' => 'Quantity In',
			'quantity_out' => 'Quantity Out',
			'price' => 'Price',
			'product_name' => 'Product Name',
			'product_id' => 'Product',
			'warehouse_id' => 'Warehouse',
			'admin_id' => 'Admin',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.transaction_ordinal', $this->transaction_ordinal);
		$criteria->compare('t.transaction_month', $this->transaction_month);
		$criteria->compare('t.transaction_year', $this->transaction_year);
		$criteria->compare('t.date', $this->date);
		$criteria->compare('t.transaction_type', $this->transaction_type);
		$criteria->compare('t.transaction_subject', $this->transaction_subject, true);
		$criteria->compare('t.quantity_in', $this->quantity_in);
		$criteria->compare('t.quantity_out', $this->quantity_out);
		$criteria->compare('t.price', $this->price, true);
		$criteria->compare('t.product_name', $this->product_name, true);
		$criteria->compare('t.product_id', $this->product_id);
		$criteria->compare('t.warehouse_id', $this->warehouse_id);
		$criteria->compare('t.admin_id', $this->admin_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
