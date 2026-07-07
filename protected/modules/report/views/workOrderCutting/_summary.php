<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
	.width1-5 { width: 20% }

	.width2-1 { width: 10% }
	.width2-2 { width: 10% }
	.width2-3 { width: 10% }
	.width2-4 { width: 10% }
	.width2-5 { width: 10% }
	.width2-6 { width: 10% }
	.width2-7 { width: 5% }
	.width2-8 { width: 5% }
	.width2-9 { width: 5% }
	.width2-10 { width: 10% }
	.width2-11 { width: 5% }
	.width2-12 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan SPK Cutting</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">SPK Potong #</th>
        <th class="width1-3" style="text-align: left">Customer</th>
        <th class="width1-4" style="text-align: left">Penjualan #</th>
        <th class="width1-5" style="text-align: left">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="5">
            <table>
                <tr>
                    <th style="text-align: center" colspan="4">Permintaan</th>
                    <th style="text-align: center" colspan="5">Penawaran</th>
                </tr>
                <tr>
                    <th class="width2-1">GRADE</th>
                    <th class="width2-2">Panjang</th>
                    <th class="width2-3">Lebar</th>
                    <th class="width2-4">Tinggi</th>
                    <th class="width2-1">GRADE</th>
                    <th class="width2-5">Panjang</th>
                    <th class="width2-6">Lebar</th>
                    <th class="width2-7">Tinggi</th>
                    <th class="width2-8">Quantity</th>
                    <th class="width2-9">Berat</th>
                    <th class="width2-10">M</th>
                    <th class="width2-11">G</th>
                    <th class="width2-12">FH</th>
                    <th class="width2-13">ANNL</th>
                    <th class="width2-14">SM</th>
                    <th class="width2-15">Order Luar</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($workOrderCuttingSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode($header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="5">
                <table>
                    <?php if ($header->saleHeader->is_service == 1) : ?>
                        <?php foreach ($header->workOrderCuttingDetails as $service): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($service, 'saleDetail.quotationDetailService.product_name')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_request'))); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_request'))); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_request'))); ?></td>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($service, 'saleDetail.quotationDetailService.product_name')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_quote'))); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_quote'))); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_quote'))); ?></td>
                                <td class="width2-5"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity'))); ?></td>
                                <td class="width2-6"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'weight'))); ?></td>
                                <td class="width2-7"><?php echo CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_miling') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-8"><?php echo CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_grinding') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-9"><?php echo CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_hardness') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-10"><?php echo CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_annelying') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-11"><?php echo CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_sidemiling') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-12"><?php echo CHtml::encode((CHtml::value($service, 'is_external_order') == 1) ? "Yes" : "No"); ?></td>
                            </tr>
                        <?php endforeach; ?>   
                    <?php else : ?>
                        <?php foreach ($header->workOrderCuttingDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_request')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request'))); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request'))); ?></td>
                                <td class="width2-5"><?php echo CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_quote')); ?></td>
                                <td class="width2-6"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote'))); ?></td>
                                <td class="width2-7"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote'))); ?></td>
                                <td class="width2-8"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote'))); ?></td>
                                <td class="width2-9"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                                <td class="width2-10"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($detail, 'weight'))); ?></td>
                                <td class="width2-11"><?php echo CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_miling') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-12"><?php echo CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_grinding') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-13"><?php echo CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_hardness') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-14"><?php echo CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_annelying') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-15"><?php echo CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_sidemiling') == 1) ? "Yes" : ""); ?></td>
                                <td class="width2-16"><?php echo CHtml::encode((CHtml::value($detail, 'is_external_order') == 1) ? "Yes" : "No"); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>