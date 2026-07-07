
<?php
$this->breadcrumbs = array(
    'ReceiveItem' => array('create'),
    'View',
);
?>
<h1>Penerimaan Barang Penunjang <?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $receiveItem,
        'attributes' => array(
            array(
                'label' => 'Penerimaan Item#',
                'value' => $receiveItem->getCodeNumber(ReceiveItemHeader::CN_CONSTANT),
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $receiveItem->date),
            ),
            array(
                'label' => 'Supplier',
                'value' => CHtml::encode(CHtml::value($receiveItem, 'purchaseItemHeader.supplier.company')),
            ),
            array(
                'label' => 'Catatan',
                'value' => $receiveItem->note,
            ),
            array(
                'label' => 'Pembelian #',
                'value' => $receiveItem->purchaseItemHeader ? $receiveItem->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT) : '',
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'material-receive-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'columns' => array(
            'purchaseItemDetail.item.name: Nama Barang',
            'purchaseItemDetail.item.description: Ukuran',
            'purchaseItemDetail.item.itemCategory.name: Kategori',
            array(
                'header' => 'Quantity',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'purchaseItemDetail.item.unit.name: Satuan',
        ),
    ));
    ?>
    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('Manage', array('admin')); ?>
        <?php echo CHtml::link('Print', array('memo', 'id' => $receiveItem->id), array('target' => '_blank')); ?>
    </div>
</div>

