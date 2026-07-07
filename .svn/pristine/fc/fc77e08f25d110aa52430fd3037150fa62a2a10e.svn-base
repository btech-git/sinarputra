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

    .sig1 { width: 25%; border: 1px solid; padding-top:0px; }
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

<br /><br /><br /><br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">PO </div>
                    <div class="divtablecell info hcolumn1value">: <?php echo CHtml::encode($purchase->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Tanggal</div>
                    <div class="divtablecell info hcolumn1value">: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchase, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Phone</div>
                    <div class="divtablecell info hcolumn2value">: <?php echo CHtml::encode(CHtml::value($purchase, 'supplier.phone')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Fax</div>
                    <div class="divtablecell info hcolumn2value">: <?php echo CHtml::encode(CHtml::value($purchase, 'supplier.fax')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Supplier</div>
                    <div class="divtablecell info hcolumn2value" style="font-weight: bold">: <?php echo CHtml::encode(CHtml::value($purchase, 'supplier.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">Address</div>
                    <div class="divtablecell info hcolumn2value">
                        : 
                        <?php echo CHtml::encode(CHtml::value($purchase, 'supplier.address_main')); ?> 
                        <?php echo CHtml::encode(CHtml::value($purchase, 'supplier.address_secondary')); ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Up.</div>
                    <div class="divtablecell info hcolumn1value">: <?php echo CHtml::encode(CHtml::value($purchase, 'supplier.name')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />
<?php if ($purchase->is_service == 0): ?> 
    <table class="memo">
        <tr id="theader">
            <th style="width: 3%">No.</th>
            <th style="width: 13%">Nama Barang</th>
            <th>Tebal/Dmtr</th>
            <?php if ($purchase->purchaseDetails[0]->product_category_id != 2): ?>
                <th>Lebar</th>
            <?php endif; ?>
            <th>Panjang</th>
            <th style="width: 10%">Quantity</th>
            <th style="width: 10%">Unit</th>
            <th style="width: 10%">Berat</th>
            <th style="width: 15%">Harga</th>
            <th style="width: 15%">Total</th>
        </tr>

        <?php foreach ($purchase->purchaseDetails as $i => $detail): ?>
            <tr class="titems">
                <td style="text-align: center"><?php echo $i+1; ?></td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($detail, 'height')); ?>
                </td>
                <?php if ($detail->product_category_id != 2): ?>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(CHtml::value($detail, 'width')); ?>
                    </td>
                <?php endif; ?>
                <td style="text-align: right">
                    <?php echo CHtml::encode(CHtml::value($detail, 'length')); ?>
                </td>
                <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity)); ?></td>
                <td style="text-align: center"><?php echo 'Pcs'; ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->weight)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?> </td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->total)); ?></td>
            </tr>	
        <?php endforeach; ?>
        <?php for ($j = 15, $i = $i % $j + 1; $j > $i; $j--): ?>
            <tr class="titems">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php if ($detail->product_category_id != 2): ?>
                    <td>&nbsp;</td>
                <?php endif; ?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php endfor; ?>
        <tr>
            <td style="border-top: 1px solid; text-align:right" colspan=<?php echo ($detail->product_category_id != 2) ? "5" : "4"; ?>>Total Quantity</td>
            <td style="border-top: 1px solid; border-right: 1px solid; text-align: center">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'subTotalQuantity'))); ?>
            </td>
            <td style="border-top: 1px solid; text-align: right" colspan="2">Sub Total</td>
            <td style="border-top: 1px solid; text-align: right">Rp. </td>
            <td style="border-top: 1px solid; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'subTotal'))); ?>
            </td>
        </tr>
    </table>
