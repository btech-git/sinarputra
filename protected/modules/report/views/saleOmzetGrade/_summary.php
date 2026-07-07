<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 9% }
	.width1-2 { width: 7% }
	.width1-3 { width: 7% }
    .width1-4 { width: 7% }
    .width1-5 { width: 7% }
    .width1-6 { width: 7% }
    .width1-7 { width: 7% }
    .width1-8 { width: 7% }
    .width1-9 { width: 7% }
    .width1-10 { width: 7% }
    .width1-11 { width: 7% }
    .width1-12 { width: 7% }
    .width1-13 { width: 7% }
    .width1-14 { width: 7% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Omzet Per Grade (IDR)</div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th style="text-align: center; border-bottom: 2px solid"></th>
        <?php foreach ($records as $yearMonth => $record): ?>
            <th style="text-align: center; border-bottom: 2px solid"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('MMM yyyy', strtotime($yearMonth))); ?></th>
        <?php endforeach; ?>
    </tr>

    <?php foreach ($data as $investorId => $item): ?>
        <tr>
            <td><?php echo CHtml::encode($item['grade_name']); ?></td>
            <?php foreach ($item['values'] as $yearMonth => $amount): ?>
                <td style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $amount)); ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>