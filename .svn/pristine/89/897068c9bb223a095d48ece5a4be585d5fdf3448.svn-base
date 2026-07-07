<h1>SPK Replacement Admin</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('qualityControlList')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('work-order-cutting-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'work-order-cutting-grid',
    'dataProvider' => $modelDataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'SPK Pengganti #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . WorkOrderCuttingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($model, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'SPK Potong #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'saleHeaderCnOrdinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; /' . SaleHeader::CN_CONSTANT . '/ &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'saleHeaderCnMonth', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'saleHeaderCnYear', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'SO #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'saleHeaderCnOrdinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; /' . SaleHeader::CN_CONSTANT . '/ &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'saleHeaderCnMonth', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'saleHeaderCnYear', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        array(
            'header' => 'Status',
            'name' => 'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}'
        ),
    ),
));
?>
<?php echo CHtml::endForm(); ?>