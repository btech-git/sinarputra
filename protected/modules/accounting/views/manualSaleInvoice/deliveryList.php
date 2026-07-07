<h1>List Surat Jalan</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'delivery-grid',
    'dataProvider' => $deliveryHeaderDataProvider,
    'filter' => $deliveryHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'SJ #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($deliveryHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . DeliveryHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($deliveryHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($deliveryHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(DeliveryHeader::CN_CONSTANT)',
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
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer_order_number")',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "deliveryHeaderId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>