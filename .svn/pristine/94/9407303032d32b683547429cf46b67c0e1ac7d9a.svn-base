<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($saleInvoice->header); ?>
    <div class="container">
        <div class="span-12">
            <?php if (!$saleInvoice->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Sale Invoice #', false); ?>
                    <?php echo CHtml::encode($saleInvoice->header->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $saleInvoice->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'onSelect' => 'js:function(dateText, inst) {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('AjaxJsonDateChanged', array('id' => $saleInvoice->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#' . CHtml::activeId($saleInvoice->header, 'due_date') . '").val(data.due_date_formatted);
                                    $("#invoice_due_date").html(data.due_date_label);
                                },
                            });
                        }',
                    ),
                    'htmlOptions' => array('readonly' => true,),
                )); ?>
                <?php echo CHtml::error($saleInvoice->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Jatuh Tempo', false); ?>
                <?php echo CHtml::activeHiddenField($saleInvoice->header, 'due_date'); ?>
                <?php echo CHtml::openTag('span', array('id' => 'invoice_due_date')); ?>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $saleInvoice->header->due_date)); ?>
                <?php echo CHtml::closeTag('span'); ?>
                <?php echo CHtml::error($saleInvoice->header, 'due_date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Tukar TT', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $saleInvoice->header,
                    'attribute' => 'date_receipt',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($saleInvoice->header, 'date_receipt'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Jenis Invoice', ''); ?>
                <?php echo CHtml::activeDropDownList($saleInvoice->header, 'service_type', array(
                    ManualSaleInvoiceHeader::ST_PRODUCT => ManualSaleInvoiceHeader::ST_PRODUCT_LITERAL,
                    ManualSaleInvoiceHeader::ST_MILING => ManualSaleInvoiceHeader::ST_MILING_LITERAL,
                    ManualSaleInvoiceHeader::ST_GRINDING => ManualSaleInvoiceHeader::ST_GRINDING_LITERAL,
                    ManualSaleInvoiceHeader::ST_MILING_GRINDING => ManualSaleInvoiceHeader::ST_MILING_GRINDING_LITERAL,
                    ManualSaleInvoiceHeader::ST_CUTTING => ManualSaleInvoiceHeader::ST_CUTTING_LITERAL,
                    ManualSaleInvoiceHeader::ST_HARDENING => ManualSaleInvoiceHeader::ST_HARDENING_LITERAL,
                    ManualSaleInvoiceHeader::ST_SAMPLE => ManualSaleInvoiceHeader::ST_SAMPLE_LITERAL,
                ), array('empty' => '-- Pilih Jenis --')); ?>
                <?php echo CHtml::error($saleInvoice->header, 'service_type'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($saleInvoice->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($saleInvoice->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Faktur Pajak #', ''); ?>
                <?php echo CHtml::activeTextField($saleInvoice->header, 'tax_number', array('size' => 30, 'maxlength' => 60)); ?>
                <?php echo CHtml::error($saleInvoice->header, 'tax_number'); ?>
            </div>

            <?php if ($saleInvoice->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Customer', ''); ?>
                    <?php echo CHtml::activeTextField($saleInvoice->header, 'customer_id', array('readonly' => true, 'onclick' => '$("#customer-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::error($saleInvoice->header, 'customer_id'); ?>

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
                            $("#' . CHtml::activeId($saleInvoice->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                            $("#customer-dialog").dialog("close");
                            if ($.fn.yiiGridView.getSelection(id) == "") {
                                $("#' . CHtml::activeId($saleInvoice->header, 'due_date') . '").val("");
                                $("#invoice_due_date").html("");
                                $("#customer_id").html("");
                                $("#customer_name").html("");
                                $("#customer_company").html("");
                                $("#customer_address_main").html("");
                                $("#customer_due_days").html("");
                                $("#customer_salesman").html("");

                            } else {
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $saleInvoice->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#' . CHtml::activeId($saleInvoice->header, 'employee_id_salesman') . '").val(data.salesman);
                                        $("#' . CHtml::activeId($saleInvoice->header, 'due_date') . '").val(data.due_date_formatted);
                                        $("#invoice_due_date").html(data.due_date_label);
                                        $("#customer_id").html(data.customer_id);
                                        $("#customer_name").html(data.customer_name);
                                        $("#customer_company").html(data.customer_company);
                                        $("#customer_address_main").html(data.customer_address_main);
                                        $("#customer_due_days").html(data.customer_due_days);
                                        $("#customer_salesman").html(data.customer_salesman);
                                    },
                                });
                            }
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlResetDetail', array('id' => $saleInvoice->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); },
                            });
                            $.fn.yiiGridView.update("delivery-grid", {
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
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($saleInvoice->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address_main')); ?>
                <?php echo CHtml::encode(CHtml::value($saleInvoice->header, 'customer.tax_address_main')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('TOP', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_due_days')); ?>
                <?php echo CHtml::encode(CHtml::value($saleInvoice->header, 'customer.invoice_due_days')); ?>
                <?php echo CHtml::closeTag('span'); ?> hari
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Salesman', ''); ?>
                <?php echo CHtml::activeHiddenField($saleInvoice->header, 'employee_id_salesman'); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_salesman')); ?>
                <?php echo CHtml::encode(CHtml::value($saleInvoice->header, 'employeeIdSalesman.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
<!--            <div class="row">
                <?php /*echo CHtml::label('SPK #', ''); ?>
                <?php echo CHtml::encode($workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal SPK', ''); ?>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($workOrderCuttingHeader, 'date'))); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('PO Customer #', ''); ?>
                <?php echo CHtml::encode(CHtml::value($saleInvoice->header, 'purchase_order_number'));*/ ?>
            </div>-->
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Pengiriman', array('name' => 'Search', 'onclick' => '$("#delivery-detail-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#delivery-detail-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('DeliveryDetailId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('saleInvoice' => $saleInvoice)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'delivery-detail-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Pengiriman',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php echo CHtml::beginForm('', 'post'); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'delivery-grid',
        'dataProvider' => $deliveryDetailDataProvider,
        'filter' => $deliveryDetail,
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'header' => 'SPK #',
//                'filter' => '<div style="display: inline-block">' . CHtml::textField('DeliveryOrdinal', $deliveryOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
//                '<div style="display: inline-block"> &nbsp; /' . DeliveryHeader::CN_CONSTANT . '/ &nbsp; </div>' .
//                '<div style="display: inline-block">' . CHtml::dropDownList('DeliveryMonth', $deliveryMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
//                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
//                '<div style="display: inline-block">' . CHtml::textField('DeliveryYear', $deliveryYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
                'value' => '$data->deliveryHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            ),
            array(
                'header' => 'PO #',
                'filter' => CHtml::textField('CustomerOrderNumber', $customerOrderNumber),
                'value' => '$data->deliveryHeader->workOrderCuttingHeader->saleHeader->customer_order_number',
            ),
            array(
                'header' => 'SJ #',
                'filter' => '<div style="display: inline-block">' . CHtml::textField('DeliveryOrdinal', $deliveryOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; /' . DeliveryHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::dropDownList('DeliveryMonth', $deliveryMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::textField('DeliveryYear', $deliveryYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
                'value' => '$data->deliveryHeader->getCodeNumber(DeliveryHeader::CN_CONSTANT)',
            ),
            array(
                'header' => 'Tanggal',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->deliveryHeader->date)'
            ),
//            'deliveryHeader.workOrderCuttingHeader.saleHeader.customer.company',
            'grade_name',
//            'workOrderCuttingDetail.productCategory.name: Category',
            array(
                'header' => 'Tebal',
                'value' => 'number_format($data->height, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'value' => 'number_format($data->width, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Panjang',
                'value' => 'number_format($data->length, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Berat',
                'value' => 'number_format(CHtml::value($data, "weight"), 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Quantity',
                'value' => 'number_format(CHtml::value($data, "quantity"), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>

    <?php echo CHtml::ajaxSubmitButton('Add SJ', CController::createUrl('ajaxHtmlAddDeliveries', array('id' => $saleInvoice->header->id)), array(
        'type' => 'POST',
        'data' => 'js:$("form").serialize()',
        'success' => 'js:function(html) {
            $("#detail_div").html(html);
            $("#delivery-detail-dialog").dialog("close");
        }'
    )); ?>

    <?php echo CHtml::endForm(); ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>