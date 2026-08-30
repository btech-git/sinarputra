<script type="text/javascript">

    //   window.onload = function() {
    //		//prevent javascript error because of empty value variable
    //		<?php if ($receive->header->purchase_header_id != null): ?>
    //			var purchaseHeader = <?php echo ($receive->header->purchase_header_id); ?>;
    //		<?php else: ?>
    //			var purchaseHeader = 0;
    //		<?php endif; ?>				
    //				
    //		if(purchaseHeader == 0)
    //		{
    //			$("#btn_product").show(); 
    //		}
    //		else
    //		{
    //			$("#btn_product").hide(); 
    //		}
    //
    //	}
    //	
    //	function reload(purchaseHeader)
    //	{
    //		if(purchaseHeader != null)
    //		{
    //			$("#btn_product").hide(); 
    //		}
    //	}
</script>

<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($receive->header); ?>
    <div class="container">
        <div class="span-12">
            <?php if (!$receive->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Penerimaan #', false); ?>
                    <?php echo CHtml::encode($receive->header->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$receive->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($receive->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($receive->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($receive->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Gudang', '', array('required' => true)); ?>
                <?php echo CHtml::activeDropDownList($receive->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- Pilih Gudang --')); ?>
                <?php echo CHtml::error($receive->header, 'warehouse_id'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Lokal / Impor', FALSE); ?>
                <?php if ($receive->header->isNewRecord): ?>
                    <?php echo CHtml::activeDropDownList($receive->header, 'receiving_type', array(
                         ReceiveHeader::LOCAL => ReceiveHeader::LOCAL_LITERAL,
                         ReceiveHeader::IMPORT => ReceiveHeader::IMPORT_LITERAL,
                         ReceiveHeader::OTHER => ReceiveHeader::OTHER_LITERAL,
                    ), array(
                        'onchange' => 'showHidePurchase();
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlResetDetail', array('id' => $receive->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(html) { $("#detail_div").html(html); }
                            ,}); '
                        ));
                    ?>
                    <?php echo CHtml::error($receive->header, 'receiving_type'); ?>
                <?php else: ?>
                    <?php echo CHtml::activeHiddenField($receive->header, 'receiving_type'); ?>
                    <?php echo CHtml::encode(CHtml::value($receive->header, 'receivingType')); ?>
                <?php endif; ?>
            </div>

            <div id="purchase_div">
                <div class="row" >
                    <?php echo CHtml::label('Purchase #', ''); ?>
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeTextField($receive->header, 'purchase_header_id', array('readonly' => true, 'onclick' => '$("#purchase-header-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#purchase-header-dialog").dialog("open"); return false; }')); ?>
                        <?php echo CHtml::openTag('span', array('id' => 'purchase_header_code_number')); ?>
                        <?php echo CHtml::encode(($purchaseHeader === null) ? '' : $purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                        <?php echo CHtml::error($receive->header, 'purchase_header_id'); ?>

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
                            'dataProvider' => $purchaseHeaderDataProvider,
                            'filter' => $purchaseHeader,
                            'selectionChanged' => 'js:function(id) {
                                $("#' . CHtml::activeId($receive->header, 'purchase_header_id') . '").val($.fn.yiiGridView.getSelection(id));
                                $("#purchase-header-dialog").dialog("close");
                                if ($.fn.yiiGridView.getSelection(id) == "")
                                {
                                    $("#purchase_header_code_number").html("");
                                    $("#purchase_header_date").html("");
                                    $("#supplier_company").html("");
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "' . CController::createUrl('AjaxJsonPurchase', array('id' => $receive->header->id)) . '",
                                        data: $("form").serialize(),
                                        success: function(data) {
                                            $("#purchase_header_code_number").html(data.purchase_header_code_number);
                                            $("#purchase_header_date").html(data.purchase_header_date);
                                            $("#supplier_company").html(data.supplier_company);
                                            reload(data.purchase_header_code_number);
                                        },
                                    });
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlShowPurchase', array('id' => $receive->header->id)) . '",
                                    data: $("form").serialize(),
                                    success: function(html) { $("#detail_div").html(html); }
                                });
                            }',
                            'columns' => array(
                                array(
                                    'name' => 'cn_ordinal',
                                    'header' => 'Order #',
                                    'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($purchaseHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                                    '<div style="display: inline-block"> &nbsp; /' . PurchaseHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                                    '<div style="display: inline-block">' . CHtml::activeDropDownList($purchaseHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                                    '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                                    '<div style="display: inline-block">' . CHtml::activeTextField($purchaseHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
                                    'value' => '$data->getCodeNumber(PurchaseHeader::CN_CONSTANT)',
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
                        <?php if ($receive->header->purchaseHeader) : ?>
                            <?php echo CHtml::encode($receive->header->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)); ?>
                            <?php echo CHtml::activeHiddenField($receive->header, 'purchase_header_id', array('value' => $receive->header->purchase_header_id)); ?>
                        <?php endif; ?>	
                    <?php endif; ?>
                </div>

                <div class="row">
                    <?php echo CHtml::label('Tanggal Beli', ''); ?>
                    <span id="purchase_header_date">
                        <?php echo CHtml::encode(CHtml::value($receive->header, 'purchaseHeader.date')); ?>
                    </span>
                </div>

                <div class="row">
                    <?php echo CHtml::label('Supplier', ''); ?>
                    <span id="supplier_company">
                        <?php echo CHtml::encode(CHtml::value($receive->header, 'purchaseHeader.supplier.company')); ?>
                    </span>
                </div>
            </div>
            <div id="supplier_div">
                <div class="row">
                    <?php echo CHtml::label('Supplier', ''); ?>
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeTextField($receive->header, 'supplier_id', array('readonly' => true, 'onclick' => '$("#supplier-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }')); ?>
                        <?php echo CHtml::error($receive->header, 'supplier_id'); ?>

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
                                $("#' . CHtml::activeId($receive->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                                $("#supplier-dialog").dialog("close");
                                if ($.fn.yiiGridView.getSelection(id) == "")
                                {
                                    $("#supplier_name").html("");
                                    $("#supplierr_company").html("");
                                    $("#supplier_address").html("");
                                } else {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "JSON",
                                        url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $receive->header->id)) . '",
                                        data: $("form").serialize(),
                                        success: function(data) {
                                            $("#supplier_name").html(data.supplier_name);
                                            $("#supplierr_company").html(data.supplier_company);
                                            $("#supplier_address").html(data.supplier_address);
                                        },
                                    });
                                }
                            }',
                            'columns' => array(
                                'code',
                                'name',
                                'company',
                                'address_main',
                            ),
                        ));
                        ?>
                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <?php echo CHtml::label('Nama', ''); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                    <?php echo CHtml::encode(CHtml::value($receive->header, 'supplier.name')); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                </div>

                <div class="row">
                    <?php echo CHtml::label('Perusahaan', ''); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'supplierr_company')); ?>
                    <?php echo CHtml::encode(CHtml::value($receive->header, 'supplier.company')); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                </div>

                <div class="row">
                    <?php echo CHtml::label('Alamat', ''); ?>
                    <?php echo CHtml::openTag('span', array('id' => 'supplier_address')); ?>
                    <?php echo CHtml::encode(CHtml::value($receive->header, 'supplier.address_main')); ?>
                    <?php echo CHtml::closeTag('span'); ?>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::error($receive->header, 'error'); ?>
    </div>

    <div class="row" id="add_details_div">
        <?php echo CHtml::textField('ProductName', '', array('placeholder' => 'Nama Barang', 'size' => 25)); ?>
        <?php echo CHtml::dropDownList('ProductCategoryId', '', CHtml::listData(ProductCategory::model()->findAll(array(
            'condition' => 'id IN (1, 2, 3, 5)'
        )), 'id', 'name'), array(
            'empty' => '-Select Category-',
        )); ?>
        <?php echo CHtml::textField('Height', '', array('placeholder' => 'Tbl/Dmtr', 'size' => 8, 'maxLength' => 10)); ?>
        <?php echo CHtml::textField('Width', '', array('placeholder' => 'Lebar', 'size' => 5, 'maxLength' => 10)); ?>
        <?php echo CHtml::textField('Length', '', array('placeholder' => 'Panjang', 'size' => 5, 'maxLength' => 10)); ?>
        <?php echo CHtml::textField('WeightPacking', '', array('placeholder' => 'Packing List (kg)', 'size' => 12, 'maxLength' => 10)); ?>
        <?php echo CHtml::dropDownList('LocationId', '', CHtml::listData(Location::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
            'empty' => '-Select Location-'
        )); ?>
        <?php echo CHtml::textField('Memo', '', array('placeholder' => 'Memo', 'size' => 35)); ?>
        <?php echo CHtml::textField('Quantity', '', array('placeholder' => 'Quantity', 'size' => 5, 'maxLength' => 10)); ?>
        <?php echo CHtml::button('Tambah Barang', array(
            'id' => 'btn_product',
            'onclick' => '
                $.ajax({
                    type: "POST",
                    data: $("form").serialize(),
                    url: "'. CController::createUrl('ajaxHtmlAddProduct', array('id' => $receive->header->id)). '",
                    success: function(html){
                        $("#detail_div").html(html);
                        $("#ProductName").val("");
                        $("#ProductCategoryId").val("");
                        $("#Height").val("");
                        $("#Width").val("");
                        $("#Length").val("");
                        $("#WeightPacking").val("");
                        $("#LocationId").val("");
                        $("#Memo").val("");
                        $("#Quantity").val("");
                    }
                });
            '
        )); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('receive' => $receive)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'search-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Product',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'product-grid',
    'dataProvider' => $productSizeDataProvider,
    'filter' => $productSize,
    'selectionChanged' => 'js:function(id) {
        $("#ProductSizeId").val($.fn.yiiGridView.getSelection(id));
        $("#search-dialog").dialog("close");
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $receive->header->id,)) . '",
            data: $("form").serialize(),
            success: function(html) { $("#detail_div").html(html); },
        });
    }',
    'columns' => array(
        array(
            'header' => 'Product Name',
            'filter' => CHtml::activeTextField($productSize, 'productName'),
            'value' => 'CHtml::encode(CHtml::value($data, "product.name"))'
        ),
        array(
            'header' => 'Category',
            'filter' => CHtml::activeDropDownList($productSize, 'productCategoryId', CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => ''
            )),
            'value' => 'CHtml::encode(CHtml::value($data, "product.productCategory.name"))'
        ),
        array(
            'header' => 'Tebal',
            'filter' => CHtml::activeTextField($productSize, 'height'),
            'value' => 'CHtml::encode(CHtml::value($data, "height"))'
        ),
        array(
            'header' => 'Lebar',
            'filter' => CHtml::activeTextField($productSize, 'width'),
            'value' => 'CHtml::encode(CHtml::value($data, "width"))'
        ),
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    var purchaseDiv = document.getElementById('purchase_div');
    var supplierDiv = document.getElementById('supplier_div');
    showHidePurchase();

    function showHidePurchase(){
        var receivingType = document.getElementById('ReceiveHeader_receiving_type').value;

        if (receivingType == 2){
            purchaseDiv.style.display = 'none';
            supplierDiv.style.display = 'block';
            $("#add_details_div").show();
        }
        else if (receivingType == 1){
            purchaseDiv.style.display = 'block';
            supplierDiv.style.display = 'none';
            $("#add_details_div").hide(); 
        }
        else if (receivingType == 3){
            purchaseDiv.style.display = 'none';
            supplierDiv.style.display = 'none';
            $("#add_details_div").show(); 
        }
    }
</script>