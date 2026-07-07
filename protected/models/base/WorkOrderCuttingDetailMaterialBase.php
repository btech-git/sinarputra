<?php

/**
 * @property integer $id
 * @property string $product_name
 * @property string $serial_number
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $quantity
 * @property string $weight
 * @property string $weight_tolerance
 * @property integer $work_order_cutting_detail_id
 * @property integer $work_order_replacement_detail_id
 * @property integer $work_order_cutting_detail_material_id
 * @property integer $receive_detail_id
 * @property integer $product_category_id
 * @property integer $location_id
 * @property integer $material_type
 * @property integer $is_approved
 * @property integer $is_offcart
 * @property integer $is_inactive
 *
 * @property WorkOrderReplacementDetail $workOrderReplacementDetail
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property WorkOrderCuttingDetailMaterial $workOrderCuttingDetailMaterial
 * @property WorkOrderCuttingDetailMaterial[] $workOrderCuttingDetailMaterials
 * @property ReceiveDetail $receiveDetail
 * @property ProductCategory $productCategory
 * @property Location $location
 */
class WorkOrderCuttingDetailMaterialBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_work_order_cutting_detail_material';
	}

	public function rules()
	{
		return array(
			array('location_id', 'required'),
			array('quantity, work_order_cutting_detail_id, work_order_replacement_detail_id, work_order_cutting_detail_material_id, receive_detail_id, product_category_id, location_id, material_type, is_approved, is_offcart, is_inactive', 'numerical', 'integerOnly'=>true),
			array('product_name, serial_number', 'length', 'max'=>60),
			array('length, width, height, weight, weight_tolerance', 'length', 'max'=>10),
			// The following rule is used by search().
			array('id, product_name, serial_number, length, width, height, quantity, weight, weight_tolerance, work_order_cutting_detail_id, work_order_replacement_detail_id, work_order_cutting_detail_material_id, receive_detail_id, product_category_id, location_id, material_type, is_approved, is_offcart, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'workOrderReplacementDetail' => array(self::BELONGS_TO, 'WorkOrderReplacementDetail', 'work_order_replacement_detail_id'),
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'workOrderCuttingDetailMaterial' => array(self::BELONGS_TO, 'WorkOrderCuttingDetailMaterial', 'work_order_cutting_detail_material_id'),
			'workOrderCuttingDetailMaterials' => array(self::HAS_MANY, 'WorkOrderCuttingDetailMaterial', 'work_order_cutting_detail_material_id'),
			'receiveDetail' => array(self::BELONGS_TO, 'ReceiveDetail', 'receive_detail_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
			'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_name' => 'Product Name',
			'serial_number' => 'Serial Number',
			'length' => 'Length',
			'width' => 'Width',
			'height' => 'Height',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'weight_tolerance' => 'Weight Tolerance',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'work_order_replacement_detail_id' => 'Work Order Replacement Detail',
			'work_order_cutting_detail_material_id' => 'Work Order Cutting Detail Material',
			'receive_detail_id' => 'Receive Detail',
			'product_category_id' => 'Product Category',
			'location_id' => 'Location',
			'material_type' => 'Material Type',
			'is_approved' => 'Is Approved',
			'is_offcart' => 'Is Offcart',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.product_name', $this->product_name, true);
		$criteria->compare('t.serial_number', $this->serial_number, true);
		$criteria->compare('t.length', $this->length, true);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.weight_tolerance', $this->weight_tolerance, true);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.work_order_replacement_detail_id', $this->work_order_replacement_detail_id);
		$criteria->compare('t.work_order_cutting_detail_material_id', $this->work_order_cutting_detail_material_id);
		$criteria->compare('t.receive_detail_id', $this->receive_detail_id);
		$criteria->compare('t.product_category_id', $this->product_category_id);
		$criteria->compare('t.location_id', $this->location_id);
		$criteria->compare('t.material_type', $this->material_type);
		$criteria->compare('t.is_approved', $this->is_approved);
		$criteria->compare('t.is_offcart', $this->is_offcart);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
