<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 10% }
	.width1-4 { width: 10% }
	.width1-5 { width: 10% }
	.width1-6 { width: 10% }
	.width1-7 { width: 5% }
	.width1-8 { width: 5% }
	.width1-9 { width: 5% }
	.width1-10 { width: 5% }
	.width1-11 { width: 5% }
	.width1-12 { width: 10% }
	.width1-13 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pembelian Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="border-bottom: 2px solid;">PO #</th>
        <th class="width1-2" style="border-bottom: 2px solid;">Tanggal</th>
        <th class="width1-3" style="border-bottom: 2px solid;">Supplier</th>
        <th class="width1-4" style="border-bottom: 2px solid;">Tipe</th>
        <th class="width1-5" style="border-bottom: 2px solid;">Grade</th>
        <th class="width1-6" style="border-bottom: 2px solid;">Kategori</th>
        <th class="width1-7" style="border-bottom: 2px solid;">Tbl/Dmtr</th>
        <th class="width1-8" style="border-bottom: 2px solid;">Lbr</th>
        <th class="width1-9" style="border-bottom: 2px solid;">Pjg</th>
        <th class="width1-10" style="border-bottom: 2px solid;">Qty</th>
        <th class="width1-11" style="border-bottom: 2px solid;">Berat</th>
        <th class="width1-12" style="border-bottom: 2px solid;">Harga</th>
        <th class="width1-13" style="border-bottom: 2px solid;">Total</th>
    </tr>
    <?php foreach ($purchaseDetailSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <?php if ($header->is_service == 1) : ?>
                <?php foreach ($header->purchaseDetailServices as $service): ?>
                    <tr>
                        <td class="width1-1"><?php echo CHtml::encode($header->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'importStatus')); ?></td>
                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($service, 'name')); ?></td>
                        <td class="width1-6">&nbsp;</td>
                        <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($service, 'height'))); ?></td>
                        <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($service, 'width'))); ?></td>
                        <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($service, 'length'))); ?></td>
                        <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity'))); ?></td>
                        <td class="width1-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($service, 'weight'))); ?></td>
                        <td class="width1-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($service, 'unit_price'))); ?></td>
                        <td class="width1-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($service, 'total'))); ?></td>
                    </tr>
                <?php endforeach; ?>   
            <?php else : ?>
                <?php foreach ($header->purchaseDetails as $detail): ?>
                    <tr>
                        <td class="width1-1"><?php echo CHtml::encode($header->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?></td>
                        <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
                        <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'importStatus')); ?></td>
                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                        <td class="width1-6"><?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?></td>
                        <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?></td>
                        <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?></td>
                        <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?></td>
                        <td class="width1-10" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                        <td class="width1-11" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?></td>
                        <td class="width1-12" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
                        <td class="width1-13" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="12" style="text-align: right; border-top: 2px solid">TOTAL</th>
        <th class="width1-13" style="text-align: right; border-top: 2px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $this->reportGrandTotal($purchaseDetailSummary->dataProvider))); ?></th>
    </tr>
</table>