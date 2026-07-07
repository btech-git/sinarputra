<?php
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

    .hcolumn1header { width: 20% }
    .hcolumn1value { width: 80% }
    .hcolumn2header { width: 20% }
    .hcolumn2value { width: 80% }

    .sig1 { width: 25%; border: 1px solid; padding-top:0px;}
    .sig2 { width: 25%; border: 1px solid; padding-top:0px;}
    .sig3 { width: 25%; border: 1px solid; padding-top:0px; }
    .sig4 { width: 25%; border: 1px solid; padding-top:0px; }
        
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
');
?>

<div id="memoheader">
    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" width="100%"/></div>
    <div class="memo-title">
        <div style="font-size: 16px">PT. SINAR PUTRA METALINDO</div>
        <div style="font-size: 14px">PURCHASE ORDER</div>
    </div>
    <div class="clear"></div>
</div>

<br /><br />
<br /><br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">PO</div>
                    <div class="divtablecell info hcolumn1value">: <?php echo CHtml::encode($purchaseItem->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Tanggal</div>
                    <div class="divtablecell info hcolumn1value">: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchaseItem, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Phone</div>
                    <div class="divtablecell info hcolumn2value">: <?php echo CHtml::encode(CHtml::value($purchaseItem, 'supplier.phone')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Fax</div>
                    <div class="divtablecell info hcolumn2value">: <?php echo CHtml::encode(CHtml::value($purchaseItem, 'supplier.fax')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Supplier</div>
                    <div class="divtablecell info hcolumn2value" style="font-weight: bold">: <?php echo CHtml::encode(CHtml::value($purchaseItem, 'supplier.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Address</div>
                    <div class="divtablecell info hcolumn2value">
                        : 
                        <?php echo CHtml::encode(CHtml::value($purchaseItem, 'supplier.address_main')); ?>
                        <?php echo CHtml::encode(CHtml::value($purchaseItem, 'supplier.address_secondary')); ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Up.</div>
                    <div class="divtablecell info hcolumn2value">: <?php echo CHtml::encode(CHtml::value($purchaseItem, 'supplier.name')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
        <th style="width: 3%">No.</th>
        <th style="width: 13%">Nama Barang</th>
        <th>Ukuran</th>
        <th style="width: 7%">Qty</th>
        <th style="width: 7%">Sat</th>
        <th style="width: 15%">Harga</th>
        <th style="width: 15%">Total</th>
    </tr>

    <?php foreach ($purchaseItem->purchaseItemDetails as $i => $detail): ?>
        <tr class="titems">
            <td style="text-align: center"><?php echo $i + 1; ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'item.name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'item.description')); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'item.unit.name')); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'total'))); ?></td>
        </tr>	
    <?php endforeach; ?>
    <?php for ($j = 15, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    <?php endfor; ?>
    <tr>
        <td style="border-top: 1px solid; text-align: right" colspan="5">Total</td>
        <td style="border-top: 1px solid; text-align: right">Rp. </td>
        <td style="border-top: 1px solid; text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseItem, 'subTotal'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right" colspan="5">Discount</td>
        <td style="text-align: right">Rp. </td>
        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseItem, 'discount'))); ?></td>
    </tr>
    <tr>
        <td style="text-align:right" colspan="5">DPP</td>
        <td style="text-align: right">Rp. </td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseItem, 'totalBeforeTax'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right" colspan="5">PPn <?php echo CHtml::encode(CHtml::value($purchaseItem, 'tax_percentage')); ?>%</td>
        <td style="text-align: right">Rp. </td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseItem, 'calculatedTax'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right" colspan="5">PPh 2%</td>
        <td style="text-align: right">Rp. </td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseItem, 'calculatedTaxIncome'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right; font-weight: bold" colspan="5">Grand Total</td>
        <td style="text-align: right">Rp. </td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseItem, 'grandTotal'))); ?>
        </td>
    </tr>
</table>

<div>
    <p>
        Catatan: <?php echo CHtml::encode(CHtml::value($purchaseItem, 'note')); ?><br />
        Tanggal Dibutuhkan: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchaseItem, 'estimate_receive_date')))); ?><br />
        Payment <?php echo CHtml::encode(CHtml::value($purchaseItem, 'paymentStatus')); ?> setelah tukar faktur
    </p>
</div>

<div class="memosig">
    <div style="font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div style="font-weight:bold; border-bottom: 1px solid">Dibuat,</div>
            <div style="height: 80px;"></div>
            <div><?php echo CHtml::encode(CHtml::value($purchaseItem, 'adminPurchasing.name')); ?></div>
            <div>Purchasing</div>
        </div>
        <div class="divtablecell sig2">
            <div style="font-weight:bold; border-bottom: 1px solid; border-left: none">Diketahui,</div>
            <div style="height: 80px;"></div>
            <div><?php echo CHtml::encode(CHtml::value($purchaseItem, 'adminAccounting.name')); ?></div>
            <div>Accounting Koord</div>
        </div>
        <div class="divtablecell sig3">
            <div style="font-weight:bold; border-bottom: 1px solid">Disetujui,</div>
            <div style="height: 80px;"></div>
            <div><?php echo CHtml::encode(CHtml::value($purchaseItem, 'adminFinance.name')); ?></div>
            <div>FAM</div>
        </div>
        <?php if ($purchaseItem->grandTotal >= 10000000): ?>
            <div class="divtablecell sig4">
                <div style="font-weight:bold; border-bottom: 1px solid">Disetujui,</div>
                <div style="height: 80px;"></div>
                <div>Rianto Jusman</div>
                <div>Managing Director</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div>
    <p style="text-align: center; font-size: 10px">
        Office / Workshop: <br />
        Jl. Johar Blok F6 No. 3A-B Delta Silicon II Industrial Park, Lippo Cikarang - Bekasi 17550<br />
        Telp Hunting: (021)89904100, 89904500, 29577584-6 Fax: (021) 89904145<br />
        Email: sales@sinarputrametalindo.com
    </p>
</div>