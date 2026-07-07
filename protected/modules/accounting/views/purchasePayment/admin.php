<h1>Purchase Payment Admin</h1>
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
            'onchange' => "$.fn.yiiGridView.update('purchaseReturn-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchaseReturn-grid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'Purchase Payment #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . PurchasePaymentHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'header' => 'Tanda Terima #',
            'filter' => false,
            'value' => '$data->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierCompany', $supplierCompany, array('maxLength' => 60, 'size' => 10)),
            'value' => '$data->purchaseReceiptHeader->supplier->company',
        ),
        'note',
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
