<?php
$this->breadcrumbs = array(
    'Quotation Return' => array('/transaction/quotationReturn/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $quotationReturn,
    'attributes' => array(
        array(
            'label' => 'Retur #',
            'value' => $quotationReturn->getCodeNumber(QuotationReturnHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $quotationReturn->date),
        ),
        array(
            'label' => 'Customer',
            'value' => $quotationReturn->customer->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $quotationReturn->note,
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quotation-return-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        'product.name: Nama Barang',
        array(
            'header' => 'Qty Retur',
            'value' => 'number_format($data->quantity, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Harga Satuan',
            'value' => 'number_format($data->unit_price, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Total',
            'value' => 'number_format($data->total, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
    ),
));
?>
<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $quotationReturn->id), array('target' => '_blank')); ?>
</div>