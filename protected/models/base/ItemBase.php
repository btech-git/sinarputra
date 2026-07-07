<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $item_category_id
 * @property integer $unit_id
 * @property integer $is_inactive
 *
 * @property ItemCategory $itemCategory
 * @property Unit $unit
 * @property PurchaseItemDetail[] $purchaseItemDetails
 */
class ItemBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_item';
	}

	public function rules()
	{
		return array(
			array('code, name, item_category_id, unit_id', 'required'),
			array('item_category_id, unit_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('code, name', 'length', 'max'=>60),
			array('description', 'length', 'max'=>100),
			// The following rule is used by search().
			array('id, code, name, description, item_category_id, unit_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'itemCategory' => array(self::BELONGS_TO, 'ItemCategory', 'item_category_id'),
			'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
			'purchaseItemDetails' => array(self::HAS_MANY, 'PurchaseItemDetail', 'item_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'description' => 'Description',
			'item_category_id' => 'Item Category',
			'unit_id' => 'Unit',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.code', $this->code, true);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.item_category_id', $this->item_category_id);
		$criteria->compare('t.unit_id', $this->unit_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
