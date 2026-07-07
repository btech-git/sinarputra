<h1>List PPC Miling</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'production-planning-miling-grid',
    'dataProvider' => $productionPlanningMilingHeaderDataProvider,
    'filter' => $productionPlanningMilingHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'PPC #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($productionPlanningMilingHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ProductionPlanningMilingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($productionPlanningMilingHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($productionPlanningMilingHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)',
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
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer.company")',
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
            'htmlOptions' => array('style' => 'width: 250px'),
        ),
        array(
            'header' => 'SPK #',
            'filter' => 
            '<div style="display: inline-block">' . CHtml::textField('WorkOrderOrdinal', $workOrderOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . WorkOrderCuttingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::dropDownList('WorkOrderMonth', $workOrderMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::textField('WorkOrderYear', $workOrderYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '($data->work_order_cutting_header_id == null) ? "N/A" : $data->workOrderCuttingHeader(array("scope" => "resetScope"))->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "productionPlanningId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>