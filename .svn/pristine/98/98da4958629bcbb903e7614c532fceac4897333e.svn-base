<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
	.width1-5 { width: 20% }

	.width2-1 { width: 9% }
    .width2-2 { width: 4% }
	.width2-3 { width: 4% }
	.width2-4 { width: 4% }
	.width2-5 { width: 4% }
	.width2-6 { width: 9% }
    .width2-7 { width: 4% }
	.width2-8 { width: 4% }
	.width2-9 { width: 4% }
	.width2-10 { width: 4% }
	.width2-11 { width: 8% }
    .width2-12 { width: 8% }
    .width2-13 { width: 8% }
    .width2-14 { width: 10% }
    .width2-15 { width: 10% }
    .width2-16 { width: 6% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Order Penawaran</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Penawaran #</th>
        <th class="width1-3" style="text-align: left">Customer</th>
        <th class="width1-4" style="text-align: left">Catatan</th>
        <th class="width1-5" style="text-align: left"></th>
    </tr>
    <tr id="header2">
        <td colspan="5">
            <table>
                <tr>
                    <th style="text-align: center" colspan="5" >Permintaan</th>
                    <th style="text-align: center" colspan="5">Pernawaran</th>
                    <th class="width2-11" style="text-align: right">Berat</th>
                    <th class="width2-12" style="text-align: right">Harga Satuan</th>
                    <th class="width2-13" style="text-align: right">Total</th>
                    <th class="width2-14" style="text-align: left">SO #</th>
                    <th class="width2-15" style="text-align: left">Tanggal SO</th>
                    <th class="width2-16" style="text-align: left">Number</th>
                </tr>
                <tr>
                    <th class="width2-1" style="text-align: left">GRADE</th>
                    <th class="width2-2" style="text-align: center">Panjang</th>
                    <th class="width2-3" style="text-align: center">Lebar</th>
                    <th class="width2-4" style="text-align: center">Tinggi</th>
                    <th class="width2-5" style="text-align: center">Quantity</th>
                    <th class="width2-6" style="text-align: left">GRADE</th>
                    <th class="width2-7" style="text-align: center">Panjang</th>
                    <th class="width2-8" style="text-align: center">Lebar</th>
                    <th class="width2-9" style="text-align: center">Tinggi</th>
                    <th class="width2-10" style="text-align: center">Quantity</th>
                    <th colspan="3"></th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($quotationSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
            <!--<td class="width1-5" style="text-align: left"><?php // echo CHtml::encode(CHtml::value($header, 'confirmationStatus'));         ?></td>-->
        </tr>
        <tr class="items2">
            <td colspan="5">
                <table>
                    <?php if ($header->is_service == 1) : ?>
                        <?php foreach ($header->quotationDetailServices as $service): ?>
                            <tr>
                                <td class="width2-1" style="text-align: left"><?php echo CHtml::encode(CHtml::value($service, 'product_name')); ?></td>
                                <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_request'))); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_request'))); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_request'))); ?></td>
                                <td class="width2-5" style="text-align: center"></td>
                                <td class="width2-6" style="text-align: left"></td>
                                <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_quote'))); ?></td>
                                <td class="width2-8" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_quote'))); ?></td>
                                <td class="width2-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_quote'))); ?></td>
                                <td class="width2-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity_quote'))); ?></td>
                                <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'weight'))); ?></td>
                                <td class="width2-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'unit_price'))); ?></td>
                                <td class="width2-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'total'))); ?></td>
                                <td class="width2-14" style="text-align: left"><?php echo $service->saleDetails ? CHtml::encode($service->saleDetails[0]->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : ''; ?></td>
                                <td class="width2-15" style="text-align: left"><?php echo $service->saleDetails ? CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($service->saleDetails[0]->saleHeader->date))) : ''; ?></td>
                                <td class="width2-16" style="text-align: left"><?php echo $service->saleDetails ? CHtml::encode(CHtml::value($service->saleDetails[0]->saleHeader, 'customer_order_number')) : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>   
                    <?php else : ?>
                        <?php foreach ($header->quotationDetailProducts as $detail): ?>
                            <tr>
                                <td class="width2-1" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'product_name_request')); ?></td>
                                <td class="width2-2" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))); ?></td>
                                <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request'))); ?></td>
                                <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request'))); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_request'))); ?></td>
                                <td class="width2-6" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'product_name_quote')); ?></td>
                                <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote'))); ?></td>
                                <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote'))); ?></td>
                                <td class="width2-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote'))); ?></td>
                                <td class="width2-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_quote'))); ?></td>
                                <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($detail, 'weight'))); ?></td>
                                <td class="width2-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                                <td class="width2-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
                                <td class="width2-14" style="text-align: left"><?php echo $detail->saleDetails ? CHtml::encode($detail->saleDetails[0]->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : ''; ?></td>
                                <td class="width2-15" style="text-align: left"><?php echo $detail->saleDetails ? CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->saleDetails[0]->saleHeader->date))) : ''; ?></td>
                                <td class="width2-16" style="text-align: left"><?php echo $detail->saleDetails ? CHtml::encode(CHtml::value($detail->saleDetails[0]->saleHeader, 'customer_order_number')) : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <tr>
                        <td  style="font-weight: bold; text-align: right; border-top: 0px solid #000;" colspan="11">Total</td>
                        <td  style="text-align: right;border-top: 0px solid #000;">Rp</td>
                        <?php if ($header->is_service == 1) : ?>
                            <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalDetailService)); ?></td>
                        <?php else : ?>
                            <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalDetailProduct)); ?></td>
                        <?php endif; ?>
                           
                    </tr>


                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td style="border-top: 1px solid; text-align: right; font-weight: bold; font-size: small" colspan="4">TOTAL PENAWARAN</td>
        <td style="border-top: 1px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($quotationSummary->dataProvider)))); ?></td>
    </tr>
</table>