<?php
Yii::app()->clientScript->registerCss('_report', '
     @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

	.width2-1 { width: 10% }
	.width2-2 { width: 10% }
	.width2-3 { width: 10% }
	.width2-4 { width: 10% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
	.width2-7 { width: 10% }
	.width2-8 { width: 10% }
	.width2-9 { width: 10% }
	.width2-10 { width: 5% }
	.width2-11 { width: 10% }
	.width2-12 { width: 5% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pelunasan Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;border-bottom: 2px solid;">Pelunasan #</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Tanggal</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">Customer</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">Invoice #</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">Akun Terima</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">Jenis Bayar</th>
        <th class="width1-7" style="text-align: left;border-bottom: 2px solid;">Memo</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">Jumlah</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">Akun Selisih 1</th>
        <th class="width1-10" style="text-align: left;border-bottom: 2px solid;">Jumlah Selisih 1</th>
        <th class="width1-11" style="text-align: left;border-bottom: 2px solid;">Akun Selisih 2</th>
        <th class="width1-12" style="text-align: left;border-bottom: 2px solid;">Jumlah Selisih 2</th>
    </tr>

    <?php foreach ($salePaymentSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->salePaymentDetails as $detail): ?>
            <tr>
                <td class="width1-1"><?php echo CHtml::encode($header->getCodeNumber(SalePaymentHeader::CN_CONSTANT)); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode($detail->saleInvoiceHeader->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT));?></td>
                <td class="width1-5"><?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?></td>
                <td class="width1-6"><?php echo CHtml::encode(CHtml::value($detail, 'paymentType.name')); ?></td>
                <td class="width1-7"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'amount'))); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(CHtml::value($detail, 'accountIdAdditionalPayment1.name')); ?></td>
                <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'additional_payment_1'))); ?></td>
                <td class="width1-11"><?php echo CHtml::encode(CHtml::value($detail, 'accountIdAdditionalPayment2.name')); ?></td>
                <td class="width1-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'additional_payment_2'))); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>