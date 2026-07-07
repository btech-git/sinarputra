<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $account_category_id
 * @property integer $is_inactive
 *
 * @property Account[] $accounts
 * @property AccountCategory $accountCategory
 * @property AccountCategory[] $accountCategories
 */
class AccountCategoryBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_account_category';
	}

	public function rules()
	{
		return array(
			array('code, name', 'required'),
			array('account_category_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('code, name', 'length', 'max'=>60),
			array('description', 'safe'),
			// The following rule is used by search().
			array('id, code, name, description, account_category_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'accounts' => array(self::HAS_MANY, 'Account', 'account_category_id'),
			'accountCategory' => array(self::BELONGS_TO, 'AccountCategory', 'account_category_id'),
			'accountCategories' => array(self::HAS_MANY, 'AccountCategory', 'account_category_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'description' => 'Description',
			'account_category_id' => 'Account Category',
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
		$criteria->compare('t.account_category_id', $this->account_category_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
