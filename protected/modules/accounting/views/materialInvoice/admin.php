<h1>Kelola Data Manual Invoice 2</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('purchase-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php echo CHtml::beginForm(array(''), 'get'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'material-invoice-grid',
    'dataProvider' => $dataProvider,
    'filter' => $materialInvoice,
    'columns' => array(
        array(
            'id' => 'selectedIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array(
            'name' => 'cn_ordinal',
            'header' => 'Pembelian Item #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($materialInvoice, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . MaterialInvoiceHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($materialInvoice, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($materialInvoice, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array(
            'header' => 'Jatuh Tempo',
            'name' => 'due_date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->due_date)'
        ),
        array(
            'header' => 'Customer',
            'name' => 'customer_id',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('maxLength' => 60, 'size' => 10)),
            'value' => '$data->customer->company',
        ),
        array(
            'header' => 'TT #',
            'filter' => false,
            'value' => 'empty($data->materialReceiptDetails) ? "" : $data->materialReceiptDetails[0]->materialReceiptHeader->getCodeNumber(MaterialReceiptHeader::CN_CONSTANT)',
        ),
        array(
            'header' => 'Tanggal TT',
            'name' => 'date',
            'filter' => false, 
            'value' => 'empty($data->materialReceiptDetails) ? "" : Yii::app()->dateFormatter->format("d MMM yyyy", $data->materialReceiptDetails[0]->materialReceiptHeader->date)',
            'htmlOptions' => array('style' => 'width: 100px'),
        ),
        array(
            'header' => 'Total',
            'filter' => false,
            'value' => 'number_format($data->grand_total, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'PO Customer',
            'name' => 'reference_number',
            'value' => '$data->reference_number',
        ),
        array(
            'header' => 'F. Pajak',
            'name' => 'tax_number',
            'value' => '$data->tax_number',
        ),
        array(
            'header' => 'Salesman',
            'name' => 'employee_id_salesman',
            'filter' => CHtml::listData(Employee::model()->findAll(array('condition' => 'department_id = 2', 'order' => 'name ASC')), 'id', 'name'),
            'value' => '$data->employeeIdSalesman->name',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
)); ?>
<?php echo CHtml::submitButton('Export E-Faktur (XML)', array('name' => 'SaveXml', 'style' => 'float: left;', 'class' => 'grey-btn')); ?>
<?php echo CHtml::endForm(); ?>
