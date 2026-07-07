<?php
Yii::app()->clientScript->registerCss('_report', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

	.width1-2 { width: 100% }
	
	.width2-1 { width: 25% }
	.width2-2 { width: 25% }
	.width2-3 { width: 25% }
	.width2-4 { width: 25% }
	
');
$startDate = $startDate ? $startDate : date('Y-m-d');
$endDate = $endDate ? $endDate : date('Y-m-d');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Pembelian By Supplier</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Supplier</th>

    </tr>
    <tr id="header2">
        <td>
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">Tanggal</th>
                    <th class="width2-2" style="text-align: left">Pembelian#</th>
                    <th class="width2-3" style="text-align: right">Quantity</th>
                    <th class="width2-4" style="text-align: right">Sub Total</th>

                </tr>
            </table>
        </td>
    </tr>	
    <?php
    $grandTotalQuantity = 0;
    $grandTotal = 0;
    ?>
    <?php foreach ($purchaseBySupplierSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
        </tr>
        <tr class="items2">
            <td>
                <table>
                    <?php
                    $subTotalQuantity = 0;
                    $subTotal = 0;
                    ?>
                    
                    <?php foreach ($header->purchaseHeaders as $purchaseHeader): ?>
                        <?php if ($purchaseHeader->date >= $startDate && $purchaseHeader->date <= $endDate): ?>
                            <tr>
                                <td class="width2-1" style="text-align: left;">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', CHtml::value($purchaseHeader, 'date'))); ?>
                                </td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode($purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?>
                                </td>
                                <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseHeader, 'subTotalQuantity'))); ?></td>
                                <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseHeader, 'subTotal'))); ?></td>

                            </tr>
                            <?php $subTotalQuantity += $purchaseHeader->subTotalQuantity; ?>
                            <?php $subTotal += $purchaseHeader->subTotal; ?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" style="text-align: right">Total </td>
                        <td class="width2-3" style="text-align: right;border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $subTotalQuantity)); ?></td>
                        <td class="width2-3" style="text-align: right;border-top: 1px solid;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $subTotal)); ?></td>
                    </tr>

                </table>
            </td>
        </tr>
        <?php $grandTotalQuantity += $subTotalQuantity; ?>
        <?php $grandTotal += $subTotal; ?>
    <?php endforeach; ?>
    <tr id="header2">
        <td style="border-bottom: 0px solid;">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left"></th>
                    <th class="width2-2" style="text-align: right">GRAND TOTAL</th>
                    <th class="width2-3" style="text-align: right;font-size: smaller;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotalQuantity)); ?></th>
                    <th class="width2-4" style="text-align: right;font-size: smaller;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?></th>
                </tr>
            </table>
        </td>
    </tr>	 

</table>