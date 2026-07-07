<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 2% }
	.width1-2 { width: 12% }
	.width1-3 { width: 12% }
	.width1-4 { width: 50% }
        .width1-5 { width: 12% }
        .width1-6 { width: 12% }
      
        
        @page {
            size:auto;
            margin: 5px 0px 0px 0px;
        }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Faktur Penjualan (Sample)</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom:2px solid;">NO</th>
        <th class="width1-2" style="text-align: left;border-bottom:2px solid;">NO INVOICE</th>
        <th class="width1-3" style="text-align: left;border-bottom:2px solid;">TANGGAL</th>
        <th class="width1-4" style="text-align: left;border-bottom:2px solid;">CUSTOMER</th>
        <th class="width1-5" style="text-align: right;border-bottom:2px solid;">TOTAL</th>
        <th class="width1-6" style="text-align: right;border-bottom:2px solid;">DPP</th>

    </tr>
    <?php $number = 1; ?>
    <?php foreach ($saleInvoiceSampleSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo $number;$number++; ?></td>
            <td class="width1-2" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotal)); ?></td>
            <td class="width1-6" style="text-align: left"></td>

        </tr>
    <?php endforeach; ?>

    <tr>
        <th class="width1-1" style="text-align: left;border-top:2px solid;"></th>
        <th class="width1-2" style="text-align: left;border-top:2px solid;"></th>
        <th class="width1-3" style="text-align: left;border-top:2px solid;"></th>
        <th class="width1-4" style="text-align: right;border-top:2px solid;">TOTAL PENJUALAN</th>
        <th class="width1-5" style="text-align: right;border-top:2px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($saleInvoiceSampleSummary->dataProvider)))); ?></th>
        <th class="width1-6" style="border-top:2px solid;"></th>
    </tr>

</table>