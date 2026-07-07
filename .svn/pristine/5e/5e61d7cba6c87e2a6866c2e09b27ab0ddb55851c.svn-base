<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 15% }
	.width1-2 { width: 15% }
	.width1-3 { width: 15% }
	.width1-4 { width: 15% }
        .width1-5 { width: 15% }
        .width1-6 { width: 10% }
        .width1-7 { width: 15% }

	.width2-1 { width: 25% }
	.width2-2 { width: 25% }
	.width2-3 { width: 10% }
	.width2-4 { width: 10% }
	.width2-5 { width: 15% }
	.width2-6 { width: 15% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Faktur Penjualan Material</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" >Tanggal</th>
        <th class="width1-2" >Faktur #</th>
        <th class="width1-3" >Customer</th>
        <th class="width1-4" >Jatuh Tempo</th>
        <th class="width1-5" >PO #</th>
        <th class="width1-6" >Sales</th>
        <th class="width1-7" >Catatan</th>

    </tr>
    <tr id="header2">
        <td colspan="7">
            <table>
                <tr>
                    <th class="width2-1">Material</th>
                    <th class="width2-2">Memo</th>
                    <th class="width2-3" style="text-align: center">Berat</th>
                    <th class="width2-4" style="text-align: center">Quantity</th>
                    <th class="width2-5" style="text-align: right">Harga Satuan</th>
                    <th class="width2-6" style="text-align: right">Total</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($materialInvoiceSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-2" ><?php echo CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)); ?></td>
            <td class="width1-3" ><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
            <td class="width1-4" ><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date))); ?></td>
            <td class="width1-5" ><?php echo CHtml::encode(CHtml::value($header, 'reference_number')); ?></td>
            <td class="width1-6" ><?php echo CHtml::encode(CHtml::value($header, 'employeeIdSalesman.name')); ?></td>
            <td class="width1-7" ><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="7">
                <table>
                    <?php foreach ($header->materialInvoiceDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'material.name')); ?></td>
                            <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td class="width2-3" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($detail, 'weight'))); ?>
                            </td>
                            <td class="width2-4" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                            </td>
                            <td class="width2-5" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price)); ?>
                            </td>
                            <td class="width2-6" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?> 

                    <tr>
                        <td style="text-align: right; border-top: 1px solid" colspan="5">Sub Total</td>
                        <td class="width2-6" style="text-align: right; border-top: 1px solid;">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->subTotal)); ?>
                        </td>
                    </tr>   

                    <tr>
                        <td style="text-align: right" colspan="5">Discount</td>
                        <td class="width2-6" style="text-align: right;">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->discount)); ?>
                        </td>
                    </tr>   

                    <tr>
                        <td style="text-align: right" colspan="5">PPN <?php echo CHtml::encode(CHtml::value($header, 'tax_percentage')); ?>%</td>
                        <td class="width2-6" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->calculatedTax)); ?></td>
                    </tr>   
                    
                    <tr>
                        <td style="text-align: right" colspan="5">Pph 2%</td>
                        <td class="width2-6" style="text-align: right;">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->calculatedTaxIncome)); ?></td>
                    </tr>   

                    <tr>
                        <td style="text-align: right" colspan="5">Grand Total</td>
                        <td class="width2-6" style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $header->grand_total)); ?></td>
                    </tr> 
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr id="header1">
        <th colspan="6" style="text-align: right">TOTAL PENJUALAN</th>
        <th class="width1-7" style="text-align: right"> 
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($materialInvoiceSummary->dataProvider)))); ?>
        </th>
    </tr>
</table>