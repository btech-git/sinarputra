<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $exchange_rate
 * @property integer $is_inactive
 *
 * @property PurchaseHeader[] $purchaseHeaders
 */
class CurrencyBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_currency';
	}

	public function rules()
	{
		return array(
			array('code, name', 'required'),
			array('is_inactive', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>20),
			array('name', 'length', 'max'=>60),
			array('exchange_rate', 'length', 'max'=>18),
			// The following rule is used by search().
			array('id, code, name, exchange_rate, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'currency_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'exchange_rate' => 'Exchange Rate',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.code', $this->code, true);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.exchange_rate', $this->exchange_rate, true);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
