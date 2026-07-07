<?php

class ProductSize extends ProductSizeBase
{

	public $productName;
	public $productCategoryId;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function searchForPurchase()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.product_id', $this->product_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		$criteria->with = array('product' => array(
				'with' => array('productCategory')
			));

		$criteria->compare('product.name', $this->productName, true);
		$criteria->compare('product.product_category_id', $this->productCategoryId);

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
				'Pagination' => array(
				'PageSize' => 50
				),
			));
	}

	public function searchForQuotation()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.product_id', $this->product_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
				'Pagination' => array(
				'PageSize' => 50
				),
			));
	}

}