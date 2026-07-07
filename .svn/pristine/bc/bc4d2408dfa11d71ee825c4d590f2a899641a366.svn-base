<?php
$this->breadcrumbs = array(
    'Journal Voucher' => array('/transaction/adjustmentJournal/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $journalVoucher,
    'attributes' => array(
        array(
            'label' => 'Jurnal #',
            'value' => $journalVoucher->getCodeNumber(JournalVoucherHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $journalVoucher->date),
        ),
        array(
            'label' => 'Catatan',
            'value' => CHtml::encode(CHtml::value($journalVoucher, 'note')),
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'journal-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        'account.code: Kode Akun',
        'account.name: Nama Akun',
        array(
            'header' => 'Debit',
            'value' => 'number_format($data->debit, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Credit',
            'value' => 'number_format($data->credit, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'memo',
    ),
));
?>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
</div>