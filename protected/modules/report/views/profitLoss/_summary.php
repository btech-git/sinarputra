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

<table>
    <tbody>
        <?php $balances = array(); ?>
        <?php $coaParentCodes = array(); ?>
        <?php $previousLevel = 0; ?>
        <?php $currentLevel = 0; ?>
        <?php foreach ($profitLossReportData as $coaCode => $profitLossReportItem): ?>
            <?php $currentLevel = $profitLossReportItem['level']; ?>

            <?php $coaParentCodes[$currentLevel] = $profitLossReportItem['parent_code']; ?>

            <?php $balance = isset($profitLossReportItem['balance']) ? $profitLossReportItem['balance'] : ''; ?>
            <?php $balances[$currentLevel]['amounts'][] = empty($balance) ? '0.00' : $balance; ?>

            <?php while ($previousLevel > $currentLevel): ?>
                <?php $amountSum = array_sum($balances[$previousLevel]['amounts']); ?>

                <?php $balances[$previousLevel]['amounts'] = array(); ?>
                <?php $balances[$previousLevel - 1]['amounts'][] = $amountSum; ?>

                <tr>
                    <td style="font-weight: bold; background-color: bisque; padding-left: <?php echo 32 * ($previousLevel - 1); ?>px">
                        Total <?php echo CHtml::encode($profitLossReportData[$coaParentCodes[$previousLevel]]['name']); ?>
                    </td>
                    <td style="font-weight: bold; background-color: bisque; color: <?php echo $amountSum < 0 ? 'red': 'black'; ?>; text-align: right">
                        <?php echo CHtml::encode($amountSum === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?>
                    </td>
                </tr>

                <?php $previousLevel--; ?>
            <?php endwhile; ?>

            <?php if ((int) $coaCode === 600): ?>
                <?php $grossProfit = $accountGroupSums[4] - $accountGroupSums[5]; ?>
                <tr>
                    <td style="font-weight: bold; background-color: greenyellow; padding-left: 16px">Laba Kotor</td>
                    <td style="font-weight: bold; background-color: greenyellow; color: <?php echo $grossProfit < 0 ? 'red': 'black'; ?>; text-align: right">
                        <?php echo CHtml::encode($grossProfit === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $grossProfit)); ?>
                    </td>
                </tr>
            <?php endif; ?>

            <tr>
                <td style="padding-left: <?php echo 32 * $profitLossReportItem['level']; ?>px">
                    <?php echo CHtml::encode($coaCode); ?> - <?php echo CHtml::encode($profitLossReportItem['name']); ?>
                </td>
                <td style="text-align: right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $balance), array('style' => $balance < '0.00' ? 'color:red' : 'color:black')); ?>
                </td>
            </tr>

            <?php $previousLevel = $currentLevel; ?>
        <?php endforeach; ?>
        <?php for ($i = $currentLevel - 1; $i > 0; $i--): ?>
            <?php while ($previousLevel > $i): ?>
                <?php $amountSum = array_sum($balances[$previousLevel]['amounts']); ?>

                <?php $balances[$previousLevel]['amounts'] = array(); ?>
                <?php $balances[$previousLevel - 1]['amounts'][] = $amountSum; ?>

                <tr>
                    <td style="font-weight: bold; background-color: bisque; padding-left: <?php echo 32 * ($previousLevel - 1); ?>px">
                        Total <?php echo CHtml::encode($profitLossReportData[$coaParentCodes[$previousLevel]]['name']); ?>
                    </td>
                    <td style="font-weight: bold; background-color: bisque; color: <?php echo $amountSum < 0 ? 'red': 'black'; ?>; text-align: right">
                        <?php echo CHtml::encode($amountSum === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $amountSum)); ?>
                    </td>
                </tr>

                <?php $previousLevel--; ?>
            <?php endwhile; ?>
        <?php endfor; ?>
        <?php $netProfit = $accountGroupSums[4] - $accountGroupSums[5] - $accountGroupSums[6] + $accountGroupSums[7] - $accountGroupSums[8]; ?>
        <tr>
            <td style="font-weight: bold; background-color: greenyellow; padding-left: 16px">Laba Bersih</td>
            <td style="font-weight: bold; background-color: greenyellow; color: <?php echo $netProfit < 0 ? 'red': 'black'; ?>; text-align: right">
                <?php echo CHtml::encode($netProfit === '' ? '' : Yii::app()->numberFormatter->format('#,##0.00', $netProfit)); ?>
            </td>
        </tr>
    </tbody>
</table>