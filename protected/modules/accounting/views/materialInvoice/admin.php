<h1>Kelola Data Manual Invoice 2</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    
    <div class="row">
        Tanggal Mulai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'value' => $startDate,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>

        Sampai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'value' => $endDate,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>
    </div>
    
    <div class="row">
        <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
    </div>

    <br />
    
    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    
    <?php echo CHtml::endForm(); ?>
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
            'header' => 'Transaksi #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($materialInvoice, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . MaterialInvoiceHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($materialInvoice, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($materialInvoice, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 200px'),
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
            'name' => 'is_inactive',
            'header' => 'Status',
            'filter' => array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL),
            'value' => '$data->status',
        ),
//        array(
//            'header' => 'Salesman',
//            'name' => 'employee_id_salesman',
//            'filter' => CHtml::listData(Employee::model()->findAll(array('condition' => 'department_id = 2', 'order' => 'name ASC')), 'id', 'name'),
//            'value' => '$data->employeeIdSalesman->name',
//        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
)); ?>

<?php echo CHtml::submitButton('Export E-Faktur (XML)', array('name' => 'SaveXml', 'style' => 'float: left;', 'class' => 'grey-btn')); ?>
<?php echo CHtml::endForm(); ?>
