<?php
Yii::app()->clientScript->registerCss('_report', '
     @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

    .width2-1 { width: 10% }
    .width2-2 { width: 10% }
    .width2-3 { width: 8% }
    .width2-4 { width: 7% }
    .width2-5 { width: 5% }
    .width2-6 { width: 5% }
    .width2-7 { width: 5% }
    .width2-8 { width: 5% }
    .width2-9 { width: 5% }
    .width2-10 { width: 5% }
    .width2-11 { width: 10% }
    .width2-12 { width: 10% }
    .width2-13 { width: 15% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan SPK Detail By Serial Number</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width2-1" style="border-bottom: 2px solid;">SPK #</th>
        <th class="width2-2" style="border-bottom: 2px solid;">Serial #</th>
        <th class="width2-3" style="border-bottom: 2px solid;">GRADE</th>
        <th class="width2-4" style="border-bottom: 2px solid;">TIPE</th>
        <th class="width2-5" style="border-bottom: 2px solid;">Tebal</th>
        <th class="width2-6" style="border-bottom: 2px solid;">Lebar</th>
        <th class="width2-7" style="border-bottom: 2px solid;">Panjang</th>
        <th class="width2-8" style="border-bottom: 2px solid;">Toleransi</th>
        <th class="width2-9" style="border-bottom: 2px solid;">Panjang Asal</th>
        <th class="width2-10" style="border-bottom: 2px solid;">PCS</th>
        <th class="width2-11" style="border-bottom: 2px solid;">Sisa</th>
        <th class="width2-12" style="border-bottom: 2px solid;">Keterangan</th>
        <th class="width2-13" style="border-bottom: 2px solid;">Customer</th>
    </tr>

    <?php foreach ($workOrderCuttingDetailMaterialSummary->dataProvider->data as $header): ?>
        <tr>
            <td class="width2-1"><?php echo CHtml::encode($header->workOrderCuttingDetail->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></td>
            <td class="width2-2"><?php echo CHtml::encode(CHtml::value($header, 'serialConstant')); ?></td>
            <td class="width2-3"><?php echo CHtml::encode(CHtml::value($header, 'product_name')); ?></td>
            <td class="width2-4"><?php echo CHtml::encode(CHtml::value($header, 'productCategory.name')); ?></td>
            <td class="width2-5"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'height'))); ?></td>
            <td class="width2-6"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'width'))); ?></td>
            <td class="width2-7" ><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'length'))); ?></td>
            <td class="width2-8"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'weight_tolerance'))); ?></td>
            <td class="width2-9"></td>
            <td class="width2-10" style="text-align: center; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($header, 'quantity'))); ?></td>
            <td class="width2-11" style="text-align: center;"></td>
            <td class="width2-12" style="text-align: center;"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingDetail.note')); ?></td>
            <td class="width2-13" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingDetail.workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
        </tr> 
    <?php endforeach; ?>
</table>