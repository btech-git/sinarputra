<h1>List SPK</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'work-order-machining-grid',
    'dataProvider' => $workOrderCuttingHeaderDataProvider,
    'filter' => $workOrderCuttingHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'SPK #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($workOrderCuttingHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . WorkOrderCuttingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($workOrderCuttingHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderCuttingHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'PO Customer',
            'filter' => CHtml::textField('CustomerOrderNumber', $customerOrderNumber, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "saleHeader.customer_order_number")',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "saleHeader.customer.company")',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "workOrderId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
));
?>
