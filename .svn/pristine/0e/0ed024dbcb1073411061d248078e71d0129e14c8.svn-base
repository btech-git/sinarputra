<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 25% }
	.width1-2 { width: 25% }
	.width1-3 { width: 50% }
	
	.width2-1 { width: 15% }
	.width2-2 { width: 20% }
	.width2-3 { width: 5% }
	.width2-4 { width: 15% }
	.width2-5 { width: 5% }
	.width2-6 { width: 15% }
	.width2-7 { width: 25% }

');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger"><?php echo Yii::app()->name; ?></div>
    <div style="font-size: larger">Laporan Jurnal Penyesuaian</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style="text-align: left;">Tanggal</th>
        <th class="width1-2" style="text-align: left;">Jurnal #</th>
        <th class="width1-3">Catatan</th>
    </tr>
    <tr id="header2">
        <td colspan="3">
            <table>
                <tr>
                    <th class="width2-1" style="text-align: left;">Kode</th>
                    <th class="width2-2" style="text-align: left;">Akun</th>
                    <th class="width2-3">&nbsp;</th>
                    <th class="width2-4" style="text-align: right;">Debit</th>
                    <th class="width2-5">&nbsp;</th>
                    <th class="width2-6" style="text-align: right;">Kredit</th>
                    <th class="width2-7" style="text-align: left;">Memo</th>

                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($journalVoucherSummary->dataProvider->data as $header): ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($header->date))); ?></td>
            <td class="width1-2"><?php echo CHtml::encode($header->getCodeNumber(JournalVoucherHeader::CN_CONSTANT)); ?></td>
            <td class="width1-3"><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
        </tr>
        <tr class="items2">
            <td colspan="3">
                <table>
                    <?php foreach ($header->journalVoucherDetails as $detail): ?>
                        <tr>
                            <td class="width2-1"><?php echo CHtml::encode(CHtml::value($detail, 'account.code')); ?></td>
                            <td class="width2-2"><?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?></td>
                            <td class="width2-3" style="text-align: right">Rp</td>
                            <td class="width2-4" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'debit'))); ?></td>
                            <td class="width2-5" style="text-align: right">Rp</td>
                            <td class="width2-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'credit'))); ?></td>
                            <td class="width2-7" style="text-align: left"><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>