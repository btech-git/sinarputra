<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 15% }
	.width1-2 { width: 15% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
        .width1-6 { width: 20% }
        .width1-7 { width: 10% }

	.width2-1 { width: 15% }
	.width2-2 { width: 10% }
	.width2-3 { width: 10% }
	.width2-4 { width: 10% }
	.width2-5 { width: 10% }
	.width2-6 { width: 10% }
	.width2-7 { width: 10% }
	.width2-8 { width: 13% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Faktur Pembelian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Faktur #</th>
        <th class="width1-3" style="text-align: left">Supplier</th>
        <th class="width1-6" style="text-align: left">Employee</th>
        <th class="width1-7" style="text-align: left">Penerimaan #</th>
        <th class="width1-4" style="text-align: left">Catatan</th>

    </tr>
    <tr id="header2">
        <td colspan="6">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">GRADE</th>
                    <th class="width2-2" style="text-align: left">Tbl/Dmtr</th>
                    <th class="width2-3" style="text-align: left">Lbr/Dmtr</th>
                    <th class="width2-4" style="text-align: left">Pjg/Dmtr</th>
                    <th class="width2-5">Berat</th>
                    <th class="width2-6">Quantity</th>
                    <th class="width2-7" style="text-align: right">Harga Satuan</th>
                    <th class="width2-8" style="text-align: right">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($purchaseInvoiceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'receiveHeader.purchaseHeader.supplier.company')); ?></td>
            <td class="width1-6" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'employee.name')); ?></td>
            <td class="width1-7" style="text-align: left"><?php echo CHtml::encode($header->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>

        </tr>
        <tr class="items2">
            <td colspan="6">
                <table>
                    <?php if ($header->receiveHeader->purchaseHeader->is_service == 0): ?>
                        <?php foreach ($header->receiveHeader->purchaseHeader->purchaseDetails as $purchaseDetail): ?> 

                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'product_name')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'height')); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'width')); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(CHtml::value($purchaseDetail, 'length')); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetail, 'weight'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetail, 'quantity'))); ?></td>
                                <?php if ($header->receiveHeader->purchaseHeader->is_tax == 0): ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetail->unit_price)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetail->total)); ?></td>
                                <?php else: ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetail->unitPriceTax)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetail->totalTax)); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>  



                    <?php else : ?>
                        <?php foreach ($header->receiveHeader->purchaseHeader->purchaseDetailServices as $purchaseDetailService): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($purchaseDetailService, 'name')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($purchaseDetailService, 'height_final')); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(CHtml::value($purchaseDetailService, 'width_final')); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(CHtml::value($purchaseDetailService, 'length_final')); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetailService, 'weight'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseDetailService, 'quantity'))); ?></td>

                                <?php if ($header->receiveHeader->purchaseHeader->is_tax == 0): ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetailService->amount)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetailService->totalService)); ?></td>
                                <?php else: ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetailService->amountTax)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseDetailService->totalServiceTax)); ?></td>
                                <?php endif; ?>
                            </tr>


                        <?php endforeach; ?>


                    <?php endif; ?>
                    <tr>
                        <td class="width2-7" style="text-align: right" colspan="7">Sub Total</td>

                        <?php if ($header->receiveHeader->purchaseHeader->is_tax == 0): ?>

                            <td class="width2-8" style="text-align: right; border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->receiveHeader->purchaseHeader->subTotal)); ?></td>
                        <?php else: ?>

                            <td class="width2-8" style="text-align: right;border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->receiveHeader->purchaseHeader->subTotalTax)); ?></td>
                        <?php endif; ?>
                    </tr>   

                    <tr>
                        <td class="width2-7" style="text-align: right" colspan="7">PPN 10%</td>
                        <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->calculatedTax)); ?></td>
                    </tr>   
                    <tr>
                        <td class="width2-7" style="text-align: right" colspan="7">Grand Total</td>
                        <td class="width2-8" style="text-align: right;border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->grandTotal)); ?></td>
                    </tr>   

                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td style="border-top: 1px solid; text-align: right; font-weight: bold; font-size: small" colspan="5">TOTAL PEMBELIAN</td>
        <td style="border-top: 1px solid; font-weight: bold; text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($purchaseInvoiceSummary->dataProvider)))); ?></td>
    </tr>
</table>