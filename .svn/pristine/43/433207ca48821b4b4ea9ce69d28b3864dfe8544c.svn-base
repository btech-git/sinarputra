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

    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" width="100%"/></div>
    <div class="memo-title">
        <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
        <div style="font-size: 2.5em">PENERIMAAN BARANG</div>
    </div>
    <div class="clear"></div>

</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Penerimaan #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($receive->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($receive, 'date')))); ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Gudang</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($receive->warehouse->name); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">PO #</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo $receive->purchaseHeader ? $receive->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT) : ''; ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Supplier</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($receive, 'supplier.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Alamat</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($receive, 'supplier.address')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Telepon</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($receive, 'supplier.phone')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Fax</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($receive, 'supplier.fax')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
        <th style="width: 10%; text-align: center">Serial Number</th>
        <th style="text-align: center">Nama Barang</th>
        <th style="width: 10%; text-align: center">Kategori</th>
        <th style="width: 10%; text-align: center">Tinggi/Dmtr</th>
        <th style="width: 10%; text-align: center">Lebar/Dmtr</th>
        <th style="width: 10%; text-align: center">Panjang</th>
        <th style="width: 10%; text-align: center">Berat</th>
        <th style="width: 10%; text-align: center">HRC</th>
        <th style="width: 10%; text-align: center">Number Heat</th>
        <th style="width: 10%; text-align: center">Lokasi</th>
        <th style="width: 10%; text-align: center">Memo</th>

    </tr>

    <?php foreach ($receive->receiveDetails as $i => $detail): ?>
        <?php $productId = CHtml::value($detail, 'purchaseDetail.product_id'); ?>
        <tr class="titems">
            <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'serialConstant')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?></td>
            <td style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->height)); ?></td>
            <td style="text-align: right;">
                <?php echo $detail->product_category_id == 2 ? '' : CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->width)); ?>
            </td>
            <td style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->length)); ?></td>
            <td style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->weight)); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'hardness_scale')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'number_heat')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'location.name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
        </tr>


    <?php endforeach; ?>
    <?php for ($j = 4, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    <?php endfor; ?>

</table>

<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($receive, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic; " class="divtable">
        <div style="" class="divtablecell sig1">
            <div>Penerima,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($receive, 'employeeIdReceiver.name'));     ?></div>
        </div>
        <div style="" class="divtablecell sig2">
            <div>Pengecek,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($receive, 'employeeIdChecker.name'));     ?></div>
        </div>
        <div style="" class="divtablecell sig3">
            <div>Admin,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($receive, 'admin.name'));     ?></div>
        </div>
    </div>
</div>