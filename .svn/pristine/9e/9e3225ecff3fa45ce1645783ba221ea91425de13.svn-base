<?php
$this->pageTitle = Yii::app()->name . ' - HRD / HRGA';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Halaman HRD / HRGA</h1>

<div class="form">
    <?php if (Yii::app()->user->checkAccess('master')): ?>
        <fieldset>
            <legend>Transaction</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('master')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Employee', array('/admin/employee/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <li style="width: 50%"><?php echo CHtml::link('Timesheet', array('/admin/employee/upload')); ?></li>
                <br class="clear" />
                <li style="width: 50%"><?php echo CHtml::link('Payroll (Salary Slip) **', array('#')); ?></li>
                <br class="clear" />
                <li style="width: 50%"><?php echo CHtml::link('Stationery Request **', array('#')); ?></li>
                <br class="clear" />
                <li style="width: 50%"><?php echo CHtml::link('Organization Structure **', array('#')); ?></li>
                <br class="clear" />
                <li style="width: 50%"><?php echo CHtml::link('Termination **', array('#')); ?></li>
                <br class="clear" />
                <li style="width: 50%"><?php echo CHtml::link('Recruiting Data **', array('#')); ?></li>
                <br class="clear" />
                <li style="width: 50%"><?php echo CHtml::link('Employee Evaluation **', array('#')); ?></li>
                <br class="clear" />
            </ul>
        </fieldset>
    <?php endif; ?>
    <br/>
    <fieldset>
        <legend>Report</legend>
        <ul style="display: table-cell; width: 800px">
            <li style="width: 50%"><?php echo CHtml::link('Stationery Report **', array('#')); ?></li>
            <br class="clear" />
            <li style="width: 50%"><?php echo CHtml::link('Absence Report', array('/report/employeeTimesheet/summary')); ?></li>
            <br class="clear" />
            <li style="width: 50%"><?php echo CHtml::link('Salary Slip **', array('#')); ?></li>
            <br class="clear" />
            <li style="width: 50%"><?php echo CHtml::link('Employee Turn Over Report **', array('#')); ?></li>
            <br class="clear" />
            <li style="width: 50%"><?php echo CHtml::link('Recruiting Report **', array('#')); ?></li>
            <br class="clear" />
            <li style="width: 50%"><?php echo CHtml::link('Employee Evaluation Report **', array('#')); ?></li>
            <br class="clear" />
        </ul>
    </fieldset>
</div>