<h1>Purchase Invoice Admin</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('receiveList'), array('target' => '_blank')); ?>
</div>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
<center>
    <div class="row">
        Tanggal Mulai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'attribute' => $startDate,
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
            'attribute' => $endDate,
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
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-invoice-grid',
    'dataProvider' => $dataProvider,
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Purchase Invoice #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . PurchaseInvoice::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($model, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($model, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(PurchaseInvoice::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'header' => 'Penerimaan',
            'filter' => false,
            'value' => 'empty($data->receiveItemHeader) ? $data->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT) : $data->receiveItemHeader->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)'
        ),
        array(
            'header' => 'PO #',
            'filter' => false,
            'value' => 'empty($data->receiveItemHeader) ? "" : $data->receiveItemHeader->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)'
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierCompany', $supplierCompany, array('maxLength' => 60, 'size' => 10)),
            'value' => '$data->supplier->company',
        ),
        array(
            'header' => 'Total',
            'filter' => false,
            'value' => 'number_format($data->grand_total, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        'note',
        array(
            'name' => 'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
            'updateButtonUrl' => 'CHtml::normalizeUrl(array("update", "id"=>$data->id))',
        ),
    ),
)); ?>

<?php echo CHtml::endForm(); ?>