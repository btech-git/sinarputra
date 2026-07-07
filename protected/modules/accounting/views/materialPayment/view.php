<?php
$this->breadcrumbs = array(
    'Manual Invoice Payment 2' => array('create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $materialPayment,
    'attributes' => array(
        array(
            'label' => 'Pembayaran #',
            'value' => $materialPayment->getCodeNumber(MaterialPaymentHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal Mutasi',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $materialPayment->date_transaction),
        ),
        array(
            'label' => 'Tanggal Pembayaran',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $materialPayment->date_payment),
        ),
        array(
            'label' => 'Customer',
            'value' => $materialPayment->customer->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $materialPayment->note,
        ),
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-payment-detail-grid',
    'dataProvider' => new CArrayDataProvider($materialPayment->materialPaymentDetails),
    'columns' => array(
        array(
            'header' => 'Invoice #',
            'value' => '$data->materialInvoiceHeader->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT)',
        ),
        array(
            'header' => 'Tanggal Invoice',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->materialInvoiceHeader->date)',
        ),
        'account.name: Nama Akun',
        'paymentType.name: Tipe Pembayaran',
        'memo',
        array(
            'header' => 'PPh 23',
            'value' => 'number_format($data->income_tax, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
        ),
        array(
            'header' => 'Pembayaran',
            'value' => 'number_format($data->amount, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'accountIdAdditionalPayment1.name: Akun Selisih 1',
        array(
            'header' => 'Selisih Bayar 1',
            'value' => 'number_format($data->additional_payment_1, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'accountIdAdditionalPayment2.name: Akun Selisih 2',
        array(
            'header' => 'Selisih Bayar 2',
            'value' => 'number_format($data->additional_payment_2, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
    ),
)); ?>

<table style="background-color: greenyellow">
    <tr>
        <td style="width: 80%; text-align: right; font-weight: bold">Total Pelunasan</td>
        <td style="width: 20%; text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($materialPayment, 'totalPayment'))); ?>
        </td>
    </tr>
</table>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?> &nbsp;
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>