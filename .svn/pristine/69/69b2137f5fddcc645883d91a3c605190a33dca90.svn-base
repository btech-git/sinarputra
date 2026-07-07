<?php
Yii::app()->clientScript->registerCss('_report', '
     @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

    .width1-1 { width: 7% }
    .width1-2 { width: 7% }
    .width1-3 { width: 5% }
    .width1-4 { width: 7% }
    .width1-5 { width: 5% }
    .width1-6 { width: 10% }
    .width1-7 { width: 20% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }
    .width1-11 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Outstanding Per Customer Detail Manual</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: center; border-bottom: 2px solid;">Tgl Nota</th>
        <th class="width1-2" style="text-align: center; border-bottom: 2px solid;">Tgl TT</th>
        <th class="width1-3" style="text-align: center; border-bottom: 2px solid;">TOP (hari)</th>
        <th class="width1-4" style="text-align: center; border-bottom: 2px solid;">Tgl TOP</th>
        <th class="width1-5" style="text-align: center; border-bottom: 2px solid;">Remaining TOP</th>
        <th class="width1-6" style="text-align: center; border-bottom: 2px solid;">No Nota</th>
        <th class="width1-7" style="text-align: center; border-bottom: 2px solid;">Customer</th>
        <th class="width1-8" style="text-align: center; border-bottom: 2px solid;">Salesman</th>
        <th class="width1-9" style="text-align: center; border-bottom: 2px solid;">Total</th>
        <th class="width1-10" style="text-align: center; border-bottom: 2px solid;">Pelunasan</th>
        <th class="width1-11" style="text-align: center; border-bottom: 2px solid;">Sisa</th>
    </tr>

    <?php foreach ($saleReceiptSummary->dataProvider->data as $header): ?>
        <?php $dueDays = empty($header->manualSaleReceiptDetails) ? 0 : strtotime($header->manualSaleReceiptDetails[0]->manualSaleReceiptHeader->due_date); ?>
        <?php $remainingDueDays = ($dueDays - strtotime(date('Y-m-d'))) /86400; ?>
        <?php if ($remainingDueDays > 15): ?>
            <tr>
        <?php else: ?>
            <tr style="background-color: pink"> 
        <?php endif; ?>
            <?php $saleReceiptDetail = empty($header->manualSaleReceiptDetails) ? 0 : $header->manualSaleReceiptDetails[0]; ?>
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-2">
                <?php echo empty($saleReceiptDetail) ? "N/A" : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleReceiptDetail->manualSaleReceiptHeader->date))); ?>
            </td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.invoice_due_days')); ?></td>
            <td class="width1-4">
                <?php echo empty($saleReceiptDetail) ? "N/A" : CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleReceiptDetail->manualSaleReceiptHeader->due_date))); ?>
            </td>
            <td class="width1-4"><?php echo $remainingDueDays; ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'employeeIdSalesman.name')); ?></td>
            <td class="width1-8" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?>
            </td>
            <td class="width1-9" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_payment'))); ?>
            </td>
            <td class="width1-10" style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'remaining'))); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>