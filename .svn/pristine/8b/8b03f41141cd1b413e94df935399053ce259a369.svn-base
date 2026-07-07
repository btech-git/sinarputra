<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$quotationReturn->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Quotation Return #', false); ?>
                    <?php echo CHtml::encode($quotationReturn->header->getCodeNumber(QuotationReturnHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $quotationReturn->header->date)); ?>
                <?php echo CHtml::error($quotationReturn->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($quotationReturn->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($quotationReturn->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::activeTextField($quotationReturn->header, 'customer_id', array('readonly' => true, 'onclick' => '$("#customer-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }')); ?>
                <?php echo CHtml::error($quotationReturn->header, 'customer_id'); ?>

                <?php
                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'customer-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Customer',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                ));
                ?>
                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'customer-grid',
                    'dataProvider' => $customer->search(),
                    'filter' => $customer,
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($quotationReturn->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#customer-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#customer_name").html("");
                            $("#customer_company").html("");
                            $("#customer_address").html("");

                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $quotationReturn->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#customer_name").html(data.customer_name);
                                    $("#customer_company").html(data.customer_company);
                                    $("#customer_address").html(data.customer_address);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        'name',
                        'company',
                        'address_main',
                    ),
                ));
                ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($quotationReturn->header, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($quotationReturn->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_address')); ?>
                <?php echo CHtml::encode(CHtml::value($quotationReturn->header, 'customer.address_main')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#search-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#search-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('ProductId'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::error($quotationReturn->header, 'error'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('quotationReturn' => $quotationReturn)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'search-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Products',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'product-grid',
        'dataProvider' => $productDataProvider,
        'filter' => $product,
        'selectionChanged' => 'js:function(id) {
			$("#ProductId").val($.fn.yiiGridView.getSelection(id));
			$("#search-dialog").dialog("close");
			$.ajax({
				type: "POST",
				url: "' . CController::createUrl('ajaxHtmlAddProductColor', array('id' => $quotationReturn->header->id,)) . '",
				data: $("form").serialize(),
				success: function(html) { $("#detail_div").html(html); },
			});
		}',
        'columns' => array(
            'code: Kode',
            'name: Produk',
            array(
                'header' => 'Kategory Produk',
                'name' => 'product_category_id',
                'filter' => CHtml::listData(ProductCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'),
                'value' => '$data->productCategory->name',
            ),
        ),
    ));
    ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>
