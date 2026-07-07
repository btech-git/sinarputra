<?php
Yii::app()->clientScript->registerCss('_report', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

	.width1-1 { width: 25% }
    .width1-2 { width: 25% }
    .width1-1 { width: 25% }

	
	.width2-1 { width: 10% }
    .width2-1 { width: 10% }
	.width2-2 { width: 10% }
	.width2-3 { width: 10% }
    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 10% }
    .width2-1 { width: 10% }
    .width2-2 { width: 10% }

	
');
$startDate = $startDate ? $startDate : date('Y-m-d');
$endDate = $endDate ? $endDate : date('Y-m-d');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Omzet Per Customer Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left;">Customer</th>
        <th class="width1-2" style="text-align: left;">Customer Code</th>
        <th class="width2-3">Area</th>

    </tr>
    <tr id="header2">
        <td colspan="4">
            <table>
                <tr>
                    <th class="width2-2">SE</th>
                    <th class="width2-2">No SPK</th>
                    <th class="width2-3">Steel Aplication</th>
                    <th class="width2-4">Steel Grade</th>
                    <th class="width2-2">Ukuran</th>
                    <th class="width2-3">Quantity</th>
                    <th class="width2-4">Berat</th>
                    <th class="width2-4">Harga</th>
                    <th class="width2-4">Jumlah</th>
                </tr>
            </table>
        </td>
    </tr>	
    <?php foreach ($saleOmzetCustomerSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: left;"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
            <td class="width1-2" style="text-align: left;"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
            <td class="width1-1" style="text-align: left;"><?php //echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
    
        </tr>
        <tr class="items2">
            <td colspan="4">
                <table>
                    <?php foreach ($header->saleInvoiceHeaders as $sale): ?>
                        <?php foreach ($sale->saleInvoiceDetails as $detail): ?>
                            <tr> 
                                <td class="width2-1" style="text-align: center;"><?php echo CHtml::encode(CHtml::value($sale, 'employeeIdSalesman.name')); ?></td>
                                <td class="width2-1" style="text-align: left"><?php //echo CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>
                                <td class="width2-1" style="text-align: left;"><?php echo CHtml::encode($sale->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT)); ?></td>
                                <td class="width2-1" style="text-align: center;"><?php echo CHtml::encode(CHtml::value($detail, 'grade_name')); ?></td>
                                <td class="width2-2" style="text-align: center;"><?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))); ?></td>
                                <td class="width2-2" style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                                <td class="width2-2" style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'weight'))); ?></td>
                                <td class="width2-2" style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
                                <td class="width2-2" style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
                            </tr>
                            <?php /*else : ?>
                                <tr> 
                                    <td class="width2-1" style="text-align: center;"><?php echo CHtml::encode(CHtml::value($sale, 'employeeIdSalesman.name')); ?></td>
                                    <td class="width2-1" style="text-align: left"><?php //echo CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>
                                    <td class="width2-1" style="text-align: left;"><?php //echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')); ?></td>
                                    <td class="width2-1" style="text-align: center;"><?php echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')); ?></td>
                                    <td class="width2-2" style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.length_request'))); ?></td>
                                    <td class="width2-2" style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.quantity_request'))); ?></td>
                                    <td class="width2-2" style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.weight'))); ?></td>
                                    <td class="width2-2" style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.unit_price'))); ?></td>
                                    <td class="width2-2" style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.total'))); ?></td>
                                </tr>
                            <?php endif; */?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>

                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>