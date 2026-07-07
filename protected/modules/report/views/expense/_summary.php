<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 25% }
	.width1-2 { width: 30% }
	.width1-3 { width: 45% }

	.width2-1 { width: 15% }
	.width2-2 { width: 15% }
	.width2-3 { width: 12% }
	.width2-4 { width: 5% }
	.width2-5 { width: 15%}
	.width2-6 { width: 5% }
	.width2-7 { width: 2% }
	.width2-8 { width: 2%;}
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Pengeluaran Kas / Bank</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left">Tanggal</th>
        <th class="width1-1" style="text-align: left">Pengeluaran #</th>
        <th class="width1-3" style="text-align: left">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="3" style="border-bottom: 0px solid;">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">Nama Akun</th>
                    <th class="width2-2" style="text-align: left">&nbsp;</th>
                    <th class="width2-7" style="text-align: right">&nbsp;</th>
                    <th class="width2-3" style="text-align: right">Total</th>
                    <th class="width2-6" style="text-align: left">&nbsp;</th>
                    <th class="width2-8" style="text-align: right">&nbsp;</th>
                    <th class="width2-4" style="text-align: right">&nbsp;</th>
                    <th class="width2-6" style="text-align: left">&nbsp;</th>
                    <th class="width2-5" style="text-align: left">&nbsp;</th>

                </tr>
            </table>
        </td>
    </tr>
    <tr id="header2">
        <td colspan="3">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left">&nbsp;</th>
                    <th class="width2-2" style="text-align: left">Nama Akun</th>
                    <th class="width2-7" style="text-align: right">&nbsp;</th>
                    <th class="width2-3" style="text-align: right">&nbsp;</th>
                    <th class="width2-6" style="text-align: left">&nbsp;</th>
                    <th class="width2-8" style="text-align: right">&nbsp;</th>
                    <th class="width2-4" style="text-align: right">Jumlah</th>
                    <th class="width2-6" style="text-align: left">&nbsp;</th>
                    <th class="width2-5" style="text-align: left">Keterangan</th>


                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($expenseSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-2" style="text-align: left"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-1" style="text-align: left"><?php echo CHtml::encode($header->getCodeNumber(ExpenseHeader::CN_CONSTANT)); ?></td>
            <td class="width1-3" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
            <td
    </tr>
    <tr class="items2">
        <td colspan="3">
            <table>
                <tr>
                    <td class="width2-1" style="text-align: left"><?php echo CHtml::encode(CHtml::value($header, 'account.name')); ?></td>
                    <td class="width2-2">&nbsp;</td>
                    <td class="width2-7" style="text-align: right">Rp</td>
                    <td class="width2-3" style="border-top: 0px solid; font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($header->grandTotal))); ?></td>
                    <td class="width2-6" style="text-align: left"></td>
                    <td class="width2-8" style="text-align: right">&nbsp;</td>
                    <td class="width2-4">&nbsp;</td>
                    <td class="width2-6">&nbsp;</td>
                    <td class="width2-5">&nbsp;</td>

                </tr>
                <?php foreach ($header->expenseDetails as $detail): ?>
                    <tr>
                        <td class="width2-1">&nbsp;</td>
                        <td class="width2-2" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?></td>
                        <td class="width2-7" style="text-align: right">&nbsp;</td>
                        <td class="width2-3">&nbsp;</td>
                        <td class="width2-6" style="text-align: left"></td>
                        <td class="width2-8" style="text-align: right">Rp</td>
                        <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->amount)); ?></td>
                        <td class="width2-6" style="text-align: left"><?php //echo CHtml::encode(CHtml::value($detail, 'memo'));             ?>&nbsp;</td>
                        <td class="width2-5" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </td>
    </tr>
<?php endforeach; ?>

<tr id="header2">
    <td colspan="3" style="border-bottom: 0px solid;">
        <table>
            <tr>
                <th class="width2-1">&nbsp;</th>
                <th class="width2-2" style="text-align: left"></th>
                <th class="width2-7" style="text-align: right">&nbsp;</th>
                <th class="width2-3" style="text-align: right">TOTAL</th>
                <th class="width2-6" style="text-align: left"></th>
                <th class="width2-8" style="text-align: right">Rp</th>
                <th class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($expenseSummary->dataProvider)))); ?></th>
                <th class="width2-6" style="text-align: left"></th>
                <th class="width2-5" style="text-align: left"></th>
            </tr>
        </table>
    </td>            
</tr>
</table>