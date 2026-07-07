<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 20% }
	.width1-4 { width: 15% }
    .width1-5 { width: 5% }
    .width1-6 { width: 5% }
	.width1-7 { width: 5% }
	.width1-8 { width: 5% }
    .width1-9 { width: 15% }
    .width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Faktur Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">Tanggal</th>
        <th class="width1-2">Faktur #</th>
        <th class="width1-3">Customer</th>
        <th class="width1-4">DPP</th>
        <th class="width1-5">Disc</th>
        <th class="width1-6">Pembulatan</th>
        <th class="width1-7">PPn</th>
        <th class="width1-8">PPh</th>
        <th class="width1-9">Grand Total</th>
        <th class="width1-10">Pembuat</th>

    </tr>
    <tr id="header2">
        <td colspan="10">&nbsp;</td>
    </tr>
    <?php foreach ($saleInvoiceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-2"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',($header->subTotal))); ?></td>
            <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',($header->discount))); ?></td>
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',($header->rounding_nominal))); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',($header->calculatedTax))); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',($header->calculatedTaxIncome))); ?></td>
            <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00',($header->grandTotal))); ?></td>
            <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="10">&nbsp;</td>
        </tr>
    <?php endforeach; ?>
    <tr id="header1">
        <td colspan="6" style="border-bottom: 0px solid;">
            <table>
                <tr>
                    <td colspan="8" style="text-align: right">TOTAL PENJUALAN</td>
                    <td class="width1-9" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($saleInvoiceSummary->dataProvider)))); ?></td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>        
</table>