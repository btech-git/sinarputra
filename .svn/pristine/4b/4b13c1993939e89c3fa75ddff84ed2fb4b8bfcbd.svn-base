<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
	.width1-5 { width: 20% }

	.width2-1 { width: 10% }
    .width2-2 { width: 9% }
	.width2-3 { width: 5% }
	.width2-4 { width: 5% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
    .width2-7 { width: 9% }
	.width2-8 { width: 5% }
	.width2-9 { width: 5% }
	.width2-10 { width: 5% }
	.width2-11 { width: 5% }
     width2-12 { width: 5% }
    .width2-13 { width: 14% }
    .width2-14 { width: 13% }
        
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Order Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Penjualan #</th>
        <th class="width1-3" style="text-align: left">Customer</th>
        <th class="width1-4" style="text-align: left">PO</th>
        <th class="width1-5" style="text-align: left">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="5">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">Penawaran #</th>
                    <th style="text-align: center" colspan="5">Permintaan</th>
                    <th style="text-align: center" colspan="5">Penawaran</th>
                    <th class="width2-12"style="text-align: right">Berat</th>
                    <th class="width2-13" style="text-align: right">Harga Satuan</th>
                    <th class="width2-14" style="text-align: right">Total</th>
                </tr>
               	<tr>
                    <th class="width2-1" style="text-align: center"></th>
                    <th class="width2-2" style="text-align: left">GRADE</th>
                    <th class="width2-3" style="text-align: center">Panjang</th>
                    <th class="width2-4" style="text-align: center">Lebar</th>
                    <th class="width2-5" style="text-align: center">Tinggi</th>
                    <th class="width2-6" style="text-align: center">Quantity</th>
                    <th class="width2-7" style="text-align: left">GRADE</th>
                    <th class="width2-8" style="text-align: center">Panjang</th>
                    <th class="width2-9" style="text-align: center">Lebar</th>
                    <th class="width2-10" style="text-align: center">Tinggi</th>
                    <th class="width2-11" style="text-align: center">Quantity</th>
                    <th colspan="3"></th>

                </tr>

            </table>
        </td>
    </tr>
    <?php foreach ($saleSummary->dataProvider->data as $header): ?>    
    <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber(SaleHeader::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'customer_order_number')); ?></td>
            <td class="width1-5" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="5">
                <table>
                    <?php if ($header->is_service == 1) : ?>
                        <?php foreach ($header->saleDetails as $service): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($service->quotationDetailService->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)); ?></td>
                                <td class="width2-2" style="text-align: left"><?php echo CHtml::encode(CHtml::value($service, 'quotationDetailService.product_name')); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.length_request'))); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.width_request'))); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.height_request'))); ?></td>
                                <td class="width2-6" style="text-align: center"></td>
                                <td class="width2-7" style="text-align: left"><?php echo CHtml::encode(CHtml::value($service, 'quotationDetailService.product_name_quote')); ?></td>
                                <td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.length_quote'))); ?></td>
                                <td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.width_quote'))); ?></td>
                                <td class="width2-10" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.height_quote'))); ?></td>
                                <td class="width2-11" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.quantity_quote'))); ?></td>
                                <td class="width2-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($service, 'quotationDetailService.weight'))); ?></td>
                                <td class="width2-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quotationDetailService.unit_price'))); ?></td>
                                <td class="width2-14" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'total'))); ?></td>
                            </tr>
                        <?php endforeach; ?>   
                    <?php else : ?>
                        <?php foreach ($header->saleDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($detail->quotationDetailProduct->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)); ?></td>
                                <td class="width2-2" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.length_request'))); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.width_request'))); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.height_request'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.quantity_request'))); ?></td>
                                <td class="width2-7" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_quote')); ?></td>
                                <td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.length_quote'))); ?></td>
                                <td class="width2-9" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.width_quote'))); ?></td>
                                <td class="width2-10" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.height_quote'))); ?></td>
                                <td class="width2-11" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.quantity_quote'))); ?></td>
                                <td class="width2-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($detail, 'quotationDetailProduct.weight'))); ?></td>
                                <td class="width2-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.unit_price'))); ?></td>
                                <td class="width2-14" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <tr>
                        <td  style="font-weight: bold; text-align: right; border-top: 0px solid #000;" colspan="12">Total</td>
                        <td  style="text-align: right;border-top: 0px solid #000;">Rp</td>
                        <?php //if ($header->is_service == 1) : ?>
                       
                            <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotalTransaction)); ?></td>
                        <?php //else : ?>
<!--                            <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotalProduct)); ?></td>-->
                        <?php //endif; ?>
                    </tr>


                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td style="border-top: 1px solid; text-align: right; font-weight: bold; font-size: small" colspan="4">TOTAL PENAWARAN</td>
        <td style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($saleSummary->dataProvider)))); ?></td>
    </tr>
</table>