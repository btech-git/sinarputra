<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 40% }
	.width1-4 { width: 20% }

	.width2-1 { width: 8% }
	.width2-2 { width: 8% }
	.width2-3 { width: 8% }
	.width2-4 { width: 8% }
	.width2-5 { width: 8% }
	.width2-6 { width: 8% }
	.width2-7 { width: 8% }
	.width2-8 { width: 8% }
	.width2-9 { width: 8% }
	.width2-11 { width: 8% }
	.width2-10 { width: 8% }       
        .width2-12 { width: 4% } 
        .width2-13 { width: 10% }         

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Production Miling Summary</div>
    <?php if ($startDate || $endDate) : ?>
        <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    <?php endif; ?>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left">Tanggal</th>
        <th class="width1-2" style="text-align: left">Production  #</th>
        <th class="width1-3" style="text-align: left">PPC #</th>
        <th class="width1-4" style="text-align: left">SPK #</th>
    </tr>	
    <tr id="header2">
        <td colspan="4">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">Customer</th>
                    <th class="width2-2" style="text-align: left">Job Number</th>
                    <th class="width2-3" style="text-align: right">Item</th>
                    <th class="width2-4" style="text-align: right">Tbl/Dmtr</th>
                    <th class="width2-5" style="text-align: right">Lbr</th>
                    <th class="width2-6" style="text-align: right">Pjg</th>
                    <th class="width2-7" style="text-align: right">Quantity</th>
                    <th class="width2-8" style="text-align: right">Quantity SPK</th>
                    <th class="width2-9" style="text-align: right">Quantity Miling</th>                    
                    <th class="width2-10" style="text-align: right">Berat</th>
                    <th class="width2-11" style="text-align: right">Mesin</th>
                    <th class="width2-12" style="text-align: right">Operator</th>
                    <th class="width2-13" style="text-align: right">Tanggal Produksi</th>

                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($productionMilingSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-2"><?php echo CHtml::encode($header->getCodeNumber(ProductionMilingHeader::CN_CONSTANT)); ?></td>
            <td class="width1-3"><?php echo CHtml::encode($header->productionPlanningMilingHeader->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)); ?></td>
            <td class="width1-4"><?php echo CHtml::encode($header->productionPlanningMilingHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>        </tr>
        <tr class="items2">
            <td colspan="4">
                <table>  
                    <?php foreach ($header->productionMilingDetails as $detail): ?>
                        <?php if ($detail->is_inactive == 0): ?>
                                <tr>
                                    <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
                                    <td class="width2-2" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.job_number')); ?></td>
                                    <td class="width2-3"><?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.product_name')); ?></td>
                                    <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height_request'))); ?></td>
                                    <td class="width2-5" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width_request'))); ?></td>
                                    <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length_request'))); ?></td>
                                    <td class="width2-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantity'))); ?></td>
                                    <td class="width2-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.quantity'))); ?></td>
                                    <td class="width2-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'productionPlanningMilingDetail.quantity'))); ?></td>
                                    <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?></td>
                                    <td class="width2-11" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'machineIdFacemil.name')); ?></td>
                                    <td class="width2-12"><?php echo CHtml::encode(CHtml::value($detail, 'employeeIdFacemil.nameAndGroup')); ?></td>
                                    <td class="width2-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->production_date_facemil))); ?></td>
                                </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>