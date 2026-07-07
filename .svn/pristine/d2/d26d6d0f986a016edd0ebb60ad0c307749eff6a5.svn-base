<?php
Yii::app()->clientScript->registerCss('_report', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 15% }
    .width1-4 { width: 10% }
    .width1-5 { width: 10% }
    .width1-6 { width: 10% }
    .width1-7 { width: 15% }
');
?>

<div class="relative">
    <div style="font-weight: bold; text-align: center">
        <div style="font-size: larger">PT SINAR PUTRA METALINDO</div>
        <div style="font-size: larger">Buku Besar Piutang</div>
        <div>
            <?php echo ' Tanggal: ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?>
        </div>
    </div>

    <br />

    <table style="width: 100%; margin: 0 auto; border-spacing: 0pt">
        <thead style="position: sticky; top: 0">
            <tr>
                <th class="width1-1" style="text-align: center;">Tanggal</th>
                <th class="width1-2" style="text-align: center;">Transaksi #</th>
                <th class="width1-3" style="text-align: center;">Keterangan</th>
                <th class="width1-4" style="text-align: center;">Memo</th>
                <th class="width1-5" style="text-align: center;">Debit</th>
                <th class="width1-6" style="text-align: center;">Credit</th>
                <th class="width1-7" style="text-align: center;">Saldo</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($receivableLedgerSummary->dataProvider->data as $header): ?>
                <tr>
                    <td colspan="6" style="font-weight: bold">
                        <?php echo CHtml::encode(CHtml::value($header, 'code')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($header, 'company')); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold">
                        <?php $saldo = $header->getBeginningBalanceReceivable($startDate); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?>
                    </td>
                </tr>

                <?php $receivableData = $header->getReceivableLedgerReport($startDate, $endDate); ?>
                <?php $totalDebit = '0.00'; ?>
                <?php $totalCredit = '0.00'; ?>
                <?php foreach ($receivableData as $receivableRow): ?>
                    <?php $debit = $receivableRow['debit']; ?>
                    <?php $credit = $receivableRow['credit']; ?>
                    <?php $saldo += $debit - $credit; ?>

                    <tr class="items2">
                        <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receivableRow['transaction_date']))); ?></td>
                        <td><?php echo CHtml::encode($receivableRow['transaction_number']); ?></td>
                        <td><?php echo CHtml::encode($receivableRow['note']); ?></td>
                        <td><?php echo CHtml::encode($receivableRow['memo']); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $debit)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $credit)); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saldo)); ?></td>
                    </tr>
                    
                    <?php $totalDebit += $debit; ?>
                    <?php $totalCredit += $credit; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" style="text-align: right; font-weight: bold">Total</td>
                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo Yii::app()->numberFormatter->format('#,##0', $totalDebit); ?>
                    </td>
                    <td style="text-align: right; font-weight: bold; border-top: 1px solid">
                        <?php echo Yii::app()->numberFormatter->format('#,##0', $totalCredit); ?>
                    </td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>