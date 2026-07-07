<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$model->header->isNewRecord): ?>
            <div class="row">
                <?php echo CHtml::label('Tanda Terima #', false); ?>
                <?php echo CHtml::encode($model->header->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT)); ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($model->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($model->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($model->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <?php echo CHtml::activeTextField($model->header, 'supplier_id', array('readonly' => true, 'onclick' => '$("#supplier-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }')); ?>
                <?php echo CHtml::error($model->header, 'supplier_id'); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'supplier-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Supplier',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'supplier-grid',
                    'dataProvider' => $supplierDataProvider,
                    'filter' => $supplier,
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($model->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#supplier-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#supplier_name").html("");
                            $("#supplier_company").html("");
                            $("#supplier_address").html("");
                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonSupplier') . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#supplier_name").html(data.supplier_name);
                                    $("#supplier_company").html(data.supplier_company);
                                    $("#supplier_address").html(data.supplier_address);
                                },
                            });
                        }

                        //reset detail
                        $.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxHtmlResetDetail', array('id' => $model->header->id)) . '",
                            success: function(html) {
                                $("#detail_div").html(html);
                            },
                        });

                        //refresh purchase invoice
                        $.fn.yiiGridView.update("purchase-invoice-grid", {
                            data: $("form").serialize()
                        });
                    }',
                    'columns' => array(
                        'name',
                        'company',
                        'address_main',
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                <?php echo CHtml::encode(CHtml::value($model->header, 'supplier.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                <?php echo CHtml::encode(CHtml::value($model->header, 'supplier.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_address')); ?>
                <?php echo CHtml::encode(CHtml::value($model->header, 'supplier.address_main')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Add Purchase Invoice', array(
            'onclick' => '$("#purchase-invoice-dialog").dialog("open"); return false;',
            'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-invoice-dialog").dialog("open"); return false; }'
        )); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('model' => $model)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'purchase-invoice-dialog',
    // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Purchase Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    
    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'purchase-invoice-grid',
        'dataProvider' => $purchaseInvoiceDataProvider,
        'filter' => $purchaseInvoice,
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'name' => 'cn_ordinal',
                'header' => 'Purchase Invoice #',
                'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($purchaseInvoice, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; /' . PurchaseInvoice::CN_CONSTANT . '/ &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::activeDropDownList($purchaseInvoice, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::activeTextField($purchaseInvoice, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
                'value' => '$data->getCodeNumber(PurchaseInvoice::CN_CONSTANT)',
                'htmlOptions' => array('style' => 'width: 200px'),
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
            ),
            'supplier.company',
            'note'
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $model->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#purchase-invoice-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>    
</div>