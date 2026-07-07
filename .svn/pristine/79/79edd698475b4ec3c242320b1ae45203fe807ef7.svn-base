<?php

/**
 * @property integer $id
 * @property string $width
 * @property string $height
 * @property integer $product_id
 * @property integer $is_inactive
 *
 * @property Product $product
 */
class ProductSizeBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_product_size';
	}

	public function rules()
	{
		return array(
			array('product_id', 'required'),
			array('product_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('width, height', 'length', 'max'=>10),
			// The following rule is used by search().
			array('id, width, height, product_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'width' => 'Width',
			'height' => 'Height',
			'product_id' => 'Product',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.width', $this->width, true);
		$criteria->compare('t.height', $this->height, true);
		$criteria->compare('t.product_id', $this->product_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
