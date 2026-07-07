<?php

/**
 * @property integer $id
 * @property string $date
 * @property string $check_in_time
 * @property string $check_out_time
 * @property string $reasoning
 * @property string $memo
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property Employee $employee
 */
class EmployeeTimesheetBase extends ActiveRecord
{
	public function tableName()
	{
		return 'tblsp_employee_timesheet';
	}

	public function rules()
	{
		return array(
			array('date, check_in_time, check_out_time, employee_id', 'required'),
			array('employee_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('reasoning, memo', 'length', 'max'=>100),
			// The following rule is used by search().
			array('id, date, check_in_time, check_out_time, reasoning, memo, employee_id, is_inactive', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'check_in_time' => 'Check In Time',
			'check_out_time' => 'Check Out Time',
			'reasoning' => 'Reasoning',
			'memo' => 'Memo',
			'employee_id' => 'Employee',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('t.check_in_time', $this->check_in_time, true);
		$criteria->compare('t.check_out_time', $this->check_out_time, true);
		$criteria->compare('t.reasoning', $this->reasoning, true);
		$criteria->compare('t.memo', $this->memo, true);
		$criteria->compare('t.employee_id', $this->employee_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
