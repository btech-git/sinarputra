<?php

/**
 * @property integer $id
 * @property string $educational_background
 * @property string $major
 * @property string $description
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property Employee $employee
 */
class EmployeeFormalEducationBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_employee_formal_education';
	}

	public function rules()
	{
		return array(
			array('educational_background, major, employee_id', 'required'),
			array('employee_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('major', 'length', 'max'=>60),
			array('description', 'safe'),
			// The following rule is used by search().
			array('id, educational_background, major, description, employee_id, is_inactive', 'safe', 'on'=>'search'),
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
			'educational_background' => 'Educational Background',
			'major' => 'Major',
			'description' => 'Description',
			'employee_id' => 'Employee',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.educational_background', $this->educational_background, true);
		$criteria->compare('t.major', $this->major, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.employee_id', $this->employee_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
