<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 10% }
	.width1-2 { width: 10% }
	.width1-3 { width: 15% }
	.width1-4 { width: 10% }
	.width1-5 { width: 15% }
	.width1-6 { width: 10% }
	.width1-7 { width: 10% }
	.width1-8 { width: 10% }
	.width1-9 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Pembelian Penunjang Detail</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="border-bottom: 2px solid;">PO #</th>
        <th class="width1-2" style="border-bottom: 2px solid;">Tanggal</th>
        <th class="width1-3" style="border-bottom: 2px solid;">Supplier</th>
        <th class="width1-4" style="border-bottom: 2px solid;">Nama Barang</th>
        <th class="width1-5" style="border-bottom: 2px solid;">Deskripsi</th>
        <th class="width1-6" style="border-bottom: 2px solid;">Kategori</th>
        <th class="width1-7" style="border-bottom: 2px solid;">Qty</th>
        <th class="width1-8" style="border-bottom: 2px solid;">Harga</th>
        <th class="width1-9" style="border-bottom: 2px solid;">Total</th>
    </tr>
    <?php foreach ($purchaseItemDetailSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <?php foreach ($header->purchaseItemDetails as $detail): ?>
                <tr>
                    <td class="width1-1"><?php echo CHtml::encode($header->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)); ?></td>
                    <td class="width1-2"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
                    <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'supplier.company')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($detail, 'item.name')); ?></td>
                    <td class="width1-5"><?php echo CHtml::encode(CHtml::value($detail, 'item.description')); ?></td>
                    <td class="width1-6"><?php echo CHtml::encode(CHtml::value($detail, 'item.itemCategory.name')); ?></td>
                    <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                    <td class="width1-8" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?></td>
                    <td class="width1-9" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?></td>
                </tr>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="8" style="text-align: right; border-top: 2px solid">TOTAL</th>
        <th class="width1-9" style="text-align: right; border-top: 2px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $this->reportGrandTotal($purchaseItemDetailSummary->dataProvider))); ?></th>
    </tr>
</table>