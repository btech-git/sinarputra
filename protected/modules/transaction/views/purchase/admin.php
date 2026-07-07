<h1>Kelola Data Pembelian Barang</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('purchase-grid',{data:{pageSize:$(this).val()}});",
        )
    ); ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-grid',
    'dataProvider' => $dataProvider,
    'filter' => $purchase,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Pembelian #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($purchase, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . PurchaseHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($purchase, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($purchase, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(PurchaseHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($purchase, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'header' => 'Supplier',
            'name' => 'supplier_id',
            'filter' => CHtml::listData(Supplier::model()->findAll(array('order' => 't.company ASC')), 'id', 'company'),
            'value' => '$data->supplier->company',
        ),
        array(
            'header' => 'Impor / Lokal',
            'name' => 'is_import',
            'filter' => false,
            'value' => '$data->importStatus',
        ),
        array(
            'header' => 'Barang / Jasa',
            'name' => 'is_service',
            'filter' => false,
            'value' => '$data->productServiceStatus',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
));
?>

<?php echo CHtml::endForm(); ?>