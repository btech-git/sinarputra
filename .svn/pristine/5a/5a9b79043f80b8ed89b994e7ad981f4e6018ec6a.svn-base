<?php Yii::app()->clientScript->registerCss('_report', ''); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Buku Penjualan Manual</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th style="text-align: center" colspan="15">Permintaan</th>
        <th style="text-align: center" colspan="12">Penawaran</th>
    </tr>
    <tr id="header2">
        <th style="text-align: left;border-bottom: 2px solid;">Tanggal</th>
        <th style="text-align: left;border-bottom: 2px solid;">No Faktur</th>
        <th style="text-align: left;border-bottom: 2px solid;">Customer</th>
        <th style="text-align: left;border-bottom: 2px solid;">No SPK</th>
        <th style="text-align: left;border-bottom: 2px solid;">Material</th>
        <th style="text-align: left;border-bottom: 2px solid;">Jenis</th>
        <th style="text-align: left;border-bottom: 2px solid;">Height</th>
        <th style="text-align: left;border-bottom: 2px solid;">Width</th>
        <th style="text-align: left;border-bottom: 2px solid;">Length</th>
        <th style="text-align: left;border-bottom: 2px solid;">Height</th>
        <th style="text-align: left;border-bottom: 2px solid;">Width</th>
        <th style="text-align: left;border-bottom: 2px solid;">Length</th>
        <th style="text-align: left;border-bottom: 2px solid;">Quantity</th>
        <th style="text-align: left;border-bottom: 2px solid;">Berat</th>
        <th style="text-align: left;border-bottom: 2px solid;">Harga</th>
        <th style="text-align: left;border-bottom: 2px solid;">Jumlah</th>
    </tr>
    <?php $number = 1; ?>
    <?php foreach ($saleInvoiceSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->manualSaleInvoiceDetails as $saleInvoiceDetail): ?>
            <tr class="items1">
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
                <td style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
                <td style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
                <td style="text-align: left"><?php echo CHtml::encode($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.product_name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.productCategory.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.height_request')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.width_request')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.length_request')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.height_quote')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.width_quote')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.length_quote')); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.quantity'))); ?></td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.weight'))); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleInvoiceDetail->unit_price)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleInvoiceDetail->total)); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>