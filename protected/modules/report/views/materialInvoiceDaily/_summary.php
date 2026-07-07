<?php Yii::app()->clientScript->registerCss('_report', ''); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Buku Penjualan Manual 2</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th style="border-bottom: 2px solid;">Tanggal</th>
        <th style="border-bottom: 2px solid;">Jatuh Tempo</th>
        <th style="border-bottom: 2px solid;">No Invoice</th>
        <th style="border-bottom: 2px solid;">No F.Pajak</th>
        <th style="border-bottom: 2px solid;">No PO</th>
        <th style="border-bottom: 2px solid;">Customer</th>
        <th style="border-bottom: 2px solid;">Material</th>
        <th style="border-bottom: 2px solid;">Quantity</th>
        <th style="border-bottom: 2px solid;">Satuan</th>
        <th style="border-bottom: 2px solid;">Berat</th>
        <th style="border-bottom: 2px solid;">Harga</th>
        <th style="border-bottom: 2px solid;">Jumlah</th>
    </tr>
    <?php $number = 1; ?>
    <?php $totalSale = 0; ?>
    <?php foreach ($materialInvoiceSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->materialInvoiceDetails as $materialInvoiceDetail): ?>
            <?php $total = $materialInvoiceDetail->total; ?>
            <tr class="items1">
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?></td>
                <td><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'tax_number')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'reference_number')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($materialInvoiceDetail, 'material_name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($materialInvoiceDetail, 'quantity'))); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($materialInvoiceDetail, 'unit.name')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($materialInvoiceDetail, 'weight'))); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $materialInvoiceDetail->unit_price)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $total)); ?></td>
            </tr>
            <?php $totalSale += $total; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
    <tr>
        <td style="text-align: right; border-top: 1px solid; font-weight: bold" colspan="11">TOTAL PENJUALAN</td>
        <td style="text-align: right; border-top: 1px solid; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalSale)); ?></td>
    </tr>
</table>