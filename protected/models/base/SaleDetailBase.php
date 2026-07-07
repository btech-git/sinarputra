<?php

/**
 * @property integer $id
 * @property integer $quotation_detail_product_id
 * @property integer $quotation_detail_service_id
 * @property integer $sale_header_id
 * @property integer $is_inactive
 *
 * @property QuotationDetailProduct $quotationDetailProduct
 * @property SaleHeader $saleHeader
 * @property QuotationDetailService $quotationDetailService
 * @property WorkOrderCuttingDetail[] $workOrderCuttingDetails
 */
class SaleDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_sale_detail';
	}

	public function rules()
	{
		return array(
			array('sale_header_id', 'required'),
			array('quotation_detail_product_id, quotation_detail_service_id, sale_header_id, is_inactive', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			array('id, quotation_detail_product_id, quotation_detail_service_id, sale_header_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'quotationDetailProduct' => array(self::BELONGS_TO, 'QuotationDetailProduct', 'quotation_detail_product_id'),
			'saleHeader' => array(self::BELONGS_TO, 'SaleHeader', 'sale_header_id'),
			'quotationDetailService' => array(self::BELONGS_TO, 'QuotationDetailService', 'quotation_detail_service_id'),
			'workOrderCuttingDetails' => array(self::HAS_MANY, 'WorkOrderCuttingDetail', 'sale_detail_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'quotation_detail_product_id' => 'Quotation Detail Product',
			'quotation_detail_service_id' => 'Quotation Detail Service',
			'sale_header_id' => 'Sale Header',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.quotation_detail_product_id', $this->quotation_detail_product_id);
		$criteria->compare('t.quotation_detail_service_id', $this->quotation_detail_service_id);
		$criteria->compare('t.sale_header_id', $this->sale_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
