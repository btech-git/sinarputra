<?php
$this->breadcrumbs = array(
    'Purchase Invoice' => array('receiveList'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Invoice Pembelian #',
            'value' => $transactionNumber,
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'Penerimaan #',
            'value' => isset($model->receiveHeader) ? $model->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT) : $model->receiveItemHeader->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)
        ),
        array(
            'label' => 'Supplier',
            'value' => isset($model->receiveHeader) ? $model->receiveHeader->supplier->company : $model->receiveItemHeader->purchaseItemHeader->supplier->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $model->note,
        ),
    ),
)); ?>

<?php if ($model->is_item) : ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-return-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'columns' => array(
            array(
                'header' => 'Code',
                'value' => 'CHtml::encode(CHtml::value($data, "purchaseItemDetail.item.code"))'
            ),
            array(
                'header' => 'Product Name',
                'value' => 'CHtml::encode(CHtml::value($data, "purchaseItemDetail.item.name"))'
            ),
            'quantity',
            array(
                'header' => 'Harga',
                'value' => 'number_format($data->purchaseItemDetail->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->total, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>
<?php else : ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-invoice-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'columns' => array(
            array(
                'header' => 'Product Name',
                'value' => 'CHtml::encode(CHtml::value($data, "product_name"))'
            ),
            'length',
            'width',
            'height',
            array(
                'header' => 'Quantity',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Berat',
                'value' => 'number_format($data->weight, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Harga',
                'value' => 'number_format($data->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->total, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>
<?php endif; ?>

<table>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php //if (empty($model->receiveHeader)): ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->subTotal)); ?>
            <?php /*else: ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->receiveHeader->purchaseHeader->subTotal)); ?>
            <?php endif;*/ ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">
            Disc: <?php echo empty($model->receiveHeader) ? CHtml::encode($model->receiveItemHeader->purchaseItemHeader->discount) : 0; ?>%
        </td>
        <td style="text-align: right; font-weight: bold">
            <?php //if (empty($model->receiveHeader)): ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->discount_amount)); ?>
            <?php /*else: ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->receiveHeader->purchaseHeader->discountAmount)); ?>
            <?php endif;*/ ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">PPN 11 %:</td>
        <td style="text-align: right; font-weight: bold">
            <?php //if (empty($model->receiveHeader)): ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTax)); ?>
            <?php /*else: ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->receiveHeader->purchaseHeader->calculatedTax)); ?>
            <?php endif;*/ ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">PPh 2 %:</td>
        <td style="text-align: right; font-weight: bold">
            <?php //if (empty($model->receiveHeader)): ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTaxIncome)); ?>
            <?php /*else: ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->receiveHeader->purchaseHeader->calculatedTaxIncome)); ?>
            <?php endif;*/ ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php //if (empty($model->receiveHeader)): ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->grandTotal)); ?>
            <?php /*else: ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->receiveHeader->purchaseHeader->grandTotal)); ?>
            <?php endif;*/ ?>
        </td>
    </tr>
</table>

<div id="link">
    <?php echo CHtml::link('Create', array('receiveList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>