<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$model->header->isNewRecord): ?>
            <div class="row">
                <?php echo CHtml::label('Pelunasan #', false); ?>
                <?php echo CHtml::encode($model->header->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT)); ?>
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
                <?php echo CHtml::label('Tanda Terima', ''); ?>
                <?php echo CHtml::activeTextField($model->header, 'purchase_receipt_header_id', array(
                    'readonly' => true,
                    'onclick' => '$("#purchase-receipt-header-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-receipt-header-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::error($model->header, 'purchase_receipt_header_id'); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'purchase-receipt-header-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Purchase Receipt',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'purchase-receipt-header-grid',
                    'dataProvider' => $purchaseReceiptHeaderDataProvider,
                    'filter' => $purchaseReceiptHeader,
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($model->header, 'purchase_receipt_header_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#purchase-receipt-header-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == ""){
                            $("#purchase_receipt_number_span").html("");
                            $("#purchase_receipt_date_span").html("");
                            $("#purchase_receipt_supplier_span").html("");
                            $("#purchase_receipt_total_span").html("");
                        }
                        else {
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxJsonPurchaseReceipt') . '",
                                data: $("form").serialize(),
                                dataType: "JSON",
                                success: function(data) {
                                    $("#purchase_receipt_number_span").html(data.purchaseReceiptNumber);
                                    $("#purchase_receipt_date_span").html(data.purchaseReceiptDate);
                                    $("#purchase_receipt_supplier_span").html(data.purchaseReceiptSupplier);
                                    $("#purchase_receipt_total_span").html(data.purchaseReceiptTotal);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        array(
                            'name' => 'cn_ordinal',
                            'header' => 'Tanda Terima #',
                            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($purchaseReceiptHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                            '<div style="display: inline-block"> &nbsp; /' . PurchaseReceiptHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                            '<div style="display: inline-block">' . CHtml::activeDropDownList($purchaseReceiptHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                            '<div style="display: inline-block">' . CHtml::activeTextField($purchaseReceiptHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
                            'value' => '$data->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT)',
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
                            'filter' => CHtml::textField('SupplierCompany', $supplierCompany, array('maxLength' => 60, 'size' => 10)),
                            'value' => '$data->supplier->company',
                        ),
                        array(
                            'header' => 'Total',
                            'filter' => false,
                            'value' => 'number_format(CHtml::value($data, "grand_total"), 2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'header' => 'Payment',
                            'filter' => false,
                            'value' => 'number_format(CHtml::value($data, "payment_total"), 2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'header' => 'Remaining',
                            'filter' => false,
                            'value' => 'number_format(CHtml::value($data, "remaining"), 2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <strong>Tanda Terima #</strong>
                <span id="purchase_receipt_number_span">
                    <?php if (isset($model->header->purchaseReceiptHeader)): ?>
                        <?php echo CHtml::encode($model->header->purchaseReceiptHeader->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT)); ?>
                    <?php endif; ?>
                </span>
            </div>

            <div class="row">
                <strong>Date</strong>
                <span id="purchase_receipt_date_span">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($model->header, 'purchaseReceiptHeader.date'))); ?>
                </span>
            </div>

            <div class="row">
                <strong>Supplier</strong>
                <span id="purchase_receipt_supplier_span">
                    <?php echo CHtml::encode(CHtml::value($model->header, 'purchaseReceiptHeader.supplier.company')); ?>
                </span>
            </div>

            <div class="row">
                <strong>Grand Total</strong>
                <span id="purchase_receipt_total_span">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model->header, 'purchaseReceiptHeader.grand_total'))); ?>
                </span>
            </div>
        </div>
    </div>

    <hr />

    <div class="row buttons">
        <?php echo CHtml::button('Cari Akun', array('name' => 'Search', 'onclick' => '$("#account-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#account-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('AccountId'); ?>
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


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'account-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Accounts',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'account-grid',
    'dataProvider' => $accountDataProvider,
    'filter' => $account,
    'selectionChanged' => 'js:function(id) {
			$("#AccountId").val($.fn.yiiGridView.getSelection(id));
			$("#account-dialog").dialog("close");
			$.ajax({
				type: "POST",
				url: "' . CController::createUrl('AjaxHtmlAddDetail', array('id' => $model->header->id)) . '",
				data: $("form").serialize(),
				success: function(html) { $("#detail_div").html(html); },
			});
		}',
    'columns' => array(
        'code: Kode',
        'name:nama Akun',
        array(
            'name' => 'account_category_id',
            'header' => 'Account Category',
            'filter' => CHtml::listData(AccountCategory::model()->findAll(), 'id', 'name'),
            'value' => '$data->accountCategory->name',
        ),
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>