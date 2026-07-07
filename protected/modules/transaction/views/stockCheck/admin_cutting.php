<div id="cutting_detail_material_div" name="tabs">
    <h3>Sisa Potong</h3>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'material-detail-grid',
        'dataProvider' => $workOrderCuttingDetailMaterialDataProvider,
        'filter' => $workOrderCuttingDetailMaterial,
        'columns' => array(
            array(
                'header' => 'Serial Number',
                'filter' => 
                '<div style="display: inline-block">' . CHtml::textField('ReceiveSerialNumber', $receiveSerialNumber, array('maxLength' => 10, 'size' => 3)) . '</div>' .
                '<div style="display: inline-block"> &nbsp; - &nbsp; </div>' .
                '<div style="display: inline-block">' . CHtml::activeTextField($workOrderCuttingDetailMaterial, 'serial_number', array('maxLength' => 5, 'size' => 3)) . '</div>',
                'value' => 'CHtml::value($data, "serialConstant")'
            ),
            'product_name: GRADE',
            array(
                'header' => 'Kategori',
                'filter' => CHtml::activeDropDownList($workOrderCuttingDetailMaterial, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Kategori-'
                )),
                'value' => 'CHtml::value($data, "productCategory.name")'
            ),
            array(
                'header' => 'Tebal',
                'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'height'),
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "height")), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'width'),
                'value' => 'number_format(CHtml::encode($data->width), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Panjang',
                'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'length'),
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "length")), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Berat',
                'filter' => CHtml::activeTextField($workOrderCuttingDetailMaterial, 'weight'),
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 4)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lokasi',
                'filter' => CHtml::activeDropDownList($workOrderCuttingDetailMaterial, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Location-'
                )),
                'value' => 'CHtml::value($data, "location.name")'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}',
                'updateButtonUrl' => 'CHtml::normalizeUrl(array("updateCutting", "id"=>$data->id))',
            ),
        ),
    ));
    ?>
</div>