<?php else: ?>
    <table class="memo">
        <tr id="theader">
            <th>GRADE</th>
            <th style="text-align:center;">Tebal Awal</th>
            <th style="text-align:center;">Tebal Akhir</th>
            <th style="text-align:center;">Lebar Awal</th>
            <th style="text-align:center;">Lebar Akhir</th>
            <th style="text-align:center;">Panjang Awal</th>
            <th style="text-align:center;">Panjang Akhir</th>
            <th style="text-align:center;">Quantity Final</th>
            <th style="text-align:center;">Berat</th>
            <th style="text-align:center;">M</th>
            <th style="text-align:center;">G</th>
            <th style="text-align:center;">FH</th>
            <th style="text-align:center;">ANNL</th>
            <th style="text-align:center;">SM</th>
            <th style="width: 10%">Harga</th>
            <th style="width: 15%">Total</th>
        </tr>
        <?php foreach ($purchase->purchaseDetailServices as $i => $detail): ?>
            <tr class="titems">
                <td><?php echo CHtml::encode(CHtml::value($detail, 'name')); ?><br /></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->height_initial)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->height_final)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->width_initial)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->width_final)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->length_initial)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->length_final)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->quantity)); ?></td>
                <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->weight)); ?></td>
                <td style="text-align: center">
                    <?php echo CHtml::checkBox('IsMiling', CHtml::value($detail, 'is_miling'), array(
                        'disabled' => 'disabled'
                    )); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::checkBox('IsGrinding', CHtml::value($detail, 'is_grinding'), array(
                        'disabled' => 'disabled'
                    )); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::checkBox('IsHardness', CHtml::value($detail, 'is_hardness'), array(
                        'disabled' => 'disabled'
                    )); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::checkBox('IsAnnelying', CHtml::value($detail, 'is_annelying'), array(
                        'disabled' => 'disabled'
                    )); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::checkBox('IsAnnelying', CHtml::value($detail, 'is_sidemiling'), array(
                        'disabled' => 'disabled'
                    )); ?>
                </td>
                <?php //if ($purchase->is_tax) : ?>
                    <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?></td>
                    <td style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->totalService)); ?></td>
                <?php /*else: ?>
                    <td style="text-align: right; "><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amountTax'))); ?></td>
                    <td style="text-align: right;"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->totalServiceTax)); ?></td>
                <?php endif;*/ ?>
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
        <tr>    
            <td style="border-left: 1px solid; border-top: 2px solid; text-align:right" colspan="7">Total Quantity</td>
            <td style="border-top: 2px solid; border-right: 1px solid; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'serviceSubTotalQuantity'))); ?>
            </td>
            <td style="border-left: 1px solid; border-top: 2px solid; text-align:right" colspan="6">Sub Total</td>
            <td style="border-top: 2px solid">Rp. </td>
            <td style="border-top: 2px solid; border-right: 1px solid; text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'serviceSubTotal'))); ?>
            </td>
        </tr>
    </table>
<?php endif; ?>
<table class="memo">
    <tr>
        <td style="text-align: right; border-left: 1px solid; border-top: 1px solid; width: 75%;">
            Diskon 
        </td>
        <td style="border-top: 1px solid; width: 20%">Rp. </td>
        <td style="text-align: right; border-right: 1px solid;border-top: 1px solid; width: 5%">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase, 'discount'))); ?>)
        </td>
    </tr>
    <tr>
        <td style="border-left: 1px solid; text-align:right">DPP</td>
        <td>Rp. </td>
        <td style="border-right: 1px solid; text-align: right">
        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'totalBeforeTax'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right; border-left: 1px solid; width: 75%;">
            PPn <?php echo CHtml::encode(CHtml::value($purchase, 'tax_percentage')); ?>%                        
        </td>
        <td>Rp. </td>
        <td style="text-align: right; border-right: 1px solid">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'calculatedTax'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right; border-left: 1px solid; width: 75%;">
            PPh <?php echo ((int)$purchase->is_tax_income === 1) ? 0.3 : 0; ?>%                        
        </td>
        <td>Rp. </td>
        <td style="text-align: right; border-right: 1px solid">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'calculatedTaxIncome'))); ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right; font-weight: bold; border-left: 1px solid; width: 75%; border-bottom: 1px solid" >Grand Total</td>
        <td style="border-bottom: 1px solid">Rp. </td>
        <td style="text-align: right; border-right: 1px solid; font-weight: bold; border-bottom: 1px solid">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchase, 'grandTotal'))); ?>
        </td>
    </tr>
</table>

<div>
    <p>
        Catatan: <?php echo CHtml::encode(CHtml::value($purchase, 'note')); ?><br />
        Tanggal Dibutuhkan: <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchase, 'estimate_receive_date')))); ?><br />
        Payment <?php echo CHtml::encode(CHtml::value($purchase, 'paymentStatus')); ?> setelah tukar faktur
    </p>
</div>

<div class="memosig">
    <div style="font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div style="font-weight:bold; border-bottom: 1px solid">Dibuat,</div>
            <div style="height: 80px;"></div>
            <div><?php echo CHtml::encode(CHtml::value($purchase, 'adminPurchasing.name')); ?></div>
            <div>Purchasing</div>
        </div>
        <div class="divtablecell sig2">
            <div style="font-weight:bold; border-bottom: 1px solid; border-left: none">Diketahui,</div>
            <div style="height: 80px;"></div>
            <div><?php echo CHtml::encode(CHtml::value($purchase, 'adminAccounting.name')); ?></div>
            <div>Accounting Koord</div>
        </div>
        <div class="divtablecell sig3">
            <div style="font-weight:bold; border-bottom: 1px solid">Disetujui,</div>
            <div style="height: 80px;"></div>
            <div><?php echo CHtml::encode(CHtml::value($purchase, 'adminFinance.name')); ?></div>
            <div>FAM</div>
        </div>
        <?php if ($purchase->grandTotal >= 10000000): ?>
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