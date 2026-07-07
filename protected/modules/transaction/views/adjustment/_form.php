
<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$adjustment->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Penyesuaian #', ''); ?>
                    <?php echo CHtml::encode($adjustment->header->getCodeNumber(AdjustmentHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', ''); ?>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $adjustment->header->date)); ?>
                <?php echo CHtml::error($adjustment->header, 'date'); ?>
            </div>

            <div>
                <?php echo CHtml::label('Gudang', ''); ?>
                <?php
                echo CHtml::activeDropDownList($adjustment->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- Pilih Warehouse --',
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id' => $adjustment->header->id)),
                        'update' => '#detail_div',
                    )),
                ));
                ?>
                <?php echo CHtml::error($adjustment->header, 'warehouse_id'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($adjustment->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($adjustment->header, 'note'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'class' => 'btn_blue', 'onclick' => '$("#search-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#search-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('ProductId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('adjustment' => $adjustment)); ?>
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
				url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $adjustment->header->id,)) . '",
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