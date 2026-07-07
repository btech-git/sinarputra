<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $length_initial
 * @property string $length_final
 * @property string $width_initial
 * @property string $width_final
 * @property string $height_initial
 * @property string $height_final
 * @property integer $quantity
 * @property string $weight
 * @property string $amount
 * @property integer $purchase_header_id
 * @property integer $is_miling
 * @property integer $is_grinding
 * @property integer $is_hardness
 * @property integer $is_annelying
 * @property integer $is_sidemiling
 * @property integer $is_inactive
 *
 * @property PurchaseHeader $purchaseHeader
 */
class PurchaseDetailServiceBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_purchase_detail_service';
	}

	public function rules()
	{
		return array(
			array('name, amount, purchase_header_id', 'required'),
			array('quantity, purchase_header_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('length_initial, length_final, width_initial, width_final, height_initial, height_final, weight', 'length', 'max'=>10),
			array('amount', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, name, length_initial, length_final, width_initial, width_final, height_initial, height_final, quantity, weight, amount, purchase_header_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseHeader' => array(self::BELONGS_TO, 'PurchaseHeader', 'purchase_header_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'length_initial' => 'Length Initial',
			'length_final' => 'Length Final',
			'width_initial' => 'Width Initial',
			'width_final' => 'Width Final',
			'height_initial' => 'Height Initial',
			'height_final' => 'Height Final',
			'quantity' => 'Quantity',
			'weight' => 'Weight',
			'amount' => 'Amount',
			'purchase_header_id' => 'Purchase Header',
			'is_miling' => 'Is Miling',
			'is_grinding' => 'Is Grinding',
			'is_hardness' => 'Is Hardness',
			'is_annelying' => 'Is Annelying',
			'is_sidemiling' => 'Is Sidemiling',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.length_initial', $this->length_initial, true);
		$criteria->compare('t.length_final', $this->length_final, true);
		$criteria->compare('t.width_initial', $this->width_initial, true);
		$criteria->compare('t.width_final', $this->width_final, true);
		$criteria->compare('t.height_initial', $this->height_initial, true);
		$criteria->compare('t.height_final', $this->height_final, true);
		$criteria->compare('t.quantity', $this->quantity);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.amount', $this->amount, true);
		$criteria->compare('t.purchase_header_id', $this->purchase_header_id);
		$criteria->compare('t.is_miling', $this->is_miling);
		$criteria->compare('t.is_grinding', $this->is_grinding);
		$criteria->compare('t.is_hardness', $this->is_hardness);
		$criteria->compare('t.is_annelying', $this->is_annelying);
		$criteria->compare('t.is_sidemiling', $this->is_sidemiling);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
