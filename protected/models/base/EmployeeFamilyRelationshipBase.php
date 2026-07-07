<?php

/**
 * @property integer $id
 * @property string $name
 * @property string $relationship
 * @property string $address
 * @property string $phone
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property Employee $employee
 */
class EmployeeFamilyRelationshipBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_employee_family_relationship';
	}

	public function rules()
	{
		return array(
			array('name, relationship, employee_id', 'required'),
			array('employee_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>60),
			array('relationship, phone', 'length', 'max'=>30),
			array('address', 'safe'),
			// The following rule is used by search().
			array('id, name, relationship, address, phone, employee_id, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'relationship' => 'Relationship',
			'address' => 'Address',
			'phone' => 'Phone',
			'employee_id' => 'Employee',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.relationship', $this->relationship, true);
		$criteria->compare('t.address', $this->address, true);
		$criteria->compare('t.phone', $this->phone, true);
		$criteria->compare('t.employee_id', $this->employee_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
