<?php $this->breadcrumbs = array(
    'Purchase Return' => array('/transaction/purchaseReturn/create'),
    'View',
); ?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Pelunasan #',
            'value' => $model->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'TT #',
            'value' => CHtml::encode($model->purchaseReceiptHeader->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT))
        ),
        array(
            'label' => 'Supplier',
            'value' => $model->purchaseReceiptHeader->supplier->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $model->note,
        ),
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-return-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        'account.name: Nama Akun',
        'paymentType.name: Tipe Pembayaran',
        array(
            'header' => 'Amount',
            'name' => 'amount',
            'value' => 'number_format($data->amount, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right'
            )
        ),
        'memo'
    ),
)); ?>
<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php //echo CHtml::link('Print', array('memo', 'id'=>$model->id), array('target'=>'_blank'));  ?>
</div>