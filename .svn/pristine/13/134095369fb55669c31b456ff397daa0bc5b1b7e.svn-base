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

		.sig1 { width: 15% }
		.sig2 { width: 15% }
		.sig3 { width: 15% }
		.sig4 { width: 15% }
		.sig5 { width: 15% }
		.sig6 { width: 25% }
	');
?>

<div id="memoheader">
    <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
    <div style="font-size: larger">Jurnal Pengeluaran</div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Pengeluaran #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($expense->getCodeNumber(ExpenseHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($expense, 'date')))); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Account</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($expense, 'account.name')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr id="theader">
        <th width="40%">Account</th>
        <th width="15%">Jumlah</th>
        <th>Memo</th>
    </tr>
    <?php foreach ($expense->expenseDetails as $i => $detail): ?>
        <tr class="titems">
            <td><?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php for ($j = 5, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    <?php endfor; ?>
    <tr>
        <td style="border-top: 2px solid; font-weight: bold">Total</td>
        <td style="border-top: 2px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($expense, 'grandTotal'))); ?></td>
        <td style="border-top: 2px solid"></td>
    </tr>
</table>

<div style="text-transform: capitalize">
    Terbilang:
    <?php echo CHtml::encode(NumberWord::numberName(CHtml::value($expense, 'grandTotal'))); ?>
    rupiah
</div>
<br/>
<div>
    CATATAN: <?php echo CHtml::encode(CHtml::value($expense, 'note')); ?>
</div>

<br />

<div class="memosig">
    <div class="divtable">
        <div class="divtablecell sig1">
            <div>Dibuat,</div>
        </div>

        <div class="divtablecell sig2">
            <div>Disetujui,</div>
        </div>

        <div class="divtablecell sig3">
            <div>Diketahui,</div>
        </div>

        <div class="divtablecell sig4">
            <div>Dibukukan,</div>
        </div>

        <div class="divtablecell sig5">
            <div>Diterima Oleh,</div>
        </div>

        <div class="divtablecell sig6">
            <div>Diketahui,</div>
        </div>
    </div>
</div>
