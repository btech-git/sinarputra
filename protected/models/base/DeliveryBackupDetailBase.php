<?php

/**
 * @property integer $id
 * @property string $grade_name
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $weight
 * @property integer $quantity
 * @property integer $delivery_backup_header_id
 * @property integer $is_inactive
 * @property integer $is_miling
 * @property integer $is_grinding
 * @property integer $is_hardness
 * @property integer $is_annelying
 * @property integer $is_sidemiling
 * @property integer $is_coating
 * @property integer $product_category_id
 *
 * @property DeliveryBackupHeader $deliveryBackupHeader
 * @property ProductCategory $productCategory
 */
class DeliveryBackupDetailBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_delivery_backup_detail';
	}

	public function rules()
	{
		return array(
			array('grade_name, delivery_backup_header_id, product_category_id', 'required'),
			array('quantity, delivery_backup_header_id, is_inactive, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_coating, product_category_id', 'numerical', 'integerOnly'=>true),
			array('grade_name', 'length', 'max'=>100),
			array('length, width, height, weight', 'length', 'max'=>10),
			// The following rule is used by search().
			array('id, grade_name, length, width, height, weight, quantity, delivery_backup_header_id, is_inactive, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_coating, product_category_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'deliveryBackupHeader' => array(self::BELONGS_TO, 'DeliveryBackupHeader', 'delivery_backup_header_id'),
			'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
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
			'delivery_backup_header_id' => 'Delivery Backup Header',
			'is_inactive' => 'Is Inactive',
			'is_miling' => 'Is Miling',
			'is_grinding' => 'Is Grinding',
			'is_hardness' => 'Is Hardness',
			'is_annelying' => 'Is Annelying',
			'is_sidemiling' => 'Is Sidemiling',
			'is_coating' => 'Is Coating',
			'product_category_id' => 'Product Category',
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
		$criteria->compare('t.delivery_backup_header_id', $this->delivery_backup_header_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);
		$criteria->compare('t.is_miling', $this->is_miling);
		$criteria->compare('t.is_grinding', $this->is_grinding);
		$criteria->compare('t.is_hardness', $this->is_hardness);
		$criteria->compare('t.is_annelying', $this->is_annelying);
		$criteria->compare('t.is_sidemiling', $this->is_sidemiling);
		$criteria->compare('t.is_coating', $this->is_coating);
		$criteria->compare('t.product_category_id', $this->product_category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
