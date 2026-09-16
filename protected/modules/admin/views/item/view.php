<?php
$this->breadcrumbs = array(
    'Items' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List Item', 'url' => array('index')),
    array('label' => 'Create Item', 'url' => array('create')),
    array('label' => 'Update Item', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Item', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Item', 'url' => array('admin')),
);
?>

<h1>View Item #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'code',
        'name',
        'description',
        array(
            'label' => 'Kategori',
            'value' => CHtml::encode(CHtml::value($model, 'itemCategory.name')),
        ),
        array(
            'label'=>'Satuan',
            'value' => CHtml::encode(CHtml::value($model, 'unit.name')),
        ),
        'type',
        'tax_category',
        'tax_percentage',
        array(
            'label'=>'COA Beban',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdExpense.name')),
        ),
        array(
            'label'=>'COA Inventory',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdInventory.name')),
        ),
        array(
            'label'=>'COA COGS',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdCostOfGoodsSold.name')),
        ),
        array(
            'label'=>'COA Goods in Transit',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdGoodsInTransit.name')),
        ),
        array(
            'label'=>'COA Unbilled Goods',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdUnbilledGoods.name')),
        ),
        array(
            'label'=>'COA Penjualan',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdSaleTransaction.name')),
        ),
        array(
            'label'=>'COA Diskon Penjualan',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdSaleDiscount.name')),
        ),
        array(
            'label'=>'COA Retur Penjualan',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdSaleReturn.name')),
        ),
        array(
            'label'=>'COA Retur Pembelian',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdPurchaseReturn.name')),
        ),
        array(
            'label'=>'Status',
            'value' => $model->is_inactive ? ActiveRecord::INACTIVE_LITERAL : ActiveRecord::ACTIVE_LITERAL,
        ),
    ),
));
?>
