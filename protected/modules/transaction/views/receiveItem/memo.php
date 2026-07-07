<?php
	//$receive as ReceiveHeader model
	//$purchaseNumber

Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 25% }
    .sig2 { width: 50% }
    .sig3 { width: 25% }
');
?>

<div id="memoheader">
    <div style="font-size: 2em">PT. SINAR PUTRA METALINDO</div>
    <div style="font-size: 1.5em">PENERIMAAN BARANG PENUNJANG</div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Penerimaan #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($receiveItem->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($receiveItem, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">PO #</div>
                    <div class="divtablecell info hcolumn2value"><?php echo $receiveItem->purchaseItemHeader ? $receiveItem->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT) : ''; ?></div>

                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Supplier</div>
                    <div class="divtablecell info hcolumn1value" style="font-weight: bold"><?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseItemHeader.supplier.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Alamat</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseItemHeader.supplier.address_main')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Telepon</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseItemHeader.supplier.phone')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Fax</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($receiveItem, 'purchaseItemHeader.supplier.fax')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
        <th style="text-align: center;width: 3%;">No.</th>
        <th style="width: 20%; text-align: center">Nama Barang</th>
        <th style="text-align: center">Ukuran</th>
        <th style="width: 20%; text-align: center">Type</th>
        <th style="width: 10%; text-align: center">Quantity</th>
        <th style="width: 10%; text-align: center">Unit</th>
    </tr>

    <?php foreach ($receiveItem->receiveItemDetails as $i => $detail): ?>
    <tr class="titems">
        <td style="text-align: center;"><?php echo $i +1; ?></td>
        <td><?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.name')); ?></td>
        <td><?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.description')); ?></td>
        <td><?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.itemCategory.name')); ?></td>
        <td style="text-align: center;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity)); ?></td>
        <td><?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.unit.name')); ?></td>
    </tr>
    <?php endforeach; ?>
    <?php for ($j = 5, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>	
            <td>&nbsp;</td>
            <td>&nbsp;</td>	
            <td>&nbsp;</td>	
        </tr>
    <?php endfor; ?>
</table>

<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($receiveItem, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic; " class="divtable">
        <div style="" class="divtablecell sig1">
            <div>Penerima,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($receive, 'employeeIdReceiver.name'));  ?></div>
        </div>
        <div style="" class="divtablecell sig2">
            <div>Pengecek,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($receive, 'employeeIdChecker.name'));  ?></div>
        </div>
        <div style="" class="divtablecell sig3">
            <div>Admin,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($receive, 'admin.name'));  ?></div>
        </div>
    </div>
</div>