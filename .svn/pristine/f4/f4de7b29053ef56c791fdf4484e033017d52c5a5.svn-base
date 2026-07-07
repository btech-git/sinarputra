<?php
Yii::app()->clientScript->registerCss('_report', '
	@page {
            size:auto;
            margin: 5px 0px 0px 0px;
        }

	.width1-1 { width: 5% }
        .width1-2 { width: 10% }
	.width1-3 { width: 7% }
	.width1-4 { width: 10% }
	.width1-5 { width: 5% }
	.width1-6 { width: 5% }
        .width1-7 { width: 8% }
	.width1-8 { width: 8% }
	.width1-9 { width: 10% }
	.width1-10 { width: 10% }
        .width1-11 { width: 14% }
        .width1-12 { width: 8% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Timesheet</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">ID</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Name</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">Absence Date</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">Time In</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">Time Out</th>
        <th class="width1-11" style="text-align: left;border-bottom: 2px solid;">Cuti/Ijin/Alpha/Sakit</th>
        <th class="width1-12" style="text-align: left;border-bottom: 2px solid;">Note</th>
        <th class="width1-7" style="text-align: left;border-bottom: 2px solid;">Atd In Code</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">Atd In Name</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">Jabatan</th>
        <th class="width1-10" style="text-align: left;border-bottom: 2px solid;">Divisi</th>

    </tr>
    <?php $number = 1; ?>
    <?php foreach ($employeeTimesheetSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(CHtml::value($header, 'employee.code')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'employee.name')); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'check_in_time')); ?></td>
            <td class="width1-6" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'check_out_time')); ?></td>
            <td class="width1-11" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'reasoning')); ?></td>
            <td class="width1-12" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'memo')); ?></td>
            <td class="width1-7" style="text-align: left"></td>
            <td class="width1-8" style="text-align: left"></td>
            <td class="width1-9" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'employee.employeeCategory.name')); ?></td>
            <td class="width1-10" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'employee.department.name')); ?></td>
        </tr>

    <?php endforeach; ?>

</table>