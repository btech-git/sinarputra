<?php
Yii::app()->clientScript->registerCss('_report', '
     @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

	.width2-1 { width: 9% }
	.width2-2 { width: 9% }
	.width2-3 { width: 10% }
	.width2-4 { width: 7% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
	.width2-7 { width: 5% }
	.width2-8 { width: 5% }
	.width2-9 { width: 5% }
	.width2-10 { width: 5% }
	.width2-11 { width: 10% }
	.width2-12 { width: 9% }
    .width2-13 { width: 10% }
    .width2-14 { width: 6% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Hutang Supplier</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">Supplier</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">No Invoice</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">No Faktur Pajak</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">Tukar Faktur</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">Tanggal Jatuh Tempo</th>
        <th class="width2-6" style="text-align: left;border-bottom: 2px solid;">Saldo Awal</th>
        <th class="width2-7" style="text-align: left;border-bottom: 2px solid;">Adm Bank</th>
        <th class="width2-8" style="text-align: left;border-bottom: 2px solid;">Pembayaran</th>
        <th class="width2-9" style="text-align: left;border-bottom: 2px solid;">Saldo Akhir</th>
        <th class="width2-10" style="text-align: left;border-bottom: 2px solid;">Tgl Bayar</th>
        <th class="width2-11" style="text-align: left;border-bottom: 2px solid;">Keterangan</th>
    </tr>
    
    <?php foreach ($purchaseReceiptSupplierSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->purchaseReceiptHeaders as $receipt): ?>
            <?php //if ($receipt->date >= $startDate && $receipt->date <= $endDate): ?>
                <?php foreach ($receipt->purchaseReceiptDetails as $detail): ?>
                    <tr>
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                        <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($detail->purchaseInvoice->getCodeNumber(PurchaseInvoice::CN_CONSTANT)); ?></td>
                        <td class="width1-2"><?php //echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                        <td class="width1-2"><?php //echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                        <td class="width2-1" style="text-align: left"><?php //echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', CHtml::value($receipt, 'date'))); ?></td>
                        <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receipt, 'grandTotal'))); ?></td>
                        <td class="width1-2"><?php //echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
                        <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receipt, 'paymentTotal'))); ?></td>
                        <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receipt, 'returnTotal'))); ?></td>
                        <td class="width2-1" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', CHtml::value($receipt, 'date'))); ?></td>
                        <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($receipt, 'note'))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php //endif; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>