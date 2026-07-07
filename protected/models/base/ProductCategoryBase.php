<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $mass
 * @property integer $is_inactive
 *
 * @property ManualDeliveryDetail[] $manualDeliveryDetails
 * @property Product[] $products
 * @property PurchaseDetail[] $purchaseDetails
 * @property QuotationDetailProduct[] $quotationDetailProducts
 * @property QuotationDetailService[] $quotationDetailServices
 * @property ReceiveDetail[] $receiveDetails
 * @property WorkOrderCuttingDetail[] $workOrderCuttingDetails
 * @property WorkOrderCuttingDetailMaterial[] $workOrderCuttingDetailMaterials
 * @property WorkOrderReplacementDetail[] $workOrderReplacementDetails
 */
class ProductCategoryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_product_category';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('mass', 'length', 'max'=>10),
			// The following rule is used by search().
			array('id, name, mass, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'manualDeliveryDetails' => array(self::HAS_MANY, 'ManualDeliveryDetail', 'product_category_id'),
			'products' => array(self::HAS_MANY, 'Product', 'product_category_id'),
			'purchaseDetails' => array(self::HAS_MANY, 'PurchaseDetail', 'product_category_id'),
			'quotationDetailProducts' => array(self::HAS_MANY, 'QuotationDetailProduct', 'product_category_id'),
			'quotationDetailServices' => array(self::HAS_MANY, 'QuotationDetailService', 'product_category_id'),
			'receiveDetails' => array(self::HAS_MANY, 'ReceiveDetail', 'product_category_id'),
			'workOrderCuttingDetails' => array(self::HAS_MANY, 'WorkOrderCuttingDetail', 'product_category_id'),
			'workOrderCuttingDetailMaterials' => array(self::HAS_MANY, 'WorkOrderCuttingDetailMaterial', 'product_category_id'),
			'workOrderReplacementDetails' => array(self::HAS_MANY, 'WorkOrderReplacementDetail', 'product_category_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'mass' => 'Mass',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.mass', $this->mass, true);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
