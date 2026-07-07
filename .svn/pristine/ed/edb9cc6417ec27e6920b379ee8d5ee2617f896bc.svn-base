<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 15% }
	.width1-2 { width: 15% }
	.width1-3 { width: 20% }
	.width1-4 { width: 15% }
	.width1-5 { width: 15% }
	.width1-6 { width: 20% }

	.width2-1 { width: 10% }
	.width2-2 { width: 25% }
	.width2-3 { width: 15% }
	.width2-4 { width: 10% }
	.width2-5 { width: 10% }
	.width2-6 { width: 10% }
	.width2-7 { width: 10% }
	.width2-8 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pengiriman Barang</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Pengiriman</th>
        <th class="width1-3" style="text-align: left">Customer</th>
        <th class="width1-6" style="text-align: left">Warehouse</th>
        <th class="width1-4" style="text-align: left">SPK #</th>
        <th class="width1-5" style="text-align: left">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="6">
            <table>
                <tr>
                    <th class="width2-6">Job Order</th>
                    <th class="width2-1" style="text-align: left">GRADE</th>
                    <th class="width2-7">Kategori</th>
                    <th class="width2-2">Tbl/Dmtr</th>
                    <th class="width2-3">Lbr/Dmtr</th>
                    <th class="width2-4">Panjang</th>
                    <th class="width2-5">Berat</th>
                    <th class="width2-8">Quantity</th>


                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($deliverySummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1"><?php echo CHtml::encode($header->getCodeNumber(DeliveryHeader::CN_CONSTANT)); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
            <td class="width1-4"><?php echo $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : ''; ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="6">
                <table>
                    <?php foreach ($header->deliveryDetails as $detail): ?>
                        <tr>
                            <?php if ($detail->work_order_cutting_detail_id == NULL) : ?>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.job_number')); ?></td>
                                <td class="width2-1">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.product_name_quote')); ?>
                                </td>
                                <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.productCategory.name')); ?></td>
                            <?php else : ?>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailService.job_number')); ?></td>
                                <td class="width2-1">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailService.product_name')); ?>
                                </td>
                                <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailService.productCategory.name')); ?></td>
                            <?php endif; ?>       
                            <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'height')); ?></td>
                            <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'width')); ?></td>
                            <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'length')); ?></td>
                            <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?></td>
                            <td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>


                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>