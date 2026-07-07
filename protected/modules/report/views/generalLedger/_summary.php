<?php
Yii::app()->clientScript->registerCss('_report', '
	.width1-1 { width: 75% }
	.width1-2 { width: 25% }

	.width2-1 { width: 10% }
	.width2-2 { width: 10% }
	.width2-3 { width: 20% }
	.width2-4 { width: 30% }
	.width2-5 { width: 10% }
	.width2-6 { width: 10% }
	.width2-7 { width: 10% }
');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Buku Besar</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-1" style ="text-align: center;">Akun</th>
        <th class="width1-2" style ="text-align: center;">Saldo Awal</th>
    </tr>
    <tr id="header2">
        <td colspan="2">
            <table>
                <tr>
                    <th class="width2-1" style ="text-align: center;">Transaksi</th>
                    <th class="width2-2" style ="text-align: center;">Tanggal</th>
                    <th class="width2-3" style ="text-align: center;">Memo</th>
                    <th class="width2-4" style ="text-align: center;">Remarks</th>
                    <th class="width2-5" style ="text-align: center;">Debit</th>
                    <th class="width2-6" style ="text-align: center;">Kredit</th>
                    <th class="width2-7" style ="text-align: center;">Saldo</th>
                </tr>
            </table>
        </td>
    </tr>
    <?php foreach ($generalLedgerReport as $i => $dataItem): ?>
        <?php $beginningBalance = isset($ledgerBeginningBalanceData[$dataItem['account_id']]) ? $ledgerBeginningBalanceData[$dataItem['account_id']] : '0.00'; ?>
        <tr class="items1">
            <td class="width1-1"><?php echo CHtml::encode($dataItem['account_code']); ?> - <?php echo CHtml::encode($dataItem['account_name']); ?></td>
            <td class="width1-2" style ="text-align: right;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $beginningBalance)); ?>
            </td>
        </tr>
        <tr class="items2">
            <td colspan="2">
                <table>
                    <?php $totalDebit = '0.00'; ?>
                    <?php $totalCredit = '0.00'; ?>
                    <?php $generalLedgerReportData = JournalAccounting::model()->findAll(array(
                        'condition' => 'account_id = :account_id AND date BETWEEN :start_date AND :end_date', 
                        'params' => array(
                            ':account_id' => $dataItem['account_id'],
                            ':start_date' => $startDate,
                            ':end_date' => $endDate,
                        ),
                    )); ?>
                    <?php if (!empty($generalLedgerReportData)): ?>
                        <?php $currentBalance = $beginningBalance; ?>
                    
                        <?php foreach ($generalLedgerReportData as $generalLedgerRow): ?>
                            <?php $debitAmount = $generalLedgerRow['debit']; ?>
                            <?php $creditAmount = $generalLedgerRow['credit']; ?>
                            <?php $currentBalance += $debitAmount - $creditAmount; ?>
                            <tr>
                                <td class="width2-1"><?php echo CHtml::encode($generalLedgerRow['transaction_number']); ?></td>
                                <td class="width2-2">
                                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($generalLedgerRow['date']))); ?>
                                </td>
                                <td class="width2-3"><?php echo CHtml::encode($generalLedgerRow['transaction_subject']); ?></td>
                                <td class="width2-4"><?php echo CHtml::encode($generalLedgerRow['note']); ?></td>
                                <td class="width2-5" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $debitAmount)); ?>
                                </td>
                                <td class="width2-6" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $creditAmount)); ?>
                                </td>
                                <td class="width2-7" style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $currentBalance)); ?>
                                </td>
                            </tr>
                            <?php $totalDebit += $debitAmount; ?>
                            <?php $totalCredit += $creditAmount; ?>
                        <?php endforeach; ?>
                    <?php endif;  ?>
                    <tr>
                        <td colspan="4" style="text-align: right">Total</td>
                        <td class="width2-5" style="text-align: right; border-top: 2px solid">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?>
                        </td>
                        <td class="width2-6" style="text-align: right; border-top: 2px solid">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>