<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 2% }
	.width1-2 { width: 15% }
	.width1-3 { width: 10% }
	.width1-4 { width: 8% }
	.width1-5 { width: 11% }
    .width1-6 { width: 9% }
	.width1-7 { width: 5% }
	.width1-8 { width: 5% }
	.width1-9 { width: 5% }
	.width1-10 { width: 5% }
 
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Monitoring Stok</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">No</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Nama Perusahaan</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">SO #</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">PO Customer #</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">TGL SO</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">SPK #</th>
        <th class="width1-7" style="text-align: left;border-bottom: 2px solid;">Qty Order</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">Qty PPIC</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">Qty Output</th>
        <th class="width1-10" style="text-align: left;border-bottom: 2px solid;">Qty QC</th>
        <th class="width1-11" style="text-align: left;border-bottom: 2px solid;">Qty Delivered</th>
    </tr>
    <?php $number = 1; ?>
    <?php foreach ($workOrderSummary->dataProvider->data as $header): ?>
        <?php if ($header->quantityDeliveryRemaining > 0): ?>
            <tr class="items1" style="background-color: red">
        <?php else: ?>
            <tr class="items1">
        <?php endif; ?>
            <td class="width1-1" style="text-align: left"><?php echo $number;$number++ ?></td>
            <td class="width1-2" style="text-align: left"><?php echo CHtml::value($header, 'saleHeader.customer.company'); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo ($header->saleHeader == NULL) ? "" : $header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::value($header, 'saleHeader.customer_order_number'); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->saleHeader->date))); ?></td>
            <td class="width1-6" style="text-align: left"><?php echo $header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT); ?></td>
            <td class="width1-7" style="text-align: left"><?php echo CHtml::value($header, 'totalQuantityDetail'); ?></td>
            <td class="width1-8" style="text-align: left"><?php echo CHtml::value($header, 'totalQuantityProductionPlanning'); ?></td>
            <td class="width1-9" style="text-align: left"><?php echo CHtml::value($header, 'totalQuantityProduction'); ?></td>
            <td class="width1-10" style="text-align: left"><?php echo CHtml::value($header, 'totalQuantityQualityControl'); ?></td>
            <td class="width1-10" style="text-align: left"><?php echo CHtml::value($header, 'totalQuantityDelivered'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>