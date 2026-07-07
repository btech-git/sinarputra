<?php

/**
 * @property integer $id
 * @property string $grade_name
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $weight
 * @property integer $quantity
 * @property integer $quality_control_cutting_detail_id
 * @property integer $quality_control_miling_detail_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $delivery_header_id
 * @property integer $is_inactive
 *
 * @property DeliveryHeader $deliveryHeader
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property QualityControlCuttingDetail $qualityControlCuttingDetail
 * @property QualityControlMilingDetail $qualityControlMilingDetail
 * @property ManualSaleInvoiceDetail[] $manualSaleInvoiceDetails
 */
class DeliveryDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_delivery_detail';
	}

	public function rules()
	{
		return array(
			array('delivery_header_id', 'required'),
			array('quantity, quality_control_cutting_detail_id, quality_control_miling_detail_id, work_order_cutting_detail_id, delivery_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('grade_name', 'length', 'max'=>100),
			array('length, width, height', 'length', 'max'=>10),
			array('weight', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, grade_name, length, width, height, weight, quantity, quality_control_cutting_detail_id, quality_control_miling_detail_id, work_order_cutting_detail_id, delivery_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryHeader' => array(self::BELONGS_TO, 'DeliveryHeader', 'delivery_header_id'),
			'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
			'qualityControlCuttingDetail' => array(self::BELONGS_TO, 'QualityControlCuttingDetail', 'quality_control_cutting_detail_id'),
			'qualityControlMilingDetail' => array(self::BELONGS_TO, 'QualityControlMilingDetail', 'quality_control_miling_detail_id'),
			'manualSaleInvoiceDetails' => array(self::HAS_MANY, 'ManualSaleInvoiceDetail', 'delivery_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'grade_name' => 'Grade Name',
			'length' => 'Length',
			'width' => 'Width',
			'height' => 'Height',
			'weight' => 'Weight',
			'quantity' => 'Quantity',
			'quality_control_cutting_detail_id' => 'Quality Control Cutting Detail',
			'quality_control_miling_detail_id' => 'Quality Control Miling Detail',
			'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
			'delivery_header_id' => 'Delivery Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.grade_name', $this->grade_name, true);
		$criteria->compare('t.length', $this->length, true);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.quality_control_cutting_detail_id', $this->quality_control_cutting_detail_id);
		$criteria->compare('t.quality_control_miling_detail_id', $this->quality_control_miling_detail_id);
		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
		$criteria->compare('t.delivery_header_id', $this->delivery_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
