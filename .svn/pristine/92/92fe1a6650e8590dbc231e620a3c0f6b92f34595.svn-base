<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$purchaseItem->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Pembelian Item #', false); ?>
                    <?php echo CHtml::encode($purchaseItem->header->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$purchaseItem->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchaseItem->header, 'date'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Tanggal Dibutuhkan', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$purchaseItem->header,
                    'attribute'=>'estimate_receive_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($purchaseItem->header, 'estimate_receive_date'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($purchaseItem->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($purchaseItem->header, 'note'); ?>
            </div>

        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Supplier', ''); ?>
                <?php echo CHtml::activeTextField($purchaseItem->header, 'supplier_id', array('readonly' => true, 'onclick' => '$("#supplier-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }')); ?>
                <?php echo CHtml::error($purchaseItem->header, 'supplier_id'); ?>

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
                        $("#' . CHtml::activeId($purchaseItem->header, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#supplier-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#supplier_name").html("");
                            $("#supplier_company").html("");
                            $("#supplier_address").html("");

                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonSupplier', array('id' => $purchaseItem->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#supplier_name").html(data.supplier_name);
                                    $("#supplier_company").html(data.supplier_company);
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
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseItem->header, 'supplier.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_company')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseItem->header, 'supplier.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'supplier_address')); ?>
                <?php echo CHtml::encode(CHtml::value($purchaseItem->header, 'supplier.address_main')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Payment', false); ?>
                <?php echo CHtml::activeDropDownList($purchaseItem->header, 'payment_period', array(
                    PurchaseItemHeader::COD => PurchaseItemHeader::COD_LITERAL,
                    PurchaseItemHeader::DAYS_15 => PurchaseItemHeader::DAYS_15_LITERAL,
                    PurchaseItemHeader::DAYS_30 => PurchaseItemHeader::DAYS_30_LITERAL,
                    PurchaseItemHeader::DAYS_60 => PurchaseItemHeader::DAYS_60_LITERAL,
                    PurchaseItemHeader::DAYS_90 => PurchaseItemHeader::DAYS_90_LITERAL,
                    PurchaseItemHeader::DAYS_45 => PurchaseItemHeader::DAYS_45_LITERAL,
                )); ?>
                setelah tukar faktur
                <?php echo CHtml::error($purchaseItem->header, 'payment_period'); ?>
            </div>

        </div>
    </div>

    <hr />

    <?php echo CHtml::button('Cari Item', array(
        'id' => 'btn_product',
        'name' => 'Search',
        'onclick' => '$("#search-dialog").dialog("open"); return false;',
        'onkeypress' => 'if (event.keyCode == 13) { $("#search-dialog").dialog("open"); return false; }'
    )); ?>
    <?php echo CHtml::hiddenField('ItemId'); ?>

    <div class="row">
        <?php echo CHtml::error($purchaseItem->header, 'error'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('purchaseItem' => $purchaseItem)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
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
    'dataProvider' => $itemDataProvider,
    'filter' => $item,
    'selectionChanged' => 'js:function(id) {
			$("#ItemId").val($.fn.yiiGridView.getSelection(id));
			$("#search-dialog").dialog("close");
			$.ajax({
				type: "POST",
				url: "' . CController::createUrl('ajaxHtmlAddItem', array('id' => $purchaseItem->header->id,)) . '",
				data: $("form").serialize(),
				success: function(html) { $("#detail_div").html(html); },
			});
		}',
    'columns' => array(
        'code',
        array(
            'header' => 'Item Name',
            'filter' => CHtml::activeTextField($item, 'name'),
            'value' => 'CHtml::encode(CHtml::value($data, "name"))'
        ),
        'description',
        array(
            'header' => 'Category',
            'filter' => CHtml::activeDropDownList($item, 'item_category_id', CHtml::listData(ItemCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                'empty' => ''
            )),
            'value' => 'CHtml::encode(CHtml::value($data, "itemCategory.name"))'
        ),
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>