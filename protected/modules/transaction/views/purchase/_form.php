<script type="text/javascript">

    window.onload = function() {
        var is_service = <?php echo ($purchase->header->is_service); ?>;

        if(is_service == 0)
        {
            $("#detail_div").show(); 
            $("#btn_product").show(); 
            $("#service_div").hide();
            $("#btn_service").hide(); 
        }
        else
        {
            $("#detail_div").hide(); 
            $("#btn_product").hide(); 
            $("#service_div").show();
            $("#btn_service").show(); 
        }
    }
</script>

<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($purchase->header); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$purchase->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Pembelian #', false); ?>
                    <?php echo CHtml::encode($purchase->header->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$purchase->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchase->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Dibutuhkan', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$purchase->header,
                    'attribute'=>'estimate_receive_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchase->header, 'estimate_receive_date'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <?php echo CHtml::activeTextField($purchase->header, 'supplier_id', array('readonly' => true, 'onclick' => '$("#supplier-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }')); ?>
                <?php echo CHtml::error($purchase->header, 'supplier_id'); ?>

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
                        $("#' . CHtml::activeId($purchase->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#supplier-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#supplier_name").html("");
                            $("#supplier_company").html("");
                            $("#supplier_address").html("");
                            $("#supplier_is_tax").html("");
                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $purchase->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#supplier_name").html(data.supplier_name);
                                    $("#supplier_company").html(data.supplier_company);
                                    $("#supplier_address").html(data.supplier_address); 
                                    $("#taxPercentage").html(data.taxPercentage);                                                             
                                    $("#taxValue").html(data.taxValue);                                                                         
                                },
                            });
                        }
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
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'supplier.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'supplier.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_address')); ?>
                <?php echo CHtml::encode(CHtml::value($purchase->header, 'supplier.address_main')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($purchase->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($purchase->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Delivery', false); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'delivery_period', array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                )); ?> hari PO diterima
                <?php echo CHtml::error($purchase->header, 'delivery_period'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Payment', false); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'payment_period', array(
                    PurchaseHeader::COD => PurchaseHeader::COD_LITERAL,
                    PurchaseHeader::DAYS_15 => PurchaseHeader::DAYS_15_LITERAL,
                    PurchaseHeader::DAYS_30 => PurchaseHeader::DAYS_30_LITERAL,
                    PurchaseHeader::DAYS_60 => PurchaseHeader::DAYS_60_LITERAL,
                    PurchaseHeader::DAYS_90 => PurchaseHeader::DAYS_90_LITERAL,
                    PurchaseHeader::DAYS_45 => PurchaseHeader::DAYS_45_LITERAL,
                )); ?> setelah tukar faktur
                <?php echo CHtml::error($purchase->header, 'payment_period'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Valid', false); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'valid_period', array(
                    1 => '1',
                    2 => '2',
                    3 => '3',
                )); ?> hari 
                <?php echo CHtml::error($purchase->header, 'valid_period'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Lokal / Impor', FALSE); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'is_import', array(
                    'empty' => '-Select Type-',
                    0 => 'Lokal',
                    1 => 'Import',
                ), array(
                    'onchange' => 'showHideExchangeRate()'
                )); ?>
                <?php echo CHtml::error($purchase->header, 'is_import'); ?>
            </div>

            <div id="exchange_rate_div">
                <?php echo CHtml::label('Currency', FALSE); ?>
                <?php echo CHtml::activeDropDownList($purchase->header, 'currency_id', CHtml::listData(Currency::model()->findAll(), 'id', 'name'), array(
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            url: "' . CController::createUrl('ajaxJsonExchangeRate') . '",
                            data: $(this).serialize(),
                            dataType: "JSON",
                            success: function(data){
                                $("#' . CHtml::activeId($purchase->header, 'exchange_rate') . '").val(data.exchangeRate);
                            }
                        });
                    '
                )); ?>
                <?php echo CHtml::error($purchase->header, 'currency_id'); ?>

                <?php echo CHtml::label('Exchange Rate', FALSE); ?>
                <?php echo CHtml::activeTextField($purchase->header, 'exchange_rate', array('maxLength' => 18)); ?>
                <?php echo CHtml::error($purchase->header, 'exchange_rate'); ?>
            </div>
        </div>
    </div>

    <hr />

    <?php echo CHtml::button('Tambah Barang', array(
        'id' => 'btn_product',
        'onclick' => '$.ajax({
            type: "POST",
            data: $("form").serialize(),
            url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $purchase->header->id)) . '",
            success: function(html){
                $("#detail_div").html(html);
            }
        })'
    )); ?>
    
    <?php echo CHtml::button('Add Order Luar', array(
        'id' => 'btn_external_order',
        'onclick' => '$("#external-order-dialog").dialog("open"); return false;',
        'onkeypress' => 'if (event.keyCode == 13) { $("#external-order-dialog").dialog("open"); return false; }'
    )); ?>
    <?php echo CHtml::hiddenField('WorkOrderCuttingDetailId'); ?>

    <?php echo CHtml::button('Cek Stock', array(
        'id' => 'btn_check_stock',
        'name' => 'Search',
        'onclick' => '$("#stock-dialog").dialog("open"); return false;',
        'onkeypress' => 'if (event.keyCode == 13) { $("#stock-dialog").dialog("open"); return false; }'
    )); ?>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('purchase' => $purchase)); ?>
    </div>
    
    <table>
        <tr style="background-color: aquamarine">
            <td style="font-weight: bold; text-align:right; width: 80%">Sub Total</td>
            <td style="text-align: right; font-weight: bold">
                <span id="all_detail_sub_total">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->header, 'subTotal'))); ?>
                </span>
            </td>
            <td></td>
        </tr>

        <tr style="background-color: aquamarine">
            <td style="text-align:right">
                Discount 
            </td>
            <td style="text-align: right">
                ( <?php echo CHtml::activeTextField($purchase->header, 'discount', array(
                    'size' => 10, 
                    'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTaxTotal', array('id' => $purchase->header->id)),
                        'success' => 'function(data) {
                            $("#discount_amount").html(data.discountAmount);
                            $("#tax_value").html(data.taxValue);
                            $("#tax_income_value").html(data.taxIncomeValue);
                            $("#grand_total").html(data.grandTotal);
                            $("#' . CHtml::activeId($purchase->header, 'service_tax') . '").val(data.serviceTax);
                        }',
                    )),
                )); ?> )
            </td>
            <td style="width: 3%">&nbsp;</td>
        </tr>
        
        <tr style="background-color: aquamarine">
            <td style="font-weight: bold; text-align:right">
                PPN <?php echo CHtml::activeTextField($purchase->header, "tax_percentage",array(
                    'size' => 3, 
                    'maxLength' => 2,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTaxTotal', array('id' => $purchase->header->id)),
                        'success' => 'function(data) {
                            $("#tax_value").html(data.taxValue);
                            $("#tax_income_value").html(data.taxIncomeValue);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>% &nbsp;
            </td>
            <td style="text-align: right; font-weight: bold">
                <span id="tax_value">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->header, 'calculatedTax'))); ?>
                </span>    
            </td>
            <td></td>            
        </tr>
        
        <tr style="background-color: aquamarine">
            <td style="font-weight: bold; text-align:right">
                PPh 0.3% &nbsp;
                <?php echo CHtml::activeCheckBox($purchase->header, 'is_tax_income',array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTaxTotal', array('id' => $purchase->header->id)),
                        'success' => 'function(data) {
                            $("#tax_income_value").html(data.taxIncomeValue);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>   
            </td>
            <td style="text-align: right; font-weight: bold">
                <span id="tax_income_value">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->header, 'calculatedTaxIncome'))); ?>
                </span>    
            </td>
            <td></td>            
        </tr>
        
        <tr style="background-color: aquamarine">
            <td style="font-weight: bold; text-align:right">Grand Total</td>
            <td style="text-align: right; font-weight: bold">
                <span id="grand_total">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchase->header, 'grandTotal'))); ?>
                </span>
            </td>
            <td></td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div> <!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'external-order-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'List Order Luar',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php echo CHtml::beginForm('', 'post'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'external-order-grid',
    'dataProvider' => $workOrderCuttingDetailDataProvider,
    'filter' => $workOrderCuttingDetail,
    'selectionChanged' => 'js:function(id) {
        $("#WorkOrderCuttingDetailProductId").val($.fn.yiiGridView.getSelection(id));
        $("#external-order-dialog").dialog("close");
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('ajaxHtmlAddExternalOrder', array('id' => $purchase->header->id,)) . '",
            data: $("form").serialize(),
            success: function(html) { $("#detail_div").html(html); },
        });
    }',
    'columns' => array(
        array(
            'id' => 'selectedIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        array(
            'header' => 'SPK #',
            'filter' => FALSE,
            'value' => 'CHtml::encode($data->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT))'
        ),
        array(
            'header' => 'Customer',
            'filter' => FALSE,
            'value' => 'CHtml::encode(CHtml::value($data, "saleDetail.saleHeader.customer.company"))'
        ),
        array(
            'header' => 'Job Number',
            'value' => 'CHtml::encode(CHtml::value($data, "job_number"))'
        ),
        array(
            'header' => 'GRADE',
            'value' => 'CHtml::encode(CHtml::value($data, "product_name"))'
        ),
        array(
            'header' => 'Category',
            'filter' => CHtml::activeDropDownList($workOrderCuttingDetail, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => ''
            )),
            'value' => 'CHtml::encode(CHtml::value($data, "productCategory.name"))'
        ),
        array(
            'header' => 'Tebal',
            'value' => 'CHtml::encode(CHtml::value($data, "height_quote"))'
        ),
        array(
            'header' => 'Lebar',
            'value' => 'CHtml::encode(CHtml::value($data, "width_quote"))'
        ),
        array(
            'header' => 'Panjang',
            'value' => 'CHtml::encode(CHtml::value($data, "length_quote"))'
        ),
        array(
            'header' => 'Berat',
            'value' => 'CHtml::encode(CHtml::value($data, "weight"))'
        ),
        array(
            'header' => 'Qty',
            'value' => 'CHtml::encode(CHtml::value($data, "quantity"))'
        ),
    ),
)); ?>

<?php echo CHtml::ajaxSubmitButton('Add Order Luar', CController::createUrl('ajaxHtmlAddExternalOrders', array('id' => $purchase->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#detail_div").html(html);
        $("#external-order-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>


<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'stock-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Stock',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
));
?>

<?php $this->renderPartial('_stock_check', array(
    'receiveDetail' => $receiveDetail,
    'receiveDetailDataProvider' => $receiveDetailDataProvider,
    'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
    'workOrderCuttingDetailMaterialDataProvider' => $workOrderCuttingDetailMaterialDataProvider,
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    var exchangeRateDiv = document.getElementById('exchange_rate_div');
    showHideExchangeRate();

    function showHideExchangeRate(){
        var isImport = document.getElementById('PurchaseHeader_is_import').value;

        if (isImport == 1){
            exchangeRateDiv.style.display = 'block';
        }
        else {
            exchangeRateDiv.style.display = 'none';
        }
    }
</script>
