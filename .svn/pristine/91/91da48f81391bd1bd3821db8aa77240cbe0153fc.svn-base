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
	.width1-11 { width: 5% }
	.width1-12 { width: 5% }
	.width1-13 { width: 5% }
	.width1-14 { width: 5% }
	.width1-15 { width: 5% }
 
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">LAPORAN PERENCANAAN PROSES PRODUKSI</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">No</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">TGL SPK</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">SPK #</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">TGL SO</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">QTN #</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">CUSTOMER</th>
        <th class="width1-7" style="text-align: left;border-bottom: 2px solid;">JENIS</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">T</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">L</th>
        <th class="width1-10" style="text-align: left;border-bottom: 2px solid;">P</th>
        <th class="width1-11" style="text-align: left;border-bottom: 2px solid;">T</th>
        <th class="width1-12" style="text-align: left;border-bottom: 2px solid;">L</th>
        <th class="width1-13" style="text-align: left;border-bottom: 2px solid;">P</th>
        <th class="width1-14" style="text-align: left;border-bottom: 2px solid;">Qty</th>
        <th class="width1-15" style="text-align: left;border-bottom: 2px solid;">BERAT</th>
    </tr>
    <?php $number = 1; ?>
    <?php foreach ($workOrderSummary->dataProvider->data as $header): ?>
        <?php if ($header->quantityCuttingQualityControlRemaining > 0): ?>
            <tr class="items1" style="background-color: red">
        <?php else: ?>
            <tr class="items1">
        <?php endif; ?>
            <td class="width1-1" style="text-align: left"><?php echo $number;$number++ ?></td>
            <td class="width1-2" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->workOrderCuttingHeader->date))); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->workOrderCuttingHeader->saleHeader->date))); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo ($header->saleDetail->quotationDetailProduct == NULL) ? $header->saleDetail->quotationDetailService->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT) : $header->saleDetail->quotationDetailProduct->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT); ?></td>
            <td class="width1-6" style="text-align: left"><?php echo CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company'); ?></td>
            <td class="width1-7" style="text-align: left"><?php echo CHtml::value($header, 'product_name'); ?></td>
            <td class="width1-8" style="text-align: left"><?php echo CHtml::value($header, 'height_request'); ?></td>
            <td class="width1-9" style="text-align: left"><?php echo CHtml::value($header, 'width_request'); ?></td>
            <td class="width1-10" style="text-align: left"><?php echo CHtml::value($header, 'length_request'); ?></td>
            <td class="width1-11" style="text-align: left"><?php echo CHtml::value($header, 'height_quote'); ?></td>
            <td class="width1-12" style="text-align: left"><?php echo CHtml::value($header, 'width_quote'); ?></td>
            <td class="width1-13" style="text-align: left"><?php echo CHtml::value($header, 'length_quote'); ?></td>
            <td class="width1-14" style="text-align: left"><?php echo CHtml::value($header, 'quantity'); ?></td>
            <td class="width1-15" style="text-align: left"><?php echo CHtml::value($header, 'weight'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>