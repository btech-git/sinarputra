<?php

/**
 * @property integer $id
 * @property string $product_name
 * @property string $job_number
 * @property string $length_request
 * @property string $width_request
 * @property string $height_request
 * @property string $length_quote
 * @property string $width_quote
 * @property string $height_quote
 * @property integer $quantity
 * @property string $weight
 * @property integer $work_order_replacement_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $quality_control_cutting_detail_id
 * @property integer $quality_control_miling_detail_id
 * @property integer $product_category_id
 * @property integer $is_miling
 * @property integer $is_grinding
 * @property integer $is_hardness
 * @property integer $is_annelying
 * @property integer $is_sidemiling
 * @property integer $is_external_order
 * @property integer $is_cut
 * @property integer $is_urgent
 * @property integer $is_inactive
 *
 * @property ProductionPlanningCuttingDetail[] $productionPlanningCuttingDetails
 * @property ProductionPlanningMilingDetail[] $productionPlanningMilingDetails
 * @property WorkOrderCuttingDetailMaterial[] $workOrderCuttingDetailMaterials
 * @property QualityControlMilingDetail $qualityControlMilingDetail
 * @property WorkOrderReplacementHeader $workOrderReplacementHeader
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property ProductCategory $productCategory
 * @property QualityControlCuttingDetail $qualityControlCuttingDetail
 */
class WorkOrderReplacementDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_work_order_replacement_detail';
	}

	public function rules()
	{
		return array(
			array('product_name, job_number, work_order_replacement_header_id, work_order_cutting_detail_id, product_category_id', 'required'),
			array('quantity, work_order_replacement_header_id, work_order_cutting_detail_id, quality_control_cutting_detail_id, quality_control_miling_detail_id, product_category_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_external_order, is_cut, is_urgent, is_inactive', 'numerical', 'integerOnly'=>true),
			array('product_name, job_number', 'length', 'max'=>60),
			array('length_request, width_request, height_request, length_quote, width_quote, height_quote, weight', 'length', 'max'=>10),
			// The following rule is used by search().
			array('id, product_name, job_number, length_request, width_request, height_request, length_quote, width_quote, height_quote, quantity, weight, work_order_replacement_header_id, work_order_cutting_detail_id, quality_control_cutting_detail_id, quality_control_miling_detail_id, product_category_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_external_order, is_cut, is_urgent, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'productionPlanningCuttingDetails' => array(self::HAS_MANY, 'ProductionPlanningCuttingDetail', 'work_order_replacement_detail_id'),
			'productionPlanningMilingDetails' => array(self::HAS_MANY, 'ProductionPlanningMilingDetail', 'work_order_replacement_detail_id'),
			'workOrderCuttingDetailMaterials' => array(self::HAS_MANY, 'WorkOrderCuttingDetailMaterial', 'work_order_replacement_detail_id'),
			'qualityControlMilingDetail' => array(self::BELONGS_TO, 'QualityControlMilingDetail', 'quality_control_miling_detail_id'),
			'workOrderReplacementHeader' => array(self::BELONGS_TO, 'WorkOrderReplacementHeader', 'work_order_replacement_header_id'),
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
			'qualityControlCuttingDetail' => array(self::BELONGS_TO, 'QualityControlCuttingDetail', 'quality_control_cutting_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_name' => 'Product Name',
			'job_number' => 'Job Number',
			'length_request' => 'Length Request',
			'width_request' => 'Width Request',
			'height_request' => 'Height Request',
			'length_quote' => 'Length Quote',
			'width_quote' => 'Width Quote',
			'height_quote' => 'Height Quote',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'work_order_replacement_header_id' => 'Work Order Replacement Header',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'quality_control_cutting_detail_id' => 'Quality Control Cutting Detail',
			'quality_control_miling_detail_id' => 'Quality Control Miling Detail',
			'product_category_id' => 'Product Category',
			'is_miling' => 'Is Miling',
			'is_grinding' => 'Is Grinding',
			'is_hardness' => 'Is Hardness',
			'is_annelying' => 'Is Annelying',
			'is_sidemiling' => 'Is Sidemiling',
			'is_external_order' => 'Is External Order',
			'is_cut' => 'Is Cut',
			'is_urgent' => 'Is Urgent',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.product_name', $this->product_name, true);
		$criteria->compare('t.job_number', $this->job_number, true);
		$criteria->compare('t.length_request', $this->length_request, true);
		$criteria->compare('t.width_request', $this->width_request, true);
		$criteria->compare('t.height_request', $this->height_request, true);
		$criteria->compare('t.length_quote', $this->length_quote, true);
		$criteria->compare('t.width_quote', $this->width_quote, true);
		$criteria->compare('t.height_quote', $this->height_quote, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.work_order_replacement_header_id', $this->work_order_replacement_header_id);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.quality_control_cutting_detail_id', $this->quality_control_cutting_detail_id);
		$criteria->compare('t.quality_control_miling_detail_id', $this->quality_control_miling_detail_id);
		$criteria->compare('t.product_category_id', $this->product_category_id);
		$criteria->compare('t.is_miling', $this->is_miling);
		$criteria->compare('t.is_grinding', $this->is_grinding);
		$criteria->compare('t.is_hardness', $this->is_hardness);
		$criteria->compare('t.is_annelying', $this->is_annelying);
		$criteria->compare('t.is_sidemiling', $this->is_sidemiling);
		$criteria->compare('t.is_external_order', $this->is_external_order);
		$criteria->compare('t.is_cut', $this->is_cut);
		$criteria->compare('t.is_urgent', $this->is_urgent);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
