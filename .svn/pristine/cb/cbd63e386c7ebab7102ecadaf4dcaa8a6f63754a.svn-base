<?php
//$purchase as a PurchaseHeader model

$this->breadcrumbs = array(
    'MaterialInvoice' => array('/transaction/materialInvoice/create'),
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
    'data' => $materialInvoice,
    'attributes' => array(
        array(
            'label' => 'Invoice #',
            'value' => $materialInvoice->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $materialInvoice->date),
        ),
        array(
            'label' => 'Jatuh Tempo',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $materialInvoice->due_date),
        ),
        array(
            'label' => 'Customer',
            'value' => $materialInvoice->customer->company,
        ),
        array(
            'label' => 'PO #',
            'value' => $materialInvoice->reference_number,
        ),
        array(
            'label' => 'Faktur Pajak #',
            'value' => $materialInvoice->tax_number,
        ),
        array(
            'label' => 'Salesman',
            'value' => $materialInvoice->employeeIdSalesman->name,
        ),
        array(
            'label' => 'Catatan',
            'value' => $materialInvoice->note,
        ),
        array(
            'label' => 'Created by',
            'value' => $materialInvoice->admin->username,
        ),
    ),
));
?>


<h2>Material</h2>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'invoice-material-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' => array(
        'material_name: Nama Barang',
        'height: Tebal',
        'width: Lebar',
        'length: Panjang',
        array(
            'header' => 'Quantity',
            'value' => 'number_format($data->quantity, 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'unit.name: Satuan',
        'weight: Berat (kg)',
        'quantityWeightLiteral: Berat/Pcs',
        array(
            'header' => 'Harga Satuan',
            'value' => 'number_format($data->unit_price, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Pembulatan',
            'value' => 'number_format($data->rounding_amount, 2)',
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

<br />

<table>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%; font-weight: bold">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->subTotal)); ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%">Discount:</td>
        <td style="text-align: right">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->discount)); ?>)
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%">PPn <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($materialInvoice, 'tax_percentage'))); ?>%:</td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->calculatedTax)); ?>
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%">PPh 2%:</td>
        <td style="text-align: right">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->calculatedTaxIncome)); ?>)
        </td>
    </tr>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%; font-weight: bold">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->grand_total)); ?>
        </td>
    </tr>
</table>

<br />

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $materialInvoice->id), array('target' => '_blank')); ?>
</div>
<br />
