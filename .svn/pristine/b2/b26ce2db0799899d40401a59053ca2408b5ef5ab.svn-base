<h1>Kelola Data Pembelian Item</h1>
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
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-grid',
    'dataProvider' => $dataProvider,
    'filter' => $purchaseItem,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Pembelian Item #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($purchaseItem, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . PurchaseItemHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($purchaseItem, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($purchaseItem, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array(
            'header' => 'Supplier',
            'name' => 'supplier_id',
            'filter' => CHtml::listData(Supplier::model()->findAll(array('order' => 't.company ASC')), 'id', 'company'),
            'value' => '$data->supplier->company',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
));
?>
<?php echo CHtml::endForm(); ?>