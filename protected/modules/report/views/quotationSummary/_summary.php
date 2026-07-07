<?php
Yii::app()->clientScript->registerCss('_report', '
	@page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

	.width1-1 { width: 3% }
    .width1-2 { width: 8% }
	.width1-3 { width: 10% }
	.width1-4 { width: 20% }
	.width1-5 { width: 5% }
	.width1-6 { width: 9% }
    .width1-7 { width: 8% }
	.width1-8 { width: 10% }
	.width1-9 { width: 10% }
	.width1-10 { width: 8% }
	.width1-11 { width: 3% }
    .width1-12 { width: 3% }
    .width1-13 { width: 3% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Order Penawaran (Summary)</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="" s="width1-1" style="text-align: left;border-bottom: 2px solid;">No</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Tanggal</th>
        <th class="width1-3" style="text-align: left;border-bottom: 2px solid;">No Quotation</th>
        <th class="width1-4" style="text-align: left;border-bottom: 2px solid;">Nama Perusahaan</th>
        <th class="width1-5" style="text-align: left;border-bottom: 2px solid;">Sales</th>
        <th class="width1-6" style="text-align: left;border-bottom: 2px solid;">Contact</th>
        <th class="width1-7" style="text-align: right;border-bottom: 2px solid;">Value</th>
        <th class="width1-8" style="text-align: left;border-bottom: 2px solid;">No. P/O</th>
        <th class="width1-9" style="text-align: left;border-bottom: 2px solid;">Tgl P/O</th>
        <th class="width1-10" style="text-align: right;border-bottom: 2px solid;">Nilai P/O</th>
        <th class="width1-11" style="text-align: left;border-bottom: 2px solid;">Tgl Acc</th>
        <th class="width1-12" style="text-align: left;border-bottom: 2px solid;">Tgl P/OS</th>
        <th class="width1-13" style="text-align: left;border-bottom: 2px solid;">Jenis Quotation</th>
    </tr>
    <?php $number = 1; ?>
    <?php foreach ($quotationSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo $number; $number++; ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'employeeIdSales.name')); ?></td>
            <td class="width1-6" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'customer.name')); ?></td>
            <?php if ($header->is_service == 1) : ?>
                <td class="width1-7" style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalDetailService)); ?></td>
            <?php else : ?>
                <td class="width1-7" style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalDetailProduct)); ?></td>
            <?php endif; ?>
            <td class="width1-8" style="text-align: left"><?php echo $header->saleHeaders ? CHtml::encode($header->saleHeaders[0]->getCodeNumber(SaleHeader::CN_CONSTANT)) : ''; ?></td>
            <td class="width1-9" style="text-align: left"><?php echo $header->saleHeaders ? CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->saleHeaders[0]->date))) : ''; ?></td>
            <?php /*if ($header->is_service == 1) : ?>
                <td class="width1-10" style="font-weight: bold; text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->saleHeaders ? $header->saleHeaders[0]->grandTotalService : 0)); ?></td>
            <?php else : ?>
                <td class="width1-10" style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->saleHeaders ? $header->saleHeaders[0]->grandTotalProduct : 0)); ?></td>
            <?php endif; */?>
            <td class="width1-11"></td>
            <td class="width1-12"></td>
            <td class="width1-13"></td>
        </tr>

    <?php endforeach; ?>

</table>