<h1>Kelola Data Penerimaan Barang Penunjang</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
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
            'onchange' => "$.fn.yiiGridView.update('receive-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</center>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receive-grid',
    'dataProvider' => $dataProvider,
    'filter' => $receiveItem,
    'columns' => array(
        array(
            'name' => 'id',
            'header' => 'Penerimaan Item#',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($receiveItem, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ReceiveItemHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($receiveItem, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($receiveItem, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'header' => 'PO Item#',
            'name' => 'purchaseItemHeaderId',
            'type' => 'raw',
            'filter' => '<div style="display: inline-block">' . CHtml::textField('PurchaseItemCnOrdinal', $purchaseItemCnOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . PurchaseItemHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::dropDownList('PurchaseItemCnMonth', $purchaseItemCnMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::textField('PurchaseItemCnYear', $purchaseItemCnYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->purchaseItemHeader ?
					CHtml::link($data->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT), array("purchaseItem/view", "id" => $data->purchase_item_header_id), array("target" => "_blank")): ""',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierCompany', $supplierCompany, array('maxLength' => 60, 'size' => 10)),
            'value' => 'CHtml::value($data, "purchaseItemHeader.supplier.company")',
        ),
        array(
            'header' => 'Qty PO',
            'filter' => false,
            'value' => 'CHtml::value($data, "purchaseItemHeader.subTotalQuantity")',
        ),
        array(
            'header' => 'Qty Terima',
            'filter' => false,
            'value' => 'CHtml::value($data, "totalQuantity")',
        ),
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
));
?>
