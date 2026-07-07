<h1>Kelola Data Order Penjualan</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        Tanggal Mulai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>

        Sampai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>
    </div>
    <div class="row">
        <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
    </div>

    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    <br/>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('sale-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-grid',
    'dataProvider' => $dataProvider,
    'filter' => $sale,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Sales Order #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($sale, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . SaleHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($sale, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($sale, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(SaleHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Grand Total',
            'value' => 'number_format($data->grandTotalTransaction, 2)',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'name' => 'customer',
            'header' => 'Company',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::encode(CHtml::value($data, "customer.company"))',
        ),
        array(
            'name' => 'customer_order_number',
            'header' => 'PO',
            'value' => '$data->customer_order_number',
        ),
        array(
            'name' => 'is_order_delayed',
            'header' => 'PO Pending',
            'filter' => array(
                SaleHeader::PROCESSED => SaleHeader::PROCESSED_LITERAL, 
                SaleHeader::PENDING => SaleHeader::PENDING_LITERAL
            ),
            'value' => '$data->customerOrderStatus',
        ),
        array(
            'name' => 'is_original_material',
            'header' => 'Lembaran / Batangan',
            'filter' => array(
                SaleHeader::NON_ORIGINAL_MATERIAL => SaleHeader::NON_ORIGINAL_MATERIAL_LITERAL, 
                SaleHeader::ORIGINAL_MATERIAL => SaleHeader::ORIGINAL_MATERIAL_LITERAL
            ),
            'value' => '$data->originalMaterialStatus',
        ),
        array(
            'name' => 'is_inactive',
            'header' => 'Status',
            'filter' => array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
            ),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
));
?>
