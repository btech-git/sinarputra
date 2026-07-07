<h1>Production Cutting Admin</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('productionPlanningList'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('work-order-machining-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'production-cutting-grid',
    'dataProvider' => $modelDataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Production Cutting #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ProductionCuttingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_year', array('maxLength' => 2, 'size' => 1)) . '</div>',
            'value' => '$data->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 270px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($model, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer PO #',
            'filter' => CHtml::textField('CustomerPurchaseNumber', $customerPurchaseNumber),
            'value' => 'CHtml::value($data, "productionPlanningCuttingHeader.workOrderCuttingHeader.saleHeader.customer_order_number")',
        ),
        array(
            'header' => 'SO #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::textField('SaleHeaderCnOrdinal', $saleHeaderCnOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; /' . SaleHeader::CN_CONSTANT . '/ &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::dropDownList('SaleHeaderCnMonth', $saleHeaderCnMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::textField('SaleHeaderCnYear', $saleHeaderCnYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->productionPlanningCuttingHeader->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array(
            'header' => 'SPK #',
            'filter' => 
            '<div style="display: inline-block">' . CHtml::textField('WorkOrderOrdinal', $workOrderOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / ' . WorkOrderCuttingHeader::CN_CONSTANT . ' / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::dropDownList('WorkOrderMonth', $workOrderMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::textField('WorkOrderYear', $workOrderYear, array('maxLength' => 2, 'size' => 1)) . '</div>',
            'value' => 'empty($data->productionPlanningCuttingHeader->workOrderCuttingHeader) ? " N/A" : $data->productionPlanningCuttingHeader->workOrderCuttingHeader(array("scope" => "resetScope"))->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 270px'),
        ),
        array(
            'header' => 'SPK Replacement #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderCuttingHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / ' . WorkOrderCuttingHeader::CN_CONSTANT . ' / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeDropDownList($workOrderCuttingHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderCuttingHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => 'empty($data->productionPlanningCuttingHeader->workOrderCuttingHeader) ? $data->productionPlanningCuttingHeader->workOrderReplacementHeader(array("scope" => "resetScope"))->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT) : "N/A" ',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::value($data, "productionPlanningCuttingHeader.customer.company")',
        ),
        'note',
        array(
            'name' => 'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
<?php echo CHtml::endForm(); ?>
