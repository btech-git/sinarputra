<h1>Quality Control Miling Admin</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('productionMilingList'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('quality-control-Miling-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quality-control-Miling-grid',
    'dataProvider' => $qualityControlDataProvider,
    'filter' => $qualityControlMiling,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'QC #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($qualityControlMiling, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . QualityControlMilingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($qualityControlMiling, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($qualityControlMiling, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(QualityControlMilingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($qualityControlMiling, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::value($data, "productionMilingHeader.productionPlanningMilingHeader.workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        array(
            'header' => 'Customer PO #',
            'filter' => CHtml::textField('CustomerPurchaseNumber', $customerPurchaseNumber),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer_order_number")',
        ),
        array(
            'header' => 'SO #',
            'filter' => false,
            'value' => '$data->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)',
        ),
        array(
            'header' => 'SPK #',
            'filter' => 
                '<div style="display: inline-block">' . CHtml::textField('WorkOrderOrdinal', $workOrderOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / ' . WorkOrderCuttingHeader::CN_CONSTANT . ' / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::dropDownList('WorkOrderMonth', $workOrderMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::textField('WorkOrderYear', $workOrderYear, array('maxLength' => 2, 'size' => 1)) . '</div>',
            'value' => '$data->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
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
