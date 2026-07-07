<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 2% }
	.width1-2 { width: 15% }
	.width1-3 { width: 10% }
	.width1-4 { width: 8% }
	.width1-5 { width: 11% }
    .width1-6 { width: 9% }
	.width1-7 { width: 6% }
	.width1-8 { width: 6% }
	.width1-9 { width: 2% }
	.width1-10 { width: 2% }
    .width1-11 { width: 6% }
	.width1-12 { width: 6% }
	.width1-13 { width: 4% }
	.width1-14 { width: 4% }
	.width1-15 { width: 5% }
 
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan C3 Harian (PO)</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">No</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Nama Perusahaan</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">P/O Customer</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">TGL P/O</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">No Quotation</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">Tgl Quot</th>
        <th class="width1-7" style="text-align: left;border-bottom: 2px solid;">Qty Order</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">Qty Loss</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">PO</th>
        <th class="width1-10" style="text-align: left;border-bottom: 2px solid;">ACC</th>
        <th class="width1-11" style="text-align: left;border-bottom: 2px solid;">Price Order</th>
        <th class="width1-12" style="text-align: left;border-bottom: 2px solid;">Price Loss</th>
        <th class="width1-13" style="text-align: left;border-bottom: 2px solid;">Jam</th>
        <th class="width1-14" style="text-align: left;border-bottom: 2px solid;">SPK</th>
        <th class="width1-15" style="text-align: left;border-bottom: 2px solid;">Keterangan</th>
    </tr>
    <?php $number = 1; ?>
    <?php foreach ($saleSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: left"><?php echo $number;$number++ ?></td>
            <td class="width1-2" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber(SaleHeader::CN_CONSTANT)); ?></td>
            <td class="width1-4"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode($header->quotationHeader == NULL) ? "" : ($header->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)); ?></td>
            <td class="width1-6"><?php echo CHtml::encode($header->quotationHeader == NULL) ? "" : (Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->quotationHeader->date))); ?></td>
            <td class="width1-5" style="text-align: right">
                <?php if ($header->is_service == 1) : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalQuantityService)); ?>
                <?php else : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalQuantityProduct)); ?>
                <?php endif; ?>
            </td>
            <td class="width1-5" style="text-align: right">
                <?php if ($header->is_service == 1) : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalQuantityServiceLoss)); ?>
                <?php else : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalQuantityProductLoss)); ?>
                <?php endif; ?>
            </td>
            <td></td>
            <td></td>
            <td class="width1-5" style="text-align: right">
                <?php if ($header->is_service == 1) : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotalService)); ?>
                <?php else : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotalProduct)); ?>
                <?php endif; ?>
            </td>
            <td class="width1-5" style="text-align: right">
                <?php if ($header->is_service == 1) : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotalServiceLoss)); ?>
                <?php else : ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotalProductLoss)); ?>
                <?php endif; ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>

    <?php endforeach; ?>

</table>