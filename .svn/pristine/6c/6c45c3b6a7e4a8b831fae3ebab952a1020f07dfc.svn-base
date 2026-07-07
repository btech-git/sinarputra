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
	.width2-4 { width: 5% }
	.width2-5 { width: 10% }
	.width2-6 { width: 10% }
	.width2-7 { width: 5% }
	.width2-8 { width: 13% }
	.width2-9 { width: 13% }
	.width2-10 { width: 2% }
	.width2-11 { width: 2% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Order Pembelian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Pembelian #</th>
        <th class="width1-3" style="text-align: left">Supplier</th>
        <th class="width1-4" style="text-align: left">Catatan</th>
        <th class="width1-5" style="text-align: left"></th>
    </tr>
    <tr id="header2">
        <td colspan="5">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">GRADE</th>
                    <th class="width2-2" style="text-align: left">Panjang</th>
                    <th class="width2-3" style="text-align: left">Lebar</th>
                    <th class="width2-4">Tinggi</th>
                    <th class="width2-5">Quantity</th>
                    <th class="width2-6"></th>
                    <th class="width2-7">Satuan</th>
                    <th class="width2-10">&nbsp;</th>
                    <th class="width2-8" style="text-align: right">Harga Satuan</th>
                    <th class="width2-11">&nbsp;</th>
                    <th class="width2-9" style="text-align: right">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($purchaseSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
            <td class="width1-5" style="text-align: left"></td>
        </tr>
        <tr class="items2">
            <td colspan="5">
                <table>
                    <?php if ($header->is_service == 1) : ?>
                        <?php foreach ($header->purchaseDetailServices as $service): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($service, 'name')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($service, 'length_final')); ?></td>
                                <td class="width2-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($service, 'width_final')); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(CHtml::value($service, 'height_final')); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($detail->receiveDetails == null) ? "0" : $detail->receiveDetails[0]->quantity));     ?></td>
                                <td class="width2-7" style="text-align: center"></td>
                                <td class="width2-10" style="text-align: right"><?php echo CHtml::encode(CHtml::value($service, 'purchaseHeader.currency.code')); ?></td>
                                <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'amount'))); ?></td>
                                <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(CHtml::value($service, 'purchaseHeader.currency.code')); ?></td>
                                <td class="width2-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'totalService'))); ?></td>
                            </tr>
                        <?php endforeach; ?>   
                    <?php else : ?>
                        <?php foreach ($header->purchaseDetails as $detail): ?>
                            <tr>
                                <td class="width2-1">
                                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                                    <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
                                </td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'length')); ?></td>
                                <td class="width2-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'width')); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'height')); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ($detail->receiveDetails == null) ? "0" : $detail->receiveDetails[0]->quantity));     ?></td>
                                <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                                <td class="width2-10" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseHeader.currency.code')); ?></td>
                                <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                                <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'purchaseHeader.currency.code')); ?></td>
                                <td class="width2-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <tr>
                        <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;" colspan="9">Sub Total</td>
                        <td  style="text-align: right;border-top: 1px solid #000;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                        <?php if ($header->is_service == 1) : ?>
                            <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->serviceSubTotal)); ?></td>
                        <?php else : ?>
                            <td  style="font-weight: bold; text-align: right; border-top: 1px solid #000;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->subTotal)); ?></td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <?php if ($header->is_service == 1) : ?>
                            <td  style="font-weight: bold; text-align: right;" colspan="9">Service Tax</td>
                            <td  style="text-align: right;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                            <td  style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->serviceTax)); ?></td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <?php if ($header->is_service == 1) : ?>
                            <td  style="font-weight: bold; text-align: right;" colspan="9">Total Service</td>
                            <td  style="text-align: right;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                            <td  style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalService)); ?></td>
                        <?php endif; ?>
                    </tr>

                    <tr>
                        <td  style="font-weight: bold; text-align: right;" colspan="9">Disc <?php echo CHtml::encode(CHtml::value($header, 'discount')); ?>%</td>
                        <td  style="text-align: right;border-top: 0px solid #000;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                        <td  style="font-weight: bold; text-align: right;">(<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->discount)); ?>)</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; text-align: right;" colspan="9">Total Before Tax</td>
                        <td  style="text-align: right;border-top: 0px solid #000;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                        <td style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->totalBeforeTax)); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; text-align: right;" colspan="9">PPN <?php echo CHtml::encode(CHtml::value($header, 'taxPercentage')) ?>%</td>
                        <td  style="text-align: right;border-top: 0px solid #000;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                        <td style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->calculatedTax)); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; text-align: right;" colspan="9">Grand Total</td>
                        <td  style="text-align: right;border-top: 0px solid #000;"><?php echo CHtml::encode(CHtml::value($header, 'currency.code')); ?></td>
                        <td style="font-weight: bold; text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $header->grandTotal)); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td style="border-top: 1px solid; text-align: right; font-weight: bold; font-size: small" colspan="4">TOTAL PEMBELIAN</td>
        <td style="border-top: 1px solid; font-weight: bold; text-align: right"><?php //echo CHtml::encode(CHtml::value($header,'currency.code'));     ?> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($purchaseSummary->dataProvider)))); ?></td>
    </tr>
</table>