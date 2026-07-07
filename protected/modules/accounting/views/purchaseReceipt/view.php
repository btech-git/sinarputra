<?php
$this->breadcrumbs = array(
    'Purchase Return' => array('/transaction/purchaseReturn/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Tanda Terima #',
            'value' => $model->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'Jatuh Tempo',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->due_date),
        ),
        array(
            'label' => 'Supplier',
            'value' => $model->supplier->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $model->note,
        ),
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-receipt-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        array(
            'header' => 'Invoice #',
            'value' => '$data->purchaseInvoice->getCodeNumber(PurchaseInvoice::CN_CONSTANT)'
        ),
        array(
            'header' => 'Date',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->purchaseInvoice->date)',
        ),
        array(
            'header' => 'Amount',
            'value' => 'empty($data->purchase_invoice_id) ? 0.00 : number_format($data->purchaseInvoice->grand_total, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'memo'
    ),
)); ?>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php //echo CHtml::link('Print', array('memo', 'id'=>$model->id), array('target'=>'_blank'));  ?>
</div>