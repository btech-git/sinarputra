<?php
$this->breadcrumbs = array(
    'Adjustment' => array('/transaction/adjustment/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $adjustment,
    'attributes' => array(
        array(
            'label' => 'Penyesuaian #',
            'value' => $adjustment->getCodeNumber(AdjustmentHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $adjustment->date),
        ),
        array(
            'label' => 'Gudang',
            'value' => $adjustment->warehouse->name,
        ),
        array(
            'label' => 'Catatan',
            'value' => $adjustment->note,
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'adjustment-detail-grid',
    'dataProvider' => new CArrayDataProvider($adjustment->adjustmentDetails),
    'columns' => array(
        'product.name: Nama Barang',
        array(
            'header' => 'Jumlah Stok',
            'value' => 'number_format($data->quantity_current, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Jumlah Penyesuaian',
            'value' => 'number_format($data->quantity_adjustment, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
    ),
));
?>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
</div>