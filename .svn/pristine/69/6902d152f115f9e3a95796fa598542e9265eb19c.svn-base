<?php

/**
 * @property integer $id
 * @property string $company_name
 * @property string $position
 * @property string $period
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property Employee $employee
 */
class EmployeeJobExperienceBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_employee_job_experience';
	}

	public function rules()
	{
		return array(
			array('company_name, position, employee_id', 'required'),
			array('employee_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('company_name, position, period', 'length', 'max'=>60),
			// The following rule is used by search().
			array('id, company_name, position, period, employee_id, is_inactive', 'safe', 'on'=>'search'),
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
			'company_name' => 'Company Name',
			'position' => 'Position',
			'period' => 'Period',
			'employee_id' => 'Employee',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.company_name', $this->company_name, true);
		$criteria->compare('t.position', $this->position, true);
		$criteria->compare('t.period', $this->period, true);
		$criteria->compare('t.employee_id', $this->employee_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
