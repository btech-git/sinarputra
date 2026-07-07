<?php

/**
 * @property integer $id
 * @property string $product_name
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $unit_price
 * @property integer $quantity
 * @property string $weight
 * @property integer $product_category_id
 * @property integer $purchase_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $is_inactive
 *
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property ProductCategory $productCategory
 * @property PurchaseHeader $purchaseHeader
 * @property ReceiveDetail[] $receiveDetails
 */
class PurchaseDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_purchase_detail';
	}

	public function rules()
	{
		return array(
			array('product_name, product_category_id, purchase_header_id, is_inactive', 'required'),
			array('quantity, product_category_id, purchase_header_id, work_order_cutting_detail_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('product_name', 'length', 'max'=>60),
			array('length, width, height, weight', 'length', 'max'=>10),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, product_name, length, width, height, unit_price, quantity, weight, product_category_id, purchase_header_id, work_order_cutting_detail_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
			'purchaseHeader' => array(self::BELONGS_TO, 'PurchaseHeader', 'purchase_header_id'),
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'purchase_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_name' => 'Product Name',
			'length' => 'Length',
			'width' => 'Width',
			'height' => 'Height',
			'unit_price' => 'Unit Price',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'product_category_id' => 'Product Category',
			'purchase_header_id' => 'Purchase Header',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.product_name', $this->product_name, true);
		$criteria->compare('t.length', $this->length, true);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.unit_price', $this->unit_price, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.product_category_id', $this->product_category_id);
		$criteria->compare('t.purchase_header_id', $this->purchase_header_id);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
