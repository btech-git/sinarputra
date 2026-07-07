<h1>List Penerimaan</h1>

<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
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

    <br/>
    
    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    
    <br/>
    
    <?php echo CHtml::endForm(); ?>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receive-material-grid',
    'dataProvider' => $receiveHeaderDataProvider,
    'filter' => $receiveHeader,
    'columns' => array(
        array(
            'header' => 'PO Material #',
            'value' => '$data->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'name' => 'cn_ordinal',
            'header' => 'Penerimaan #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($receiveHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ReceiveHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($receiveHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($receiveHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(ReceiveHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierCompanyMaterial', $supplierCompanyMaterial, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "supplier.company")',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "receiveHeaderId"=>$data->id, "receiveItemHeaderId"=>""))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receive-item-grid',
    'dataProvider' => $receiveItemHeaderDataProvider,
    'filter' => $receiveItemHeader,
    'columns' => array(
        array(
            'header' => 'PO Barang Penunjang #',
            'value' => '$data->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'name' => 'cn_ordinal',
            'header' => 'Penerimaan #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($receiveItemHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . ReceiveItemHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($receiveItemHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($receiveItemHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
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
            'header' => 'Supplier',
            'filter' => CHtml::textField('SupplierCompanyItem', $supplierCompanyItem, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "purchaseItemHeader.supplier.company")',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "receiveHeaderId"=>"", "receiveItemHeaderId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>
