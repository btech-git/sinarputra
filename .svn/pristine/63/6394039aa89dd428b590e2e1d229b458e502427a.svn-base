<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 15% }
	.width1-2 { width: 15% }
	.width1-3 { width: 15% }
	.width1-4 { width: 15% }
        .width1-5 { width: 15% }
        .width1-6 { width: 10% }
        .width1-7 { width: 15% }
        .width1-8 { width: 15% }

	.width2-1 { width: 15% }
	.width2-2 { width: 15% }
	.width2-3 { width: 50% }
	.width2-4 { width: 15% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Faktur Pelunasan Material</div>
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
        <th class="width1-6" >Total</th>
        <th class="width1-7" >Payment</th>
        <th class="width1-8" >Remaining</th>

    </tr>
    <tr id="header2">
        <td colspan="8">
            <table>
                <tr>
                    <th class="width2-1">Payment #</th>
                    <th class="width2-2">Tanggal</th>
                    <th class="width2-3" style="text-align: center">Memo</th>
                    <th class="width2-4" style="text-align: center">Amount</th>
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
            <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'grand_total'))); ?></td>
            <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'total_payment'))); ?></td>
            <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'remaining_payment'))); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="8">
                <table>
                    <?php foreach ($header->materialPaymentDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode($detail->materialPaymentHeader->getCodeNumber(MaterialPaymentHeader::CN_CONSTANT)); ?></td>
                            <td class="width2-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->materialPaymentHeader->date_transaction))); ?></td>
                            <td class="width2-3">
                                <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                            </td>
                            <td class="width2-4" style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->amount)); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>