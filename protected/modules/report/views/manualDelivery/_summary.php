<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 5% }
	.width1-2 { width: 25% }
	.width1-3 { width: 15% }
	.width1-4 { width: 15% }
	.width1-5 { width: 15% }
	.width1-6 { width: 25% }
    
	.width2-1 { width: 10% }
	.width2-2 { width: 10% }
	.width2-3 { width: 15% }
	.width2-4 { width: 50% }
	.width2-5 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Delivery Daily Report</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left">No</th>
        <th class="width1-2" style="text-align: left">Customer</th>
        <th class="width1-3" style="text-align: left">NO Delivery</th>
        <th class="width1-4" style="text-align: left">NO SPK</th>
        <th class="width1-5" style="text-align: left">NO PO</th>
        <th class="width1-6" style="text-align: left">Salesman</th>
    </tr>
    <tr id="header2">
        <td colspan="6">
            <table>
                <tr>
                    <th class="width2-1">Quantity</th>
                    <th class="width2-2">Berat</th>
                    <th class="width2-3">Sopir</th>
                    <th class="width2-4">KET</th>
                    <th class="width2-5">User</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php $number = 1 ?>
    <?php foreach ($deliverySummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1" style="text-align: left"><?php echo $number;$number++ ?></td>
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
            <td class="width1-3"><?php echo CHtml::encode($header->getCodeNumber(DeliveryHeader::CN_CONSTANT)); ?></td>
            <td class="width1-4"><?php echo $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : ''; ?></td>
            <td class="width1-5"><?php echo $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->saleHeader->customer_order_number) : ''; ?></td>
            <td class="width1-6"><?php echo $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->saleHeader->employeeIdSalesman->name) : ''; ?></td>
        </tr>
        <tr class="items2">
            <td colspan="6">
                <table>
                    <?php foreach ($header->deliveryDetails as $detail): ?>
                        <tr>    
                            <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                            <td class="width2-7" style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?></td>
                            <td class="width2-8" style="text-align: center"></td>
                            <td class="width2-9" style="text-align: center"></td>
                            <td class="width1-10"><?php echo CHtml::encode(CHtml::value($header, 'admin.name')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>