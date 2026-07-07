<h1>Kelola Data Penawaran</h1>
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
            'onchange' => "$.fn.yiiGridView.update('quotation-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>

    <?php echo CHtml::endForm(); ?>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quotation-grid',
    'dataProvider' => $dataProvider,
    'filter' => $quotation,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Penawaran #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($quotation, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /QOTP/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($quotation, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($quotation, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber($data->getCnConstant())',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::value($data, "customer.company")',
        ),
		array(
			'header' => 'Salesman',
            'name' => 'employee_id_sales',
            'filter' => CHtml::listData(Employee::model()->findAll(array('condition' => 'department_id = 2', 'order' => 'name ASC')), 'id', 'name'),
            'value'=>'empty($data->employeeIdSales) ? "N/A" : $data->employeeIdSales->name',
        ),
		array(
			'header' => 'Pembuat',
            'value'=>'$data->admin->name',
        ),
        array(
            'header' => 'Confirmation',
            'name' => 'is_confirmed',
            'filter' => array(
                QuotationHeader::PENDING => QuotationHeader::PENDING_LITERAL, 
                QuotationHeader::CONFIRMED => QuotationHeader::CONFIRMED_LITERAL
            ),
            'value' => '$data->confirmationStatus',
        ),
        array(
            'header' => 'Cancel',
            'name' => 'cancellation_remark',
            'filter' => false,
            /*array(
                '' => '--all--',
                QuotationHeader::CANCEL_GRADE => QuotationHeader::CANCEL_GRADE_LITERAL, 
                QuotationHeader::CANCEL_STOCK => QuotationHeader::CANCEL_STOCK_LITERAL,
                QuotationHeader::CANCEL_PRICE => QuotationHeader::CANCEL_PRICE_LITERAL, 
                QuotationHeader::CANCEL_DELIVERY => QuotationHeader::CANCEL_DELIVERY_LITERAL,
                QuotationHeader::CANCEL_SUPPORT => QuotationHeader::CANCEL_SUPPORT_LITERAL, 
            ),*/
            'value' => '$data->cancellationRemarkLiteral',
        ),
        array(
            'name' => 'is_inactive',
            'header' => 'Status',
            'filter' => array(ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
)); ?>
