<?php
$this->breadcrumbs = array(
    'SPK Replacement' => array('admin'),
    'Create',
);
?>
<h1>Hasil Potong</h1>

<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model->header); ?>
	<?php $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByPk($model->header->work_order_cutting_header_id); ?>
    
    <div class="span-12">
        <div class="row">
            <?php echo CHtml::label('SPK Replacement #', false); ?>
            <?php echo CHtml::encode($model->header->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)); ?>
        </div>

        <div class="row">
            <?php echo CHtml::label('Tanggal', false); ?>
            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $model->header->date)); ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::label('SPK #', false); ?>
            <?php echo CHtml::encode($workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?>
        </div>

    </div>
    
    <div class="span-12 last">
        <div class="row">
            <?php echo CHtml::label('Customer', ''); ?>
            <?php echo CHtml::encode(CHtml::value($workOrderCuttingHeader, 'saleHeader.customer.company')); ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::label('Catatan', ''); ?>
            <?php echo CHtml::encode($model->header->note); ?>
        </div>
    </div>
    
    <hr />

    <table style="border: 1px solid">
        <tr style="background-color: skyblue">
            <th style="text-align: center;">GRADE</th>
            <th style="text-align: center;">Kategori</th>
            <th style="text-align: center;">Tbl/Dmtr</th>
            <th style="text-align: center;">Lbr</th>
            <th style="text-align: center;">Pjg</th>
            <th style="text-align: center;">Jumlah</th>
            <th style="text-align: center;">Berat</th>
            <th style="text-align: center;">Urgent</th>
        </tr>
        <tr>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'product_name')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'productCategory.name')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'height_request')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'width_request')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'length_request')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'quantity')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'weightRequest')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($model->details[$index], 'urgentStatus')); ?>
            </td>
        </tr>
    </table>

    <br/>

    <h2>Material Awal</h2> 
    <?php echo CHtml::hiddenField('ReceiveDetailId'); ?>
    <?php echo CHtml::label('Banyaknya Row', 'RowQuantity', array('style' => 'display: inline')); ?>
    <?php echo CHtml::textField('RowQuantity', '', array('size' => 2, 'maxLength' => 5)); ?>
    <?php echo CHtml::button('Cari Lembaran', array(
        'onclick' => '$("#receive-detail-dialog").dialog("open")',
        'onkeypress' => 'if (event.keyCode == 13) { $("#receive-detail-dialog").dialog("open"); return false; }'
    )); ?>
    <?php echo CHtml::hiddenField('WorkOrderCuttingDetailMaterialId'); ?>
    <?php echo CHtml::button('Cari Sisa Potong', array(
        'onclick' => '$("#material-detail-dialog").dialog("open")',
        'onkeypress' => 'if (event.keyCode == 13) { $("#material-detail-dialog").dialog("open"); return false; }'
    )); ?>

    <div id="detail_div">
        <?php $this->renderPartial('_detailMaterial', array(
            'model' => $model
        )); ?>
    </div> 

    <br />

    <div class="row buttons">
        <?php if ($index > 0) : ?>
            <?php echo CHtml::submitButton('Back', array('name' => 'Back', 'confirm' => 'Are you sure you want to back?')); ?>
        <?php endif; ?>
        <?php echo CHtml::submitButton('Next', array('name' => 'Next', 'confirm' => 'Are you sure you want to next?')); ?>
    </div>
    
    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'receive-detail-dialog',
    'options' => array(
        'title' => 'Stok Lembaran',
        'width' => 'auto',
        'autoOpen' => FALSE,
        'modal' => true
    )
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receive-detail-grid',
    'dataProvider' => $receiveDetailDataProvider,
    'filter' => $receiveDetail,
    'columns' => array(
        array(
            'header' => 'SerialNumber',
            'filter' => CHtml::activeTextField($receiveDetail, 'serial_number'),
            'value' => 'CHtml::value($data, "serialConstant")'
        ),
        array(
            'header' => 'Code',
            'value' => 'CHtml::value($data, "product.code")'
        ),
        array(
            'header' => 'GRADE',
            'filter' => CHtml::activeTextField($receiveDetail, 'product_name'),
            'value' => 'CHtml::value($data, "product_name")'
        ),
        array(
            'header' => 'Tebal/Dmtr',
            'filter' => CHtml::activeTextField($receiveDetail, 'height'),
            'value' => 'CHtml::encode(CHtml::value($data, "height"))'
        ),
        array(
            'header' => 'Lebar/Dmtr',
            'filter' => CHtml::activeTextField($receiveDetail, 'width'),
            'value' => 'CHtml::encode(CHtml::value($data, "width"))'
        ),
        array(
            'header' => 'Panjang',
            'filter' => CHtml::activeTextField($receiveDetail, 'length'),
            'value' => 'CHtml::encode(CHtml::value($data, "length"))'
        ),
        array(
            'header' => 'Lokasi',
            'filter' => CHtml::activeDropDownList($receiveDetail, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                'empty' => '-Select Location-'
            )),
            'value' => 'CHtml::value($data, "location.name")'
        ),
    ),
    'selectionChanged' => 'function(id) {
        $("#ReceiveDetailId").val($.fn.yiiGridView.getSelection(id));
        $("#WorkOrderCuttingDetailMaterialId").val("");	//empty cutting detail material value to prevent double detail add
        $("#receive-detail-dialog").dialog("close");
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $model->header->id, 'index' => $index)) . '",
            data: $("form").serialize(),
            success: function(html) {
                $("#detail_div").html(html);
            }
        })
    }'
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'material-detail-dialog',
    'options' => array(
        'title' => 'Stok Sisa Potong',
        'width' => 'auto',
        'autoOpen' => FALSE,
        'modal' => true
    )
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'material-detail-grid',
    'dataProvider' => $workOrderCuttingDetailMaterialDataProvider,
    'filter' => $workOrderCuttingDetailMaterial,
    'columns' => array(
        array(
            'header' => 'SerialNumber',
            'filter' => 
            '<div style="display: inline-block">' . CHtml::textField('ReceiveSerialNumber', $receiveSerialNumber, array('maxLength' => 10, 'size' => 3)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; - &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($workOrderCuttingDetailMaterial, 'serial_number', array('maxLength' => 5, 'size' => 3)) . '</div>',
            'value' => 'CHtml::value($data, "serialConstant")'
        ),
        'product_name',
        array(
            'header' => 'Tebal/Dmtr',
            'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'height'),
            'value' => 'CHtml::encode(CHtml::value($data, "height"))'
        ),
        array(
            'header' => 'Lebar/Dmtr',
            'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'width'),
            'value' => 'CHtml::encode(CHtml::value($data, "width"))'
        ),
        array(
            'header' => 'Panjang',
            'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'length'),
            'value' => 'CHtml::encode(CHtml::value($data, "length"))'
        ),
        array(
            'header' => 'Quantity',
            'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'quantity'),
            'value' => 'CHtml::encode(CHtml::value($data, "quantity"))'
        ),
        array(
            'header' => 'Lokasi',
            'filter' => CHtml::activeDropDownList($workOrderCuttingDetailMaterial, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                'empty' => '-Select Location-'
            )),
            'value' => 'CHtml::value($data, "location.name")'
        ),
    ),
    'selectionChanged' => 'function(id) {
        $("#WorkOrderCuttingDetailMaterialId").val($.fn.yiiGridView.getSelection(id));
        $("#ReceiveDetailId").val("");		//empty receive detail id to prevent double detail add
        $("#material-detail-dialog").dialog("close");
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $model->header->id, 'index' => $index)) . '",
            data: $("form").serialize(),
            success: function(html) {
                $("#detail_div").html(html);
            }
        })
    }'
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
