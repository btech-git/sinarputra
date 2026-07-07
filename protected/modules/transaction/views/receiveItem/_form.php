
<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($receiveItem->header); ?>
    <div class="container">
        <div class="span-12">
            <?php if (!$receiveItem->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Penerimaan Item #', false); ?>
                    <?php echo CHtml::encode($receiveItem->header->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$receiveItem->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($receiveItem->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($receiveItem->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($receiveItem->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row" >
                <?php echo CHtml::label('Purchase Item#', ''); ?>
                <?php if ($receiveItem->header->isNewRecord): ?>
                    <?php echo CHtml::activeTextField($receiveItem->header, 'purchase_item_header_id', array('readonly' => true, 'onclick' => '$("#purchase-header-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-header-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'purchase_item_header_code_number')); ?>
                    <?php echo CHtml::encode(($purchaseItemHeader === null) ? '' : $purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                    <?php echo CHtml::error($receiveItem->header, 'purchase_header_id'); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'purchase-header-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Purchase Order',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'purchase-header-grid',
                        'dataProvider' => $purchaseItemHeaderDataProvider,
                        'filter' => $purchaseItemHeader,
                        'selectionChanged' => 'js:function(id) {
                            $("#' . CHtml::activeId($receiveItem->header, 'purchase_item_header_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#purchase-header-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                $("#purchase_item_header_code_number").html("");
                                $("#purchase_item_header_date").html("");
                                $("#supplier_company").html("");
                            } else {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('AjaxJsonPurchaseItem', array('id' => $receiveItem->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#purchase_item_header_code_number").html(data.purchase_item_header_code_number);
                                        $("#purchase_item_header_date").html(data.purchase_item_header_date);
                                        $("#supplier_company").html(data.supplier_company);
                                        reload(data.purchase_item_header_code_number);
                                    },
                                });
                            }
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlShowPurchaseItem', array('id' => $receiveItem->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                        }',
                        'columns' => array(
                            array(
                                'name' => 'cn_ordinal',
                                'header' => 'Order Item #',
                                'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($purchaseItemHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                                '<div style="display: inline-block"> &nbsp; /' . PurchaseItemHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                                '<div style="display: inline-block">' . CHtml::activeDropDownList($purchaseItemHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                                '<div style="display: inline-block">' . CHtml::activeTextField($purchaseItemHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
                                'value' => '$data->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)',
                                'htmlOptions' => array('style' => 'width: 200px'),
                            ),
                            array(
                                'header' => 'Tanggal',
                                'name' => 'date',
                                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
                            ),
                            array(
                                'name' => 'supplier_id',
                                'filter' => CHtml::textField('SupplierCompany', $supplierCompany, array('maxLength' => 60, 'size' => 10)),
                                'value' => 'CHtml::value($data, "supplier.company")',
                            ),
                        ),
                    )); ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                <?php else : ?>
                    <?php if ($receiveItem->header->purchaseItemHeader) : ?>
                        <?php echo CHtml::encode($receiveItem->header->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)); ?>
                        <?php echo CHtml::activeHiddenField($receiveItem->header, 'purchase_item_header_id', array('value' => $receiveItem->header->purchase_item_header_id)); ?>
                    <?php endif; ?>	
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Beli', ''); ?>
                <span id="purchase_item_header_date">
                    <?php echo CHtml::encode(CHtml::value($receiveItem->header, 'purchaseItemHeader.date')); ?>
                </span>
            </div>

            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <span id="supplier_company">
                    <?php echo CHtml::encode(CHtml::value($receiveItem->header, 'purchaseItemHeader.supplier.company')); ?>
                </span>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::error($receiveItem->header, 'error'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('receiveItem' => $receiveItem)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

