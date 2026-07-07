<?php
Yii::app()->clientScript->registerCss('_report', '
        @page {
                size:auto;
                margin: 5px 0px 0px 0px;
            }

	.width2-4 { width: 25% }
	.width2-5 { width: 25% }
    .width2-4 { width: 25% }
    .width2-5 { width: 25% }
	
');
$startDate = $startDate ? $startDate : date('Y-m-d');
$endDate = $endDate ? $endDate : date('Y-m-d');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Omzet Per Sales By Grade Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">SE Name</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">SE Code</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Steel Grade</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Steel Aplication</th>
    </tr>
   
    <?php foreach ($saleOmzetSalesmanSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->saleHeaders as $sale): ?>
            <?php foreach ($sale->saleDetails as $detail): ?>
                <?php if ($detail->quotation_detail_product_id == NULL) : ?>
                    <tr class="items1">
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($detail, 'quotationDetailService.product_name')); ?></td>
                        <td class="width1-2"><?php //echo CHtml::encode(CHtml::value($detail, 'quotationDetailService.product_name')); ?></td>
                    </tr>
                <?php else : ?>
                    <tr class="items1">
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'name')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'code')); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')); ?></td>
                        <td class="width1-2"><?php //echo CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>