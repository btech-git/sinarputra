<?php
Yii::app()->clientScript->registerCss('_report', '
     @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 10% }
	.width1-4 { width: 10% }
	.width1-5 { width: 10% }
	.width1-6 { width: 10% }
	.width1-7 { width: 10% }
	.width1-8 { width: 10% }
	.width1-9 { width: 10% }
	.width1-10 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Tanda Terima Penjualan Manual</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">TT #</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Tgl Cetak</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">Tgl Terima</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">Kurir</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">Customer</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">TOP</th>
        <th class="width1-7" style="text-align: left;border-bottom: 2px solid;">Invoice #</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">Tgl Invoice</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">Total</th>
        <th class="width1-10" style="text-align: left;border-bottom: 2px solid;">Memo</th>
    </tr>

    <?php foreach ($saleReceiptDetailSummary->dataProvider->data as $header): ?>
        <tr>
            <?php 
                $saleReceiptHeader = empty($header->manualSaleReceiptHeader) ? '' : $header->manualSaleReceiptHeader;
                $saleInvoiceHeader = $header->manualSaleInvoiceHeader;
            ?>
            <td class="width1-1"><?php echo CHtml::encode($saleReceiptHeader->getCodeNumber(ManualSaleReceiptHeader::CN_CONSTANT)); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleReceiptHeader->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleReceiptHeader->date_receipt))); ?></td>
            <td class="width1-4"><?php echo CHtml::encode($saleReceiptHeader->courier_name); ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($saleReceiptHeader, 'customer.company')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($saleReceiptHeader, 'customer.invoice_due_days')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode($saleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleInvoiceHeader->date))); ?></td>
            <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceHeader, 'grand_total'))); ?></td>
            <td class="width1-10"><?php echo CHtml::encode($header->memo); ?></td>
        </tr>
    <?php endforeach; ?>
</table>