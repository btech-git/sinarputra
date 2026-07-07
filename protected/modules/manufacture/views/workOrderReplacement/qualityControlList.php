<h1>QC List</h1>
    
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quality-control-cutting-grid',
    'dataProvider' => $qualityControlCuttingHeaderDataProvider,
    'filter' => $qualityControlCuttingHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'QC Cutting #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($qualityControlCuttingHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . QualityControlCuttingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($qualityControlCuttingHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($qualityControlCuttingHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($saleHeader, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompanyCutting', $customerCompanyCutting, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        'workOrderCuttingHeader.saleHeader.customer_order_number: Customer PO',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "qualityControlCuttingId"=>$data->id, "qualityControlMilingId"=>""))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quality-control-miling-grid',
    'dataProvider' => $qualityControlMilingHeaderDataProvider,
    'filter' => $qualityControlMilingHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'QC Miling #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($qualityControlMilingHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . QualityControlMilingHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($qualityControlMilingHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($qualityControlMilingHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(QualityControlMilingHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, //CHtml::activeTextField($saleHeader, 'date'),
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompanyMiling', $customerCompanyMiling, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        'workOrderCuttingHeader.saleHeader.customer_order_number: Customer PO',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "qualityControlCuttingId"=>"", "qualityControlMilingId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
));
?>
