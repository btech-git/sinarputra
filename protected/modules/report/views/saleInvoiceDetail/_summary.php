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
    <div style="font-size: larger">Laporan Faktur Penjualan</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Faktur #</th>
        <th class="width1-3" style="text-align: left">Customer</th>
        <th class="width1-6" style="text-align: left">Jatuh Tempo</th>
        <th class="width1-7" style="text-align: left">SPK #</th>
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
    <?php foreach ($saleInvoiceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
            <td class="width1-6" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->due_date))); ?></td>
            <td class="width1-7" style="text-align: left"><?php echo CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>
            <td class="width1-4" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <?php
        /*$isTax = 0;

        if ($header->workOrderCuttingHeader->saleHeader->saleDetails != NULL)
            $isTax = $header->workOrderCuttingHeader->saleHeader->saleDetails[0]->quotationDetailProduct->quotationHeader->is_tax;
        else
            $isTax = $header->workOrderCuttingHeader->saleHeader->saleDetails[0]->quotationDetailService->quotationHeader->is_tax;*/
        ?>
        <tr class="items2">
            <td colspan="6">
                <table>
                    <?php if ($header->workOrderCuttingHeader->is_service == 0) : ?>
                        <?php foreach ($header->saleInvoiceDetails as $detail): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.product_name_quote')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.height_quote')); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.width_quote')); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.length_quote')); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.weight'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.quantity_quote'))); ?></td>
                                <?php //if ($isTax == 0): ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?></td>
                                <?php /*else: ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleInvoiceDetails->unitPriceTax)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleInvoiceDetails->totalTax)); ?></td>
                                <?php endif; */ ?>
                            </tr>
                        <?php endforeach; ?>   
                    <?php  else: ?>
                        <?php foreach ($header->saleInvoiceDetails as $service): ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode(CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.product_name')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.height_quote')); ?></td>
                                <td class="width2-3"><?php echo CHtml::encode(CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.width_quote')); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode(CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.length_quote')); ?></td>
                                <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.weight'))); ?></td>
                                <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.quantity_quote'))); ?></td>
                                <?php //if ($isTax == 0): ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $service->unit_price)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $service->total)); ?></td>
                                <?php /*else: ?>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleInvoiceDetails->unitPriceTax)); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleInvoiceDetails->totalTax)); ?></td>
                                <?php endif; */ ?>
                            
                        <?php endforeach; ?>   
                    <?php endif; ?>

                    <tr>
                        <td class="width2-7" style="text-align: right" colspan="7">Sub Total</td>
                        <td class="width2-8" style="text-align: right; border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->subTotal)); ?></td>
                    </tr>   

                    <tr>
                        <td class="width2-7" style="text-align: right" colspan="7">PPN 10%</td>
                        <td class="width2-8" style="text-align: right" border-top: 1px solid;><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->calculatedTax)); ?></td>
                    </tr>   
                    <tr>
                        <td class="width2-7" style="text-align: right" colspan="7">Grand Total</td>
                        <td class="width2-8" style="text-align: right;border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->grandTotal)); ?></td>
                    </tr> 


                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr id="header2">
        <td colspan="6" style="border-bottom: 0px solid;">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left"></th>
                    <th class="width2-2" style="text-align: left"></th>
                    <th class="width2-3" style="text-align: left"></th>
                    <th class="width2-4" style="text-align: left"></th>
                    <th class="width2-5"></th>
                    <th class="width2-6"></th>
                    <th class="width2-7" style="text-align: right">TOTAL PENJUALAN</th>
                    <th class="width2-8" style="text-align: right"> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($saleInvoiceSummary->dataProvider)))); ?></th>
                </tr>
            </table>
        </td>
    </tr>        

</table>