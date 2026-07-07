<?php
$this->breadcrumbs = array(
    'Sale Payment' => array('create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $salePayment,
    'attributes' => array(
        array(
            'label' => 'Pembayaran Manual #',
            'value' => $salePayment->getCodeNumber(ManualSalePaymentHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal Mutasi',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date_created),
        ),
        array(
            'label' => 'Tanggal Pembayaran',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date),
        ),
        array(
            'label' => 'Customer',
            'value' => $salePayment->customer->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $salePayment->note,
        ),
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-payment-detail-grid',
    'dataProvider' => new CArrayDataProvider($salePayment->manualSalePaymentDetails),
    'columns' => array(
        array(
            'header' => 'Invoice #',
            'value' => '$data->manualSaleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)',
        ),
        array(
            'header' => 'Tanggal Invoice',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->manualSaleInvoiceHeader->date)',
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
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalPayment'))); ?>
        </td>
    </tr>
    <tr>
        <td style="width: 80%; text-align: right; font-weight: bold">
            Total Selisih Bayar 1
        </td>
        <td style="width: 20%; text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'additional_payment_1'))); ?>
        </td>
    </tr>
    <tr>
        <td style="width: 80%; text-align: right; font-weight: bold">
            Total Selisih Bayar 2
        </td>
        <td style="width: 20%; text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'additional_payment_2'))); ?>
        </td>
    </tr>
</table>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>