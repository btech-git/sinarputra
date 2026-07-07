<?php
//$purchase as a PurchaseHeader model

$this->breadcrumbs = array(
    'PurchaseItem' => array('/transaction/purchaseItem/create'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $purchaseItem,
    'attributes' => array(
        array(
            'label' => 'Pembelian Item #',
            'value' => $purchaseItem->getCodeNumber(PurchaseItemHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseItem->date),
        ),
        array(
            'label' => 'Tanggal Dibutuhkan',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchaseItem->estimate_receive_date),
        ),
        array(
            'label' => 'Supplier',
            'value' => $purchaseItem->supplier->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $purchaseItem->note,
        ),
    ),
));
?>


<h2>Item</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' => array(
        'item.code: Kode Barang',
        'item.name: Nama Barang',
        'item.description: Deskipsi',
        'item.itemCategory.name: Category',
        array(
            'header' => 'Quantity',
            'value' => 'number_format($data->quantity, 0)',
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
));
?>

<br />

<table>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%; font-weight: bold">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->subTotal)); ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%">Discount:</td>
        <td style="text-align: right">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->discount)); ?>)
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%">PPn <?php echo CHtml::encode(CHtml::value($purchaseItem, 'tax_percentage')); ?>%:</td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->calculatedTax)); ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%">PPh 2%:</td>
        <td style="text-align: right">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->calculatedTaxIncome)); ?>)
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%; font-weight: bold">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->grandTotal)); ?>
        </td>
    </tr>
</table>

<br />

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $purchaseItem->id), array('target' => '_blank')); ?>
</div>
<br />
