<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 5% }
	.width1-2 { width: 20% }
	.width1-3 { width: 5% }
	.width1-4 { width: 5% }
	.width1-5 { width: 5% }
	.width1-6 { width: 5% }
	.width1-7 { width: 5% }
	.width1-8 { width: 5% }
	.width1-9 { width: 10% }
	.width1-10 { width: 10% }
	.width1-11 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Penerimaan Detail Inventory</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="border-bottom: 2px solid;">Grade</th>
        <th class="width1-2" style="border-bottom: 2px solid;">Note</th>
        <th class="width1-3" style="border-bottom: 2px solid;">Serial #</th>
        <th class="width1-4" style="border-bottom: 2px solid;">LOC</th>
        <th class="width1-5" style="border-bottom: 2px solid;">Tebal</th>
        <th class="width1-6" style="border-bottom: 2px solid;">Lebar</th>
        <th class="width1-7" style="border-bottom: 2px solid;">Panjang</th>
        <th class="width1-8" style="border-bottom: 2px solid;">Berat</th>
        <th class="width1-9" style="border-bottom: 2px solid;">HRC</th>
        <th class="width1-10" style="border-bottom: 2px solid;">Number Heat</th>
        <th class="width1-11" style="border-bottom: 2px solid;">Supplier</th>
    </tr>
    
    <?php foreach ($receiveSummary->dataProvider->data as $header): ?>
        <?php foreach ($header->receiveDetails as $detail): ?>
            <tr>
                <td class="width1-1"><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                <td class="width1-3"><?php echo CHtml::encode(CHtml::value($detail, 'serial_number')); ?></td>
                <td class="width1-4"><?php echo CHtml::encode(CHtml::value($detail, 'location.name')); ?></td>
                <td class="width1-5" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'height')); ?></td>
                <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'width')); ?></td>
                <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'length')); ?></td>
                <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?></td>
                <td class="width1-9"><?php echo CHtml::encode(CHtml::value($detail, 'hardness_scale')); ?></td>
                <td class="width1-10"><?php echo CHtml::encode(CHtml::value($detail, 'number_heat')); ?></td>
                <td class="width1-11"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
            </tr>
        <?php endforeach; ?>    
    <?php endforeach; ?>
</table>