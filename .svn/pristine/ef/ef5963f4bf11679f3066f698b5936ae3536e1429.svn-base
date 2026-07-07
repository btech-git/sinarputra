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
    <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
    <div style="font-size: 2.5em">RETUR PENJUALAN BARANG</div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Retur #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($quotationReturn->getCodeNumber(QuotationReturnHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($quotationReturn, 'date')))); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">No Customer</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($quotationReturn, 'customer.code')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($quotationReturn, 'customer.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Alamat</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($quotationReturn, 'customer.address')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Kota</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($quotationReturn, 'customer.city')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Telepon</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($quotationReturn, 'customer.phone')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Fax</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($quotationReturn, 'customer.fax')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
        <th style="width: 3%">No.</th>
        <th style="width: 10%">Kode</th>
        <th style="text-align: center">Nama Barang</th>
        <th style="width: 5%">Jumlah</th>
        <th style="width: 10%" colspan="2">Harga</th>
        <th style="width: 15%" colspan="2">Total</th>
    </tr>
    <?php $nomor = 1; ?>
    <?php foreach ($quotationReturn->quotationReturnDetails as $i => $detail): ?>
        <?php $productId = CHtml::value($detail, 'product.id'); ?>

        <tr class="titems">
            <td style="text-align: center;"><?php echo $nomor; ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'product.code')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
            <td style="text-align: center; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quotationReturn->getTotalQuantityByProduct($productId))); ?></td>
            <td style="width: 3%; border-right: none">Rp. </td>
            <td style="text-align: right; border-left: none"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'unit_price'))); ?></td>
            <td style="width: 3%; border-right: none">Rp. </td>
            <td style="text-align: right; border-left: none"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quotationReturn->getTotalByProduct($productId))); ?></td>
        </tr>
        <?php $nomor++; ?>

    <?php endforeach; ?>
    <?php for ($j = 12, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-right: none">&nbsp;</td>
            <td style="border-left: none">&nbsp;</td>
            <td style="border-right: none">&nbsp;</td>
            <td style="border-left: none">&nbsp;</td>
        </tr>
    <?php endfor; ?>
    <tr>
        <td style="border-left: 1px solid; border-top: 2px solid; text-align:right" colspan="3">Total</td>
        <td style="border-top: 2px solid; text-align: center; "><?php echo $quotationReturn->getQuotationReturnQuantityTotal($quotationReturn); ?></td>
        <td style="border-top: 2px solid;text-align: right;font-weight: bold" colspan="2">Total</td>
        <td style="border-top: 2px solid">Rp. </td>
        <td style="border-top: 2px solid; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', floor(CHtml::value($quotationReturn, 'subTotal')))); ?></td>
    </tr>
</table>

<div>Catatan : <?php echo CHtml::encode(CHtml::value($quotationReturn, 'note')); ?></div>

<br />

<div class="memosig">
    <div style="font-weight:bold; font-style: italic; " class="divtable">
        <div class="divtablecell sig1">
            <div>Purchasing,</div>
            <div style="height: 80px;"></div>
            <div ></div>
        </div>
        <div class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 80px;"></div>
            <div >Finance</div>
        </div>
        <div class="divtablecell sig3">
            <div>Disetujui,</div>
            <div style="height: 80px;"></div>
            <div ></div>
        </div>
    </div>
</div>