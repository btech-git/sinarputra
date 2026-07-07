
<div id="receive_detail_div" name="tabs">
    <h3>Lembaran</h3>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
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
                'filter' => false, 
                'value' => 'CHtml::value($data, "product.code")'
            ),
            array(
                'header' => 'GRADE',
                'filter' => CHtml::activeTextField($receiveDetail, 'product_name'),
                'value' => 'CHtml::encode(CHtml::value($data, "product_name"))'
            ),
            array(
                'header' => 'Kategori',
                'filter' => CHtml::activeDropDownList($receiveDetail, 'product_category_id', CHtml::listData(ProductCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Category-'
                )),
                'value' => 'CHtml::value($data, "productCategory.name")'
            ),
            array(
                'header' => 'Tebal',
                'filter' => CHtml::activeTextField($receiveDetail, 'height'),
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "height")), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'filter' => CHtml::activeTextField($receiveDetail, 'width'),
                'value' => 'number_format(CHtml::encode($data->getWidth()), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Panjang',
                'filter' => CHtml::activeTextField($receiveDetail, 'length'),
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "length")), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Berat',
                'filter' => CHtml::activeTextField($receiveDetail, 'weight'),
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 4)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lokasi',
                'filter' => CHtml::activeDropDownList($receiveDetail, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Location-'
                )),
                'value' => 'CHtml::value($data, "location.name")'
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{update}',
                'updateButtonUrl' => 'CHtml::normalizeUrl(array("updateReceive", "id"=>$data->id))',
            ),
        ),
    ));
    ?>
</div>
