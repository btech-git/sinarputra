<?php
$this->breadcrumbs = array(
    'Deposit' => array('/transaction/deposit/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $expense,
    'attributes' => array(
        array(
            'label' => 'Pembayaran #',
            'value' => $expense->getCodeNumber(ExpenseHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $expense->date),
        ),
        array(
            'label' => 'Account',
            'value' => CHtml::encode(CHtml::value($expense, 'account.name')),
        ),
        array(
            'label' => 'Catatan',
            'value' => CHtml::encode(CHtml::value($expense, 'note')),
        )
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'expense-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        array(
            'header' => 'Account',
            'value' => 'CHtml::encode(CHtml::value($data, "account.name"))'
        ),
        array(
            'header' => 'Jumlah',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "amount")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'memo',
    ),
));
?>

<table>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold;">Total:</td>
        <td style="text-align: right; font-weight: bold; width: 38%;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ceil(CHtml::value($expense, 'grandTotal')))); ?>
        </td>
        <td style="width: 26%;"></td>
    </tr>
</table>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $expense->id), array('target' => '_blank')); ?>
</div>