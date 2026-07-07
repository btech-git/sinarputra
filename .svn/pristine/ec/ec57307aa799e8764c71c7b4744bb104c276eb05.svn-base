<script type="text/javascript">	
    window.onload = function() {
        var isService = document.getElementById("SaleHeader_is_service").value;
        if (isService == 0) {
            $("#quotation_product_button").show();
            $("#quotation_service_button").hide();
        }
        else {
            $("#quotation_product_button").hide();
            $("#quotation_service_button").show();
        }
    }
</script>
<div class="form">
    <?php echo CHtml::beginForm('', 'post', array('enctype' => 'multipart/form-data',)); ?>
    <?php echo CHtml::errorSummary($sale->header); ?>
    
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Status SO', false); ?>
                <?php echo CHtml::activeDropDownList($sale->header, 'is_replacement', array(
                    SaleHeader::CURRENT => SaleHeader::CURRENT_LITERAL,
                    SaleHeader::REPLACEMENT => SaleHeader::REPLACEMENT_LITERAL)); ?>
                <?php echo CHtml::error($sale->header, 'is_replacement'); ?>
            </div>
            
            <?php if (!$sale->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Penjualan #', false); ?>
                    <?php echo CHtml::encode($sale->header->getCodeNumber(SaleHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$sale->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd'
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($sale->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::activeTextField($sale->header, 'customer_id', array(
                    'readonly' => true,
                    'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::error($sale->header, 'customer_id'); ?>

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
                        $("#' . CHtml::activeId($sale->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#customer-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "")
                        {
                            $("#customer_name").html("");
                            $("#customer_company").html("");
                            $("#customer_address").html("");
                            $("#customer_address_secondary").html("");
                            $("#customer_salesman").html("");
                            $("#customer_credit_limit").html("");
                            $("#customer_outstanding").html("");
                            $("#customer_remaining_limit").html("");
                        }
                        else
                        {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer') . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#customer_name").html(data.customer_name);
                                    $("#customer_company").html(data.customer_company);
                                    $("#customer_address").html(data.customer_address);
                                    $("#customer_address_secondary").html(data.customer_address_secondary);
                                    $("#customer_salesman").html(data.customer_salesman);
                                    $("#customer_credit_limit").html(data.customer_credit_limit);
                                    $("#customer_outstanding").html(data.customer_outstanding);
                                    $("#customer_remaining_limit").html(data.customer_remaining_limit);
                                },
                            });
                        };

                        $.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxHtmlResetDetail', array('id' => $sale->header->id)) . '",
                            data: $("form").serialize(),
                            success: function(html) { 
                                $("#detail_div").html(html); 
                            },
                        });

                        //update quotation detail product
                        $.fn.yiiGridView.update("quotation-detail-product-grid", {
                            data: $("form").serialize()
                        });

                        //update quotation detail service
                        $.fn.yiiGridView.update("quotation-detail-service-grid", {
                            data: $("form").serialize()
                        });
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
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($sale->header, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($sale->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Pusat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address')); ?>
                <?php echo nl2br(CHtml::encode(CHtml::value($sale->header, 'customer.address_main'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Kirim', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address_secondary')); ?>
                <?php echo nl2br(CHtml::encode(CHtml::value($sale->header, 'customer.address_secondary'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Salesman', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_salesman')); ?>
                <?php echo CHtml::encode(CHtml::value($sale->header, 'customer.employee.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Credit Limit', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_credit_limit')); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($sale->header, 'customer.credit_limit'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Outstanding', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_outstanding')); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($sale->header, 'customer.outstandingCredit'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Sisa Limit', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_remaining_limit')); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($sale->header, 'customer.remainingCreditLimit'))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
        </div>

        <div class="span-12 last">
            
            <div class="row">
                <?php echo CHtml::label('PO Pending ?', ''); ?>
                <?php echo CHtml::activeCheckBox($sale->header, 'is_order_delayed'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Lembaran / Batangan ?', ''); ?>
                <?php echo CHtml::activeCheckBox($sale->header, 'is_original_material'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Barang/Jasa', false); ?>
                <?php echo CHtml::activeDropDownList($sale->header, 'is_service', array(
                    SaleHeader::PRODUCT => SaleHeader::PRODUCT_LITERAL,
                    SaleHeader::SERVICE => SaleHeader::SERVICE_LITERAL), array('onchange' =>
                    'if ($(this).val() == 0) {
                        $("#quotation_product_button").show();
                        $("#quotation_service_button").hide();
                    }
                    else if ($(this).val() == 1) {
                        $("#quotation_product_button").hide();
                        $("#quotation_service_button").show();
                    }',
                )); ?>
                <?php echo CHtml::error($sale->header, 'is_service'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Customer PO', ''); ?>
                <?php echo CHtml::activeTextField($sale->header, 'customer_order_number'); ?>
                <?php echo CHtml::error($sale->header, 'customer_order_number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal PO', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$sale->header,
                    'attribute'=>'customer_order_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd'
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($sale->header, 'customer_order_date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Kirim', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$sale->header,
                    'attribute'=>'estimate_delivery_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd'
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($sale->header, 'estimate_delivery_date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($sale->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($sale->header, 'note'); ?>
            </div>
        </div>

        <hr />

        <div id="quotation_product_button">
            <?php echo CHtml::hiddenField('QuotationDetailProductId'); ?>
            <?php echo CHtml::button('Cari Produk Penawaran', array(
                'onclick' => '$("#quotation-detail-product-dialog").dialog("open")',
                'onkeypress' => 'if (event.keyCode == 13) { $("#quotation-detail-product-dialog").dialog("open"); return false; }'
            )); ?>
        </div>
        
        <div id="quotation_service_button">
            <?php echo CHtml::hiddenField('QuotationDetailServiceId'); ?>
            <?php echo CHtml::button('Cari Jasa Penawaran', array(
                'onclick' => '$("#quotation-detail-service-dialog").dialog("open")',
                'onkeypress' => 'if (event.keyCode == 13) { $("#quotation-detail-service-dialog").dialog("open"); return false; }'
            )); ?>
        </div>
        
        <div id="detail_div">
            <?php $this->renderPartial('_detail', array('sale' => $sale)); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
        </div>
            
        <?php echo IdempotentManager::generate(); ?>

        <?php echo CHtml::endForm(); ?>
    </div>
</div><!-- form -->


<?php
//quotation detail product dialog
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'quotation-detail-product-dialog',
        'options' => array(
            'title' => 'Data Produk Penjualan',
            'width' => 'auto',
            'autoOpen' => FALSE,
            'modal' => true
        )
    ));
?>
<?php echo CHtml::beginForm('', 'post'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'quotation-detail-product-grid',
        'dataProvider' => $quotationDetailProductDataProvider,
        'filter' => $quotationDetailProduct,
        'columns' => array(
            array(
                'id' => 'selectedIds',
                'class' => 'CCheckBoxColumn',
                'selectableRows' => '50',
            ),
            array(
                'header' => 'Penawaran #',
                'filter' => '<div style="display: inline-block">' . CHtml::textField('CnOrdinal', $cnOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::dropDownList('CnMonth', $cnMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::textField('CnYear', $cnYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
                'value' => 'CHtml::encode($data->quotationHeader->getCodeNumber(CHtml::value($data, "quotationHeader.cnConstant")))',
                'htmlOptions' => array('style' => 'width: 300px'),
            ),
            array(
                'header' => 'Tanggal',
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->quotationHeader->date)'
            ),
            array(
                'header' => 'Customer',
                'value' => 'CHtml::encode(CHtml::value($data, "quotationHeader.customer.company"))'
            ),
            'job_number: Job Number',
            'product_name_quote: GRADE',
            array(
                'header' => 'Tebal',
                'filter' => CHtml::activeTextField($quotationDetailProduct, 'height_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "height_quote"))'
            ),
            array(
                'header' => 'Lebar',
                'filter' => CHtml::activeTextField($quotationDetailProduct, 'width_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "width_quote"))'
            ),
            array(
                'header' => 'Panjang',
                'filter' => CHtml::activeTextField($quotationDetailProduct, 'length_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "length_quote"))'
            ),
            'weight: Berat',
        ),
//        'selectionChanged' => 'function(id) {
//            $("#QuotationDetailProductId").val($.fn.yiiGridView.getSelection(id));
//            $("#quotation-detail-product-dialog").dialog("close");
//            $.ajax({
//                type: "POST",
//                url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $sale->header->id)) . '",
//                data: $("form").serialize(),
//                success: function(html) {
//                    $("#detail_product_div").html(html);
//                }
//            })
//        }'
    ));
?>

<?php echo CHtml::ajaxSubmitButton('Add Product', CController::createUrl('ajaxHtmlAddProducts', array('id' => $sale->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#detail_div").html(html);
        $("#quotation-detail-product-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'quotation-detail-service-dialog',
        'options' => array(
            'title' => 'Penawaran Jasa',
            'width' => 'auto',
            'autoOpen' => FALSE,
            'modal' => true
        )
    ));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quotation-detail-service-grid',
    'dataProvider' => $quotationDetailServiceDataProvider,
    'filter' => $quotationDetailService,
    'columns' => array(
        array(
            'header' => 'Penawaran #',
            'filter' => '<div style="display: inline-block">' . CHtml::textField('CnOrdinal', $cnOrdinal, array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::dropDownList('CnMonth', $cnMonth, array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::textField('CnYear', $cnYear, array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => 'CHtml::encode($data->quotationHeader->getCodeNumber(CHtml::value($data, "quotationHeader.cnConstant")))'
        ),
        array(
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->quotationHeader->date)'
        ),
        array(
            'header' => 'Customer',
            'value' => 'CHtml::encode(CHtml::value($data, "quotationHeader.customer.company"))'
        ),
        array(
            'header' => 'GRADE',
            'value' => 'CHtml::encode(CHtml::value($data, "product_name"))'
        ),
        array(
            'header' => 'Tebal',
            'filter' => CHtml::activeTextField($quotationDetailService, 'height_quote'),
            'value' => 'CHtml::encode(CHtml::value($data, "height_quote"))'
        ),
        array(
            'header' => 'Lebar',
            'filter' => CHtml::activeTextField($quotationDetailService, 'width_quote'),
            'value' => 'CHtml::encode(CHtml::value($data, "width_quote"))'
        ),
        array(
            'header' => 'Panjang',
            'filter' => CHtml::activeTextField($quotationDetailService, 'length_quote'),
            'value' => 'CHtml::encode(CHtml::value($data, "length_quote"))'
        ),
        'weight: Berat'
    ),
    'selectionChanged' => 'function(id) {
        $("#QuotationDetailServiceId").val($.fn.yiiGridView.getSelection(id));
        $("#quotation-detail-service-dialog").dialog("close");
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('ajaxHtmlAddService', array('id' => $sale->header->id)) . '",
            data: $("form").serialize(),
            success: function(html) {
                $("#detail_div").html(html);
            }
        })
    }'
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
