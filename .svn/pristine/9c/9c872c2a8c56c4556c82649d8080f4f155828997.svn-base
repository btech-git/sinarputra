<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <div class="container">
        <div class="span-12">
            <?php echo CHtml::errorSummary($salePayment->header); ?>
            <div class="row">
                <?php echo CHtml::label('Tanggal Mutasi', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $salePayment->header,
                    'attribute' => 'date_created',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($salePayment->header, 'date_created'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Tanggal Pembayaran', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $salePayment->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($salePayment->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($salePayment->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($salePayment->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <?php if ($salePayment->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Customer', ''); ?>
                    <?php echo CHtml::activeTextField($salePayment->header, 'customer_id', array('readonly' => true, 'onclick' => '$("#customer-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::error($salePayment->header, 'customer_id'); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'customer-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Customer',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'customer-grid',
                        'dataProvider' => $customerDataProvider,
                        'filter' => $customer,
                        'selectionChanged' => 'js:function(id) {
                            $("#' . CHtml::activeId($salePayment->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#customer-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "")
                            {
                                $("#customer_id").html("");
                                $("#customer_name").html("");
                                $("#customer_company").html("");
                                $("#customer_address_main").html("");
                                $("#customer_due_days").html("");

                            }
                            else
                            {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $salePayment->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#customer_id").html(data.customer_id);
                                        $("#customer_name").html(data.customer_name);
                                        $("#customer_company").html(data.customer_company);
                                        $("#customer_address_main").html(data.customer_address_main);
                                        $("#customer_due_days").html(data.customer_due_days);

                                    },
                                });
                            }
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlResetDetail', array('id' => $salePayment->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                            $.fn.yiiGridView.update("sale-invoice-grid", {
                                data: $("form").serialize()
                            });
                        }',
                        'columns' => array(
                            'name',
                            'company',
                            'address_main',
                            'invoice_due_days',
                        ),
                    )); ?>
                    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($salePayment->header, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($salePayment->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address_main')); ?>
                <?php echo CHtml::encode(CHtml::value($salePayment->header, 'customer.address_main')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('TOP', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_due_days')); ?>
                <?php echo CHtml::encode(CHtml::value($salePayment->header, 'customer.invoice_due_days')); ?>
                <?php echo CHtml::closeTag('span'); ?> hari
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Sale Invoice', array('name' => 'Search', 'onclick' => '$("#sale-invoice-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#sale-invoice-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('SaleInvoiceId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('salePayment' => $salePayment)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'sale-invoice-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Sale Invoice',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'sale-invoice-grid',
        'dataProvider' => $saleInvoiceDataProvider,
        'filter' => $saleInvoice,
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'name' => 'cn_ordinal',
                'header' => 'Faktur Penjualan #',
                'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($saleInvoice, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; /' . ManualSaleInvoiceHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::activeDropDownList($saleInvoice, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::activeTextField($saleInvoice, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
                'value' => '$data->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)',
                'htmlOptions' => array('style' => 'width: 250px'),
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'date',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
            ),
            'customer.company',
            array(
                'header' => 'Total',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "grand_total"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Payment',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "total_payment"), 2)',
                'htmlOptions' => array('style' => 'text-align: right'),
            ),
            array(
                'header' => 'Retur',
                'filter' => false,
                'value' => 'number_format(CHtml::value($data, "total_return"), 2)',
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

    <?php echo CHtml::ajaxSubmitButton('Add Invoice', CController::createUrl('ajaxHtmlAddInvoices', array('id' => $salePayment->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#sale-invoice-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>