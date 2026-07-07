<?php
$this->breadcrumbs = array(
    'Sale Receipt' => array('/transaction/saleReceipt/create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $saleReceipt,
    'attributes' => array(
        array(
            'label' => 'Tanda Terima #',
            'value' => $saleReceipt->getCodeNumber(SaleReceiptHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal Cetak',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleReceipt->date),
        ),
        array(
            'label' => 'Tanggal Terima',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleReceipt->date_receipt),
        ),
        array(
            'label' => 'Jatuh Tempo',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleReceipt->due_date),
        ),
        'customer.company',
        array(
            'label' => 'Catatan',
            'value' => $saleReceipt->note,
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-receipt-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'columns' => array(
        array(
            'header' => ' Nomor Faktur Penjualan',
            'value' => '$data->saleInvoiceHeader->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT)',
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->saleInvoiceHeader->date)'
        ),
        array(
            'header' => 'Memo',
            'value' => '$data->memo',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Total',
            'value' => 'number_format(CHtml::value($data, "total_invoice"), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        )
    )
));
?>

<table>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; text-align: right; width:80%;">Total:</td>
        <td style="font-weight: bold; text-align: right;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt, 'totalReceipt'))); ?>
        </td>
    </tr>
</table>
<br/>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $saleReceipt->id), array('target' => '_blank')); ?>
</div>