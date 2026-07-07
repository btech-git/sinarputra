<h1>List SPK</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        Tanggal Mulai
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>

        Sampai
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
    </div>
    <div class="row">
        <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
    </div>

    <br/>
    
    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    
    <br/>
    
    <?php echo CHtml::endForm(); ?>
</center>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'work-order-machining-grid',
    'dataProvider' => $workOrderReplacementHeaderDataProvider,
    'filter' => $workOrderReplacementHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'SPK #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($workOrderReplacementHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . WorkOrderReplacementHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($workOrderReplacementHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderReplacementHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "workOrderCuttingHeader.saleHeader.customer.company")',
        ),
        'note',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "workOrderReplacementId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
));
?>
