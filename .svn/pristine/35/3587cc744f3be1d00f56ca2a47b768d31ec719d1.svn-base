<script type="text/javascript">
    window.onload = function() {
        var is_service = <?php echo ($quotation->header->is_service); ?>;

        if (is_service == 0)
        {
            $("#detail_product_div").show(); 
            $("#btn_product").show(); 
            $("#btn_check_history").show(); 
            $("#detail_service_div").hide();
            $("#btn_service").hide(); 
            $("#btn_check_history_service").hide(); 
            $("#btn_check_stock").show(); 

        }
        else
        {
            $("#detail_product_div").hide(); 
            $("#btn_product").hide(); 
            $("#btn_check_history").hide();
            $("#detail_service_div").show();
            $("#btn_service").show(); 
            $("#btn_check_history_service").show(); 
            $("#btn_check_stock").hide(); 
        }
    }
</script>

<div class="form">
    <?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data',)); ?>
    <?php echo CHtml::errorSummary($quotation->header); ?>
    <div class="container">
        <div class="span-12">
            <?php if (!$quotation->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Penawaran #', false); ?>
                    <span id="quotation_header_code_number">
                        <?php echo CHtml::encode($quotation->header->getCodeNumber($quotation->header->cnConstant)); ?>
                    </span>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$quotation->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($quotation->header, 'date'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Status Quotation', false); ?>
                <?php echo CHtml::activeDropDownList($quotation->header, 'is_replacement', array(
                    QuotationHeader::CURRENT => QuotationHeader::CURRENT_LITERAL,
                    QuotationHeader::REPLACEMENT => QuotationHeader::REPLACEMENT_LITERAL)); ?>
                <?php echo CHtml::error($quotation->header, 'is_replacement'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Print Logo?', ''); ?>
                <?php echo CHtml::activeCheckBox($quotation->header, 'is_logo_printed'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tipe', false); ?>
                <?php echo CHtml::activeDropDownList($quotation->header, 'is_service', array(QuotationHeader::PRODUCT => QuotationHeader::PRODUCT_LITERAL, QuotationHeader::SERVICE => QuotationHeader::SERVICE_LITERAL), array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => "JSON",
                        'url' => CController::createUrl('ajaxJsonCodeNumber', array('id' => $quotation->header->id)),
                        'success' => 'function(data) {
                            $("#quotation_header_code_number").html(data.codeNumber);
                        } ',
                    )) .
                    CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => "JSON",
                        'url' => CController::createUrl('ajaxHtmlResetDetail', array('id' => $quotation->header->id)),
                        'data' => array('type' => 'js:this.value'),
                        'success' => 'function(html) { 
                            $("#detail_product_div").html(html); 
                            $("#detail_service_div").html(html);
                        }',
                    )) .
                    'if ($(this).val() == 0) {
                        $("#detail_product_div").show(); 
                        $("#btn_product").show(); 
                        $("#btn_check_history").show(); 
                        $("#detail_service_div").hide();
                        $("#btn_service").hide(); 
                        $("#btn_check_history_service").hide(); 
                        $("#btn_check_stock").show(); 
                    } else if ($(this).val() == 1) {
                        $("#detail_product_div").hide(); 
                        $("#btn_product").hide(); 
                        $("#btn_check_history").hide(); 
                        $("#detail_service_div").show();
                        $("#btn_service").show(); 
                        $("#btn_check_history_service").show(); 
                        $("#btn_check_stock").hide(); 
                    }',
                )); ?>
                <?php echo CHtml::error($quotation->header, 'is_service'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Valid', false); ?>
                <?php echo CHtml::activeDropDownList($quotation->header, 'valid_period', array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                )); ?> hari 
                <?php echo CHtml::error($quotation->header, 'valid_period'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Delivery', false); ?>
                <?php echo CHtml::activeDropDownList($quotation->header, 'delivery_period', array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                    10 => '10',
                    12 => '12',
                )); ?>
                hari PO diterima
                <?php echo CHtml::error($quotation->header, 'delivery_period'); ?>
            </div>
            
            <?php if ($quotation->header->isNewRecord): ?>
                <div>
                    <?php echo CHtml::label('Pembuat', ''); ?>
                    <?php echo CHtml::encode(CHtml::value($quotation->header, 'admin.name')); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($quotation->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($quotation->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::activeTextField($quotation->header, 'customer_id', array(
                    'readonly' => true,
                    'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::error($quotation->header, 'customer_id'); ?>

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
                        $("#' . CHtml::activeId($quotation->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#customer-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#customer_name").html("");
                            $("#customer_company").html("");
                            $("#customer_address").html("");
                            $("#customer_address_secondary").html("");
                            $("#customer_phone").html("");
                            $("#customer_quotationsman").html("");
                            $("#customer_credit_limit").html("");
                            $("#customer_due_days").html("");
                            $("#customer_employee").html("");
                            $("#customer_credit_limit").html("");
                            $("#customer_outstanding").html("");
                            $("#customer_remaining_limit").html("");
                            $("#' . CHtml::activeId($quotation->header, 'discount') . '").val(0.00);
                            $("#' . CHtml::activeId($quotation->header, 'employee_id') . '").val("");

                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $quotation->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#customer_name").html(data.customer_name);
                                    $("#customer_company").html(data.customer_company);
                                    $("#customer_address").html(data.customer_address);
                                    $("#customer_address_secondary").html(data.customer_address_secondary);
                                    $("#customer_phone").html(data.customer_phone);
                                    $("#customer_quotationsman").html(data.customer_quotationsman);
                                    $("#customer_credit_limit").html(data.customer_credit_limit);
                                    $("#customer_due_days").html(data.customer_due_days);
                                    $("#customer_employee").html(data.customer_employee_name);
                                    $("#customer_credit_limit").html(data.customer_credit_limit);
                                    $("#customer_outstanding").html(data.customer_outstanding);
                                    $("#customer_remaining_limit").html(data.customer_remaining_limit);
                                    $("#' . CHtml::activeId($quotation->header, 'discount') . '").val(data.customer_discount_default);
                                    $("#' . CHtml::activeId($quotation->header, 'employee_id') . '").val(data.employeeId);
                                },
                            });

                            $.fn.yiiGridView.update("detail-product-grid", {
                                data: {"QuotationHeader": {"customer_id": $.fn.yiiGridView.getSelection(id)}}
                            });

                            $.fn.yiiGridView.update("detail-service-grid", {
                                data: {"QuotationHeader": {"customer_id": $.fn.yiiGridView.getSelection(id)}}
                            });
                        }
                    }',
                    'columns' => array(
                        'code',
                        'name',
                        'company',
                        'phone',
                        'tax_registration_number',
                        'employee.name: Salesman',
                        'address_secondary: Alamat Kirim',
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($quotation->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($quotation->header, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Pusat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address')); ?>
                <?php echo nl2br(CHtml::encode(CHtml::value($quotation->header, 'customer.address_main'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Kirim', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address_secondary')); ?>
                <?php echo nl2br(CHtml::encode(CHtml::value($quotation->header, 'customer.address_secondary'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Telpon', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_phone')); ?>
                <?php echo nl2br(CHtml::encode(CHtml::value($quotation->header, 'customer.phone'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Terms of Payment', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_due_days')); ?>
                <?php echo CHtml::encode(CHtml::value($quotation->header, 'customer.invoice_due_days')); ?> 
                <?php echo CHtml::closeTag('span'); ?> 
                hari setelah tukar faktur			
            </div>

            <div>
                <?php echo CHtml::label('Salesman', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_employee')); ?>
                <?php echo CHtml::encode(CHtml::value($quotation->header, 'customer.employee.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Credit Limit', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_credit_limit')); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($quotation->header, 'customer.credit_limit'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Outstanding', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_outstanding')); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($quotation->header, 'customer.outstandingCredit'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Sisa Limit', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_remaining_limit')); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($quotation->header, 'customer.remainingCreditLimit'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('PPN 11%', false); ?>
                <?php echo CHtml::activeDropDownList($quotation->header, 'is_tax', array(
                    QuotationHeader::IS_NON_TAX => QuotationHeader::IS_NON_TAX_LITERAL,
                    QuotationHeader::IS_TAX => QuotationHeader::IS_TAX_LITERAL
                )); ?>
                <?php echo CHtml::error($quotation->header, 'is_tax'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Barang', array(
            'id' => 'btn_product',
            'onclick' => '$.ajax({
                type: "POST",
                data: $("form").serialize(),
                url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $quotation->header->id)) . '",
                success: function(html){
                    $("#detail_product_div").html(html);
                }
            })'
        )); ?>

        <?php echo CHtml::button('Tambah Service', array(
            'id' => 'btn_service',
            'onclick' => '$.ajax({
                type: "POST",
                data: $("form").serialize(),
                url: "' . CController::createUrl('ajaxHtmlAddService', array('id' => $quotation->header->id)) . '",
                success: function(html){
                    $("#detail_service_div").html(html);
                }
            })'
        )); ?>

        <?php echo CHtml::button('Cek Histori Harga', array(
            'id' => 'btn_check_history',
            'name' => 'Search',
            'onclick' => '$("#quotation-detail-dialog").dialog("open"); return false;',
            'onkeypress' => 'if (event.keyCode == 13) { $("#quotation-detail-dialog").dialog("open"); return false; }'
        )); ?>

        <?php echo CHtml::button('Cek Stock', array(
            'id' => 'btn_check_stock',
            'name' => 'Search',
            'onclick' => '$("#stock-dialog").dialog("open"); return false;',
            'onkeypress' => 'if (event.keyCode == 13) { $("#stock-dialog").dialog("open"); return false; }'
        )); ?>
    </div>

    <div id="detail_product_div">
        <?php $this->renderPartial('_detailProduct', array('quotation' => $quotation)); ?>
    </div>


    <div id="detail_service_div">
        <?php $this->renderPartial('_detailService', array('quotation' => $quotation)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'stock-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Stock',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
<?php $this->renderPartial('_stock_check', array(
    'receiveDetail' => $receiveDetail,
    'receiveDetailDataProvider' => $receiveDetailDataProvider,
    'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
    'workOrderCuttingDetailMaterialDataProvider' => $workOrderCuttingDetailMaterialDataProvider,
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'quotation-detail-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'History Harga',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
<?php $this->renderPartial('_pricing_history', array(
    'quotationDetailProduct' => $quotationDetailProduct,
    'quotationDetailProductDataProvider' => $quotationDetailProductDataProvider,
    'quotationDetailService' => $quotationDetailService,
    'quotationDetailServiceDataProvider' => $quotationDetailServiceDataProvider,
)); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>