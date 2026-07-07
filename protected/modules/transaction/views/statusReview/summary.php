<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#CustomerCompany").val("' . $customerCompany . '");
');
?>
<style>
    h3 {
        text-align: center;
    }

    .tabButton {
        display: inline-block;
        cursor: pointer;
        padding: 10px;
    }

    .active {
        background-color: #E5E5E5;
    }
</style>

<h1>Transactions Status Review</h1>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', 500);
    $pageSizeDropDown = CHtml::textField(
        'pageSize', $pageSize, array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('sale-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="row">
        Customer
        <?php echo CHtml::textField('CustomerCompany', $customerCompany); ?> || 
        
        Status
        <?php echo CHtml::activeDropDownList($saleHeader, 'is_inactive', array(
            ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
            ActiveRecord::INACTIVE => 'Cancelled',
        ), array('empty' => '-- Semua --')); ?> ||
        
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
    
    <br />
    
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
    
    <br/>
    
    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    
    <?php echo CHtml::endForm(); ?>
    
    <br/>
    
    <div class="row button">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('Save To Excel', array('name' => 'SaveToExcel')); ?>
        <?php echo CHtml::submitButton('Export Outstanding', array('name' => 'ExportOutstanding')); ?>
        <?php echo CHtml::endForm(); ?>
    </div>
    
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-header-grid',
    'dataProvider' => $saleHeaderDataProvider,
    'filter' => $saleHeader,
    'columns' => array(
        array(
            'header' => 'Tanggal Order',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'name' => 'customer',
            'header' => 'Company',
            'filter' => false,
            'value' => 'CHtml::encode(CHtml::value($data, "customer.company"))',
        ),
        array(
            'name' => 'cn_ordinal',
            'header' => 'Order #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($saleHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . SaleHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($saleHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($saleHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(SaleHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'SPK #',
            'filter' => false,
            'type' => 'raw',
            'value' => 'empty($data->workOrderCuttingHeaders) ? "N/A" : CHtml::link($data->getWorkOrderCuttingHeaderNumber(), array("/manufacture/workOrderCutting/view", "id" => $data->workOrderCuttingHeaders[0]->id), array("target" => "_blank"))',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'header' => 'Invoice #',
            'filter' => false,
            'value' => '$data->getSaleInvoiceHeaderNumber()',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
    ),
)); ?>
