<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 20% }
	.width1-2 { width: 20% }
	.width1-3 { width: 20% }
	.width1-4 { width: 20% }
	.width1-5 { width: 20% }        
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Quality Control Cutting (Summary)</div>
    <?php if ($startDate || $endDate) : ?>
        <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
    <?php endif; ?>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left; border-bottom: 2px solid;">QC Cutting #</th>
        <th class="width1-1" style="text-align: left; border-bottom: 2px solid;">Tanggal QC Cutting</th>
        <th class="width1-3" style="text-align: left; border-bottom: 2px solid;">SPK</th>
        <th class="width1-4" style="text-align: left; border-bottom: 2px solid;">Customer</th>
        <th class="width1-5" style="text-align: left; border-bottom: 2px solid;">Production Cutting #</th>        
    </tr>	

    <?php foreach ($qualityControlCuttingSummary->dataProvider->data as $header): ?>
    
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode($header->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT)); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>         
            <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
            <td class="width1-5" style="text-align: left">
                <?php echo CHtml::encode($header->productionCuttingHeader->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>