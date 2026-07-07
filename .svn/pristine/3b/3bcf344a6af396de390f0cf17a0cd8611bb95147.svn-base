<?php
Yii::app()->clientScript->registerScript('memo', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
	.hcolumn1 { width: 35% }
	.hcolumn2 { width: 35% }
	.hcolumn3 { width: 30% }

	.hcolumn1header { width: 35% }
	.hcolumn1value { width: 65% }
	.hcolumn2header { width: 35% }
	.hcolumn2value { width: 65% }
	.hcolumn3header { width: 35% }
	.hcolumn3value { width: 65% }

	.sig1 { width: 25% }
	.sig2 { width: 50% }
	.sig3 { width: 25% }
');
?>

<div id="memoheader">

    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" width="100%"/></div>
    <div class="memo-title">
        <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
        <div style="font-size: 1.5em">TANDA TERIMA PENJUALAN MANUAL 2</div>
    </div>
    <div class="clear"></div>

</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanda Terima #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($materialReceipt->getCodeNumber(MaterialReceiptHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($materialReceipt, 'date')))); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($materialReceipt, 'customer.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Catatan</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($materialReceipt, 'note')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<br/>
<table class="memo">
    <tr id="theader">
        <th style="text-align: center; width: 3%">No</th>
        <th style="text-align: center; width: 15%">Faktur #</th>
        <th style="text-align: center; width: 15%">Tanggal</th>
        <th style="text-align: center; width: 15%">F. Pajak</th>
        <th style="text-align: center; width: 15%">Jumlah</th>
        <th style="text-align: center;">Memo</th>
    </tr>
    <?php $number = 1; ?>
    <?php foreach ($materialReceipt->materialReceiptDetails as $i => $detail): ?>
        <tr class="titems">
            <td style="border-bottom: 1px solid;text-align: center;">
                <?php echo $number;
                $number++; ?>
            </td>
            <td style="border-bottom: 1px solid;">
                <?php echo CHtml::encode($detail->materialInvoiceHeader->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT)); ?>
            </td>
            <td style="border-bottom: 1px solid;">
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($detail, 'materialInvoiceHeader.date')))); ?>
            </td>
            <td style="text-align: right;border-bottom: 1px solid;">
                <?php echo CHtml::encode(CHtml::value($detail, 'materialInvoiceHeader.tax_number')); ?>
            </td>
            <td style="text-align: right;border-bottom: 1px solid;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'materialInvoiceHeader.grand_total'))); ?>
            </td>
            <td style="text-align: right;border-bottom: 1px solid;">
                <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php for ($j = 7, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td style="border-bottom: 1px solid;">&nbsp;</td>
            <td style="border-bottom: 1px solid;">&nbsp;</td>
            <td style="border-bottom: 1px solid;">&nbsp;</td>
            <td style="border-bottom: 1px solid;">&nbsp;</td>
            <td style="border-bottom: 1px solid;">&nbsp;</td>
            <td style="border-bottom: 1px solid;">&nbsp;</td>
        </tr>
    <?php endfor; ?>
    <tr>
        <td style="border-top: 2px solid; text-align: right" colspan="4">Total</td>
        <td style="border-top: 2px solid; text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', floor(CHtml::value($materialReceipt, 'grand_total')))); ?>
        </td>
        <td style="border-top: 2px solid">&nbsp;</td>
    </tr>
</table>

<div style="text-transform: capitalize">
    Terbilang:
    <?php echo CHtml::encode(NumberWord::numberName(floor(CHtml::value($materialReceipt, 'grand_total')))); ?>
    rupiah
</div>

<br />

<div>
    CATATAN: <?php echo CHtml::encode(CHtml::value($materialReceipt, 'note')); ?>
</div>

<br />


<div class="memosig">
    <div class="divtable">
        <div class="divtablecell sig1">
            <div>Diterima Oleh,</div>
            <div style="height: 110px;"></div>
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                <div style="float: center;">
                    <?php echo CHtml::encode(CHtml::value($materialReceipt, 'customer.company')); ?>
                </div>
            </div>
        </div>
        <div class="divtablecell sig2">
            <div>Diserahkan Oleh,</div>
        </div>
    </div>
</div>