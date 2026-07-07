<?php
//$purchase as a PurchaseHeader model

$this->breadcrumbs = array(
    'Purchase' => array('/transaction/purchase/create'),
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
    'data' => $purchase,
    'attributes' => array(
        array(
            'label' => 'Pembelian #',
            'value' => $purchase->getCodeNumber(PurchaseHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchase->date),
        ),
        array(
            'label' => 'Tanggal Dibutuhkan',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $purchase->estimate_receive_date),
        ),
        array(
            'label' => 'Supplier',
            'value' => $purchase->supplier->company,
        ),
        array(
            'label' => 'Delivery',
            'value' => $purchase->delivery_period . ' hari PO diterima',
        ),
        array(
            'label' => 'Payment',
            'value' => $purchase->paymentStatus . ' setelah tukar faktur',
        ),
        array(
            'label' => 'Valid',
            'value' => $purchase->valid_period . ' hari',
        ),
        array(
            'label' => 'Lokal / Impor',
            'value' => ($purchase->is_import) ? 'Impor' : 'Lokal'
        ),
        array(
            'label' => 'Currency',
            'value' => CHtml::encode(CHtml::value($purchase, 'currency.name'))
        ),
        array(
            'label' => 'Exchange Rate',
            'value' => CHtml::encode(CHtml::value($purchase, 'exchange_rate'))
        ),
        array(
            'label' => 'Catatan',
            'value' => $purchase->note,
        ),
    ),
));
?>

<?php if ($purchase->is_service == 0): ?> 

    <h2>Product</h2>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'htmlOptions' => array(
            'margin' => '0px'
        ),
        'columns' => array(
            'product_name: GRADE',
            'productCategory.name: Category',
            array(
                'header' => 'Tebal/Dmtr',
                'value' => 'number_format($data->height, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'value' => '$data->product_category_id == 2 ? "" :number_format($data->width, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Panjang',
                'value' => 'number_format($data->length, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
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
            array(
                'header' => 'Order Luar',
                'value' => '($data->workOrderCuttingDetail === null) ? "N/A" : $data->workOrderCuttingDetail->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>

    <br/>
<?php else: ?>
    <br/>
    <h2>Service</h2>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-detail-service-grid',
        'dataProvider' => $servicesDataProvider,
        'htmlOptions' => array(
            'margin' => '0px'
        ),
        'columns' => array(
            'name: GRADE',
            array(
                'header' => 'Length Initial',
                'value' => 'number_format($data->length_initial, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Length Final',
                'value' => 'number_format($data->length_final, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Width Initial',
                'value' => 'number_format($data->width_initial, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Width Final',
                'value' => 'number_format($data->width_final, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Height Initial',
                'value' => 'number_format($data->height_initial, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Height Final',
                'value' => 'number_format($data->height_final, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Quantity Final',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Weight',
                'value' => 'number_format($data->weight, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Harga',
//                'value' => 'number_format($data->amount, 2)',
                'value' => '$data->purchaseHeader->is_tax ? number_format($data->amount, 2) : number_format($data->amountTax, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Total',
//                'value' => 'number_format($data->totalService, 2)',
                'value' => '$data->purchaseHeader->is_tax ? number_format($data->totalService, 2) : number_format($data->totalServiceTax, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    ));
    ?>
 
<?php endif; ?>
<br />

<table>
    <tr style="background-color: skyblue">
        <td style="text-align: right; width: 80%; font-weight: bold">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php //if ($purchase->is_tax == 1): ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->subTotal)); ?>
            <?php //else : ?>
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->allDetailSubTotalTax)); ?>
            <?php //endif; ?>
        </td>
    </tr>

    <tr style="background-color: skyblue">
        <td style="text-align:right; width: 80%">
            Discount 
            <?php // echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $purchase->discount)); ?>
        </td>
        <td style="text-align: right">
            (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->discount)); ?>)
        </td>
    </tr>

    <tr style="background-color: skyblue">
        <td style="text-align:right; width: 80%">
            PPN <?php echo CHtml::encode(CHtml::value($purchase, 'tax_percentage')); ?>%
        </td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->calculatedTax)); ?>
        </td>
    </tr>

    <tr style="background-color: skyblue">
        <td style="text-align:right; width: 80%">
            PPH 0.3%
        </td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->calculatedTaxIncome)); ?>
        </td>
    </tr>

    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchase->grandTotal)); ?>
        </td>
    </tr>
</table>

<br />

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $purchase->id), array('target' => '_blank')); ?>
</div>
<br />
<?php echo CHtml::beginForm(); ?>
<div>
    <?php /* if ((int)$purchase->order_status === PurchaseHeader::OPEN): ?>
      <?php $orderStatusList = PurchaseHeader::getOrderStatusList(); ?>
      <?php unset($orderStatusList[PurchaseHeader::OPEN]); ?>
      <?php echo CHtml::dropDownList('PurchaseStatus', $purchase->order_status, $orderStatusList); ?>
      <?php echo CHtml::submitButton('Update', array('name' => 'Update')); ?>
      <?php endif; */ ?>
    <?php if ((int) $purchase->is_confirmed === PurchaseHeader::PENDING): ?>
        <?php echo CHtml::submitButton('Confirm Button', array('name' => 'Submit')); ?>
    <?php endif; ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php //echo 'Status Konfirmasi: ' . $purchase->confirmationStatus . ' and ' . $purchase->purchaseStatus;  ?>
