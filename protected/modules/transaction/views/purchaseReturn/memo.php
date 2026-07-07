<?php
	//$purchaseReturn as PurchaseReturnHeader model

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
    
    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" width="100%"/></div>
    <div class="memo-title">
         <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
         <div style="font-size: 2.5em">RETUR PEMBELIAN BARANG</div>
    </div>
    <div class="clear"></div>
   
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Retur #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($purchaseReturn->getCodeNumber(PurchaseReturnHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchaseReturn, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Penerimaan #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($purchaseReturn->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">

                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Supplier</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($purchaseReturn, 'supplier.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Alamat</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($purchaseReturn, 'supplier.address')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Telepon</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($purchaseReturn, 'supplier.phone')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
		<th>Nama Barang</th>
		<th style="width: 5%">Jumlah</th>
		<th style="width: 10%" >Harga</th>
		<th style="width: 15%" >Total</th>
    </tr>

    <?php foreach ($purchaseReturn->purchaseReturnDetails as $i => $detail): ?>
	
    <tr class="titems">
            <td><?php echo CHtml::encode(CHtml::value($detail, 'receiveDetail.purchaseDetail.product_name')); ?></td>
            <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity)); ?></td>
            <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price)); ?></td>
            <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?></td>
    </tr>
    
    <?php endforeach; ?>
    <?php for ($j = 12, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    <?php endfor; ?>
        <tr>
            <td style="border-left: 1px solid; border-top: 2px solid; text-align:right; font-weight: bold">Total</td>
            <td style="border-top: 2px solid;  border-right: 1px solid; text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseReturn->quantityTotal)); ?></td>
            <td style="border-top: 2px solid; font-weight: bold;border-left: 1px solid;">Rp. </td>
            <td style="border-top: 2px solid;  border-right: 1px solid; text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchaseReturn->getGrandTotal())); ?></td>
        </tr>
</table>

<div>Catatan: <?php echo CHtml::encode(CHtml::value($purchaseReturn, 'note')); ?></div>
<br />

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div>Purchasing,</div>
            <div style="height: 80px;"></div>
            <div ></div>
        </div>
        <div class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 80px;"></div>
            <div ></div>
        </div>
        <div class="divtablecell sig3">
            <div>Disetujui,</div>
            <div style="height: 80px;"></div>
            <div ></div>
        </div>
    </div>
</div>