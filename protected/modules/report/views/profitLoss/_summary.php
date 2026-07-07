<style>
    .account {
        font-size: 8pt;
    }

    .summary {
        font-weight: bold;
    }

    .number {
        text-align: right;
    }
</style>

<table style="margin: 0 auto; width: 70%; font-size: larger">
    <!--sale-->
    <tr>
        <td></td>
        <td><?php echo CHtml::value($accounts['sale'], 'name'); ?></td>
        <td></td>
    </tr>	
    <?php foreach ($accounts['sale']->accounts as $account): ?>
        <tr>
            <td class="account"><?php echo CHtml::encode(CHtml::value($account, 'code')); ?></td>
            <td class="account"><?php echo CHtml::encode(CHtml::value($account, 'name')); ?></td>
            <td class="number"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $account->getBalanceTotal($startDate, $endDate))); ?></td>
        </tr>
    <?php endforeach; ?>		
    <tr>
        <td></td>
        <td></td>
        <td style="border-top: 1px solid;"></td>
        <td class="number"><?php echo Yii::app()->numberFormatter->format('#,##0.00', $row['sale_amount']); ?></td>
    </tr>

    <tr><td></td><td></td><td></td></tr>

    <tr>
        <td></td>
        <td>Stock Awal</td>
        <td class="number"><?php echo Yii::app()->numberFormatter->format('#,##0.00', $row['beginning_stock_amount']); ?></td>
        <td></td>
    </tr>

    <tr><td></td><td></td><td></td></tr>

    <tr>
        <td></td>
        <td style="border-top: 1px solid;" class="summary">Laba / Rugi</td>
        <td style="border-top: 1px solid;"></td>
        <td style="border-top: 1px solid;" class="summary number"><?php echo Yii::app()->numberFormatter->format('#,##0.00', $row['profit_loss']); ?></td>
    </tr>
</table>
