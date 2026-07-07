<?php
$this->breadcrumbs = array(
    'Purchase Return' => array('/transaction/purchaseReturn/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $purchaseReturn,
    'attributes' => array(
        array(
            'label' => 'Retur #',
            'value' => $purchaseReturn->getCodeNumber(PurchaseReturnHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseReturn->date),
        ),
        array(
            'label' => 'Penerimaan #',
            'value' => $purchaseReturn->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Supplier',
            'value' => $purchaseReturn->receiveHeader->purchaseHeader->supplier->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $purchaseReturn->note,
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-return-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        'receiveDetail.purchaseDetail.product_name: Nama Barang',
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
    <?php echo CHtml::link('Print', array('memo', 'id' => $purchaseReturn->id), array('target' => '_blank')); ?>
</div>