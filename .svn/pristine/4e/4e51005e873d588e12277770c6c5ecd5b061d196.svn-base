<h1>List Produksi Cutting</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'production-grid',
    'dataProvider' => $productionCuttingHeaderDataProvider,
    'filter' => $productionCuttingHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Produksi #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($productionCuttingHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ProductionCuttingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($productionCuttingHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($productionCuttingHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '20', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "productionPlanningCuttingHeader.workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        array(
            'header' => 'Customer PO #',
            'filter' => CHtml::textField('CustomerPurchaseNumber', $customerPurchaseNumber),
            'value' => 'CHtml::value($data, "productionPlanningCuttingHeader.workOrderCuttingHeader.saleHeader.customer_order_number")',
        ),
        array(
            'header' => 'SPK #',
            'filter' => 
                '<div style="display: inline-block">' . CHtml::textField('WorkOrderOrdinal', $workOrderOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / ' . WorkOrderCuttingHeader::CN_CONSTANT . ' / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::dropDownList('WorkOrderMonth', $workOrderMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::textField('WorkOrderYear', $workOrderYear, array('maxLength' => 2, 'size' => 1)) . '</div>',
            'value' => '$data->productionPlanningCuttingHeader->workOrderCuttingHeader(array("scope" => "resetScope"))->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 280px'),
        ),
        array(
            'header' => 'miling?',
            'value' => '$data->productionPlanningCuttingHeader->workOrderCuttingHeader->getMilingStatus()',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "productionCuttingId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>