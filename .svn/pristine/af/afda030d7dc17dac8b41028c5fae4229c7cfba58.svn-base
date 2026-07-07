<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($purchaseReturn->header, 'error'); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$purchaseReturn->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Retur #', false); ?>
                    <?php echo CHtml::encode($purchaseReturn->header->getCodeNumber(PurchaseReturnHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$delivery->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchaseReturn->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($purchaseReturn->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($purchaseReturn->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Receive #', ''); ?>
                <?php if ($purchaseReturn->header->isNewRecord): ?>

                    <?php echo CHtml::activeTextField($purchaseReturn->header, 'receive_header_id', array('readonly' => true, 'onclick' => '$("#receive-header-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#receive-header-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'receive_header_code_number')); ?>
                    <?php echo CHtml::encode(($receiveHeader === null) ? '' : $receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                    <?php echo CHtml::error($purchaseReturn->header, 'receive_header_id'); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'receive-header-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Penerimaan Barang',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>
                
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'purchase-header-grid',
                        'dataProvider' => $receiveHeaderDataProvider,
                        'filter' => $receiveHeader,
                        'selectionChanged' => 'js:function(id) {
                            $("#' . CHtml::activeId($purchaseReturn->header, 'receive_header_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#receive-header-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                $("#receive_header_code_number").html("");
                                $("#receive_header_date").html("");
                                $("#supplier_company").html("");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('AjaxJsonReceive', array('id' => $purchaseReturn->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#receive_header_code_number").html(data.receive_header_code_number);
                                        $("#receive_header_date").html(data.receive_header_date);
                                        $("#supplier_company").html(data.supplier_company);
                                    },
                                });
                            }
                            
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlShowReceive', array('id' => $purchaseReturn->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                        }',
                        'columns' => array(
                            array(
                                'name' => 'cn_ordinal',
                                'header' => 'Order #',
                                'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($receiveHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                                '<div style="display: inline-block"> &nbsp; /' . ReceiveHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                                '<div style="display: inline-block">' . CHtml::activeDropDownList($receiveHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                                '<div style="display: inline-block">' . CHtml::activeTextField($receiveHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
                                'value' => '$data->getCodeNumber(ReceiveHeader::CN_CONSTANT)',
                                'htmlOptions' => array('style' => 'width: 200px'),
                            ),
                            array(
                                'header' => 'Tanggal',
                                'name' => 'date',
                                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                            ),
                            array(
                                'header' => 'Supplier',
                                'filter' => CHtml::textField('SupplierCompany', $supplierCompany, array('maxLength' => 60, 'size' => 10)),
                                'value' => 'CHtml::value($data, "purchaseHeader.supplier.company")',
                            ),
                        ),
                    )); ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                <?php else: ?>
                    <?php echo CHtml::encode($purchaseReturn->header->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?>
                    <?php echo CHtml::activeHiddenField($purchaseReturn->header, 'receive_header_id', array('value' => $purchaseReturn->header->receive_header_id)); ?>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Beli', ''); ?>
                <span id="receive_header_date">
                    <?php echo CHtml::encode(CHtml::value($purchaseReturn->header, 'receiveHeader.date')); ?>
                </span>
            </div>

            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <span id="supplier_company">
                    <?php echo CHtml::encode(CHtml::value($purchaseReturn->header, 'receiveHeader.purchaseHeader.supplier.company')); ?>
                </span>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::error($purchaseReturn->header, 'error'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('purchaseReturn' => $purchaseReturn)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->