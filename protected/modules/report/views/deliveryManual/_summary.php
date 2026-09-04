<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 2% }
	.width1-2 { width: 6% }
	.width1-3 { width: 8% }
	.width1-4 { width: 8% }
	.width1-5 { width: 5% }
	.width1-6 { width: 20% }
	.width1-7 { width: 6% }
	.width1-8 { width: 6% }
	.width1-9 { width: 15% }

	.width2-1 { width: 20% }
	.width2-2 { width: 20% }
	.width2-3 { width: 5% }
	.width2-4 { width: 5% }
	.width2-5 { width: 5% }
	.width2-6 { width: 5% }
	.width2-7 { width: 5% }
	.width2-8 { width: 2% }
	.width2-9 { width: 2% }
	.width2-10 { width: 2% }
	.width2-11 { width: 2% }
	.width2-12 { width: 2% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pengiriman Manual</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1">No</th>
        <th class="width1-2">Tanggal</th>
        <th class="width1-3">Pengiriman #</th>
        <th class="width1-4">SPK #</th>
        <th class="width1-5">Gudang</th>
        <th class="width1-6">Customer</th>
        <th class="width1-7">Sopir</th>
        <th class="width1-8">Pembuat</th>
        <th class="width1-9">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="9">
            <table>
                <tr>
                    <th class="width2-1">GRADE</th>
                    <th class="width2-2">Kategori</th>
                    <th class="width2-3">Tbl/Dmtr</th>
                    <th class="width2-4">Lbr/Dmtr</th>
                    <th class="width2-5">Panjang</th>
                    <th class="width2-6">Berat</th>
                    <th class="width2-7">Quantity</th>
                    <th class="width2-8">M</th>
                    <th class="width2-9">SM</th>
                    <th class="width2-10">G</th>
                    <th class="width2-11">HT</th>
                    <th class="width2-12">NTD</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php $number = 0; ?>
    <?php foreach ($deliveryManualSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo ++$number; ?></td>
            <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-3"><?php echo CHtml::encode($header->getCodeNumber(ManualDeliveryHeader::CN_CONSTANT)); ?></td>
            <td class="width1-4"><?php echo $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : ''; ?></td>
            <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'warehouse.name')); ?></td>
            <td class="width1-6"><?php echo CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></td>
            <td class="width1-7"><?php echo CHtml::encode(CHtml::value($header, 'driver')); ?></td>
            <td class="width1-8"><?php echo CHtml::encode(CHtml::value($header, 'admin.username')); ?></td>
            <td class="width1-9"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="9">
                <table>
                    <?php foreach ($header->manualDeliveryDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'grade_name')); ?></td>
                            <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?></td>
                            <td class="width2-3" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'height')); ?></td>
                            <td class="width2-4" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'width')); ?></td>
                            <td class="width2-5" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'length')); ?></td>
                            <td class="width2-6" style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?></td>
                            <td class="width2-7" style="text-align: center">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                            </td>
                            <td class="width2-8" style="text-align: center"><?php echo $detail->is_miling == 1 ? "Yes" : ""; ?></td>
                            <td class="width2-9" style="text-align: center"><?php echo $detail->is_sidemiling == 1 ? "Yes" : ""; ?></td>
                            <td class="width2-10" style="text-align: center"><?php echo $detail->is_grinding == 1 ? "Yes" : ""; ?></td>
                            <td class="width2-11" style="text-align: center"><?php echo $detail->is_hardness == 1 ? "Yes" : ""; ?></td>
                            <td class="width2-12" style="text-align: center"><?php echo $detail->is_annelying == 1 ? "Yes" : ""; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>