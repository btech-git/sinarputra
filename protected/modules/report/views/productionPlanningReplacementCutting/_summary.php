<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 40% }
	.width1-4 { width: 20% }

	.width2-1 { width: 9% }
	.width2-2 { width: 9% }
	.width2-3 { width: 9% }
	.width2-4 { width: 9% }
	.width2-5 { width: 9% }
	.width2-6 { width: 9% }
	.width2-7 { width: 9% }
	.width2-8 { width: 9% }
	.width2-9 { width: 9% }
	.width2-10 { width: 9% }
	.width2-11 { width: 1% }        

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Production Planning Replacement (PPC-R) Cutting</div>
    <?php if ($startDate || $endDate) : ?>
        <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    <?php endif; ?>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left">Tanggal</th>
        <th class="width1-2" style="text-align: left">PPC #</th>
        <th class="width1-3" style="text-align: left">Customer</th>
        <th class="width1-4" style="text-align: left">SPK Replacement #</th>

    </tr>	
    <tr id="header2">
        <td colspan="4">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">Job Number</th>
                    <th class="width2-2" style="text-align: left">Item</th>
                    <th class="width2-3" style="text-align: right">tbl/Dmtr</th>
                    <th class="width2-4" style="text-align: right">Lbr</th>
                    <th class="width2-5" style="text-align: right">Pjg</th>
                    <th class="width2-6" style="text-align: right">Quantity</th>
                    <th class="width2-7" style="text-align: right">Berat</th>
                    <th class="width2-8" style="text-align: right">Mesin</th>
                    <th class="width2-9" style="text-align: right">Group</th>
                    <th class="width2-10" style="text-align: right">Tanggal Proses</th>
                    <th class="width2-11" style="text-align: right">Urgent</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($productionPlanningCuttingSummary->dataProvider->data as $header): ?>
        <?php if ($header->work_order_replacement_header_id != null): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
                <td class="width1-2"><?php echo CHtml::encode($header->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'customer.company')); ?></td>
                <td class="width1-4"><?php echo !empty($header->workOrderReplacementHeader) ? CHtml::encode($header->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)) : ''; ?></td>

            </tr>
            <tr class="items2">
                <td colspan="4">
                    <table>  
                        <?php foreach ($header->productionPlanningCuttingDetails as $detail): ?>
                            <tr>
                                <td class="width2-1" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderReplacementDetail.job_number')); ?></td>
                                <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderReplacementDetail.product_name')); ?></td>
                                <td class="width2-3" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?></td>
                                <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?></td>
                                <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?></td>
                                <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                                <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?></td>
                                <td class="width2-8"><?php echo CHtml::encode(CHtml::value($detail, 'machine.name')); ?></td>
                                <td class="width2-9" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'job_group')); ?></td>
                                <td class="width2-10"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->planning_date))); ?></td>
                                <td class="width2-11"><?php echo CHtml::encode(CHtml::value($detail, 'workOrderReplacementDetail.urgentStatus')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>