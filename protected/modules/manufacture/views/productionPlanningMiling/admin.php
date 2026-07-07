<h1>Production and Planning Control (PPC) Miling Admin</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('workOrderList'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update(production-planning-miling-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'production-planning-miling-grid',
    'dataProvider' => $modelDataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'PPC #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ProductionPlanningMilingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($model, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::value($data, "customer.company")',
        ),
        array(
            'header' => 'Customer PO #',
            'filter' => CHtml::textField('CustomerPurchaseNumber', $customerPurchaseNumber),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer_order_number")',
        ),
        array(
            'header' => 'SO #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::textField('SaleHeaderCnOrdinal', $saleHeaderCnOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; /' . SaleHeader::CN_CONSTANT . '/ &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::dropDownList('SaleHeaderCnMonth', $saleHeaderCnMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::textField('SaleHeaderCnYear', $saleHeaderCnYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 250px'),
        ),
        array(
            'header' => 'SPK #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; /' . ProductionPlanningMilingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '($data->work_order_cutting_header_id == null) ? "N/A" : $data->workOrderCuttingHeader(array("scope" => "resetScope"))->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'SPK Replacement #',
            'filter' => false,
//            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderReplacementHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / ' . WorkOrderReplacementHeader::CN_CONSTANT . ' / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeDropDownList($workOrderReplacementHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderReplacementHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '($data->work_order_cutting_header_id == null) ? $data->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT) : "N/A"',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'name' => 'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
<?php echo CHtml::endForm(); ?>
