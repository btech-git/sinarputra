<style>
    h3 {
        text-align: center;
    }

    .tabButton {
        display: inline-block;
        cursor: pointer;
        padding: 10px;
    }

    .active {
        background-color: #E5E5E5;
    }
</style>

<h1>Stock Check</h1>

<div>
    <?php echo CHtml::link('Lembaran', '', array(
        'name' => 'tabButton',
        'class' => 'tabButton',
        'onclick' => 'previousFlag = showHideTab(0, previousFlag)'
    )); ?>
    <?php echo CHtml::link('Sisa Potong', '', array(
        'name' => 'tabButton',
        'class' => 'tabButton',
        'onclick' => 'previousFlag = showHideTab(1, previousFlag)'
    )); ?>
</div>

<div id="receive_detail_div" name="tabs">
    <h3>Lembaran</h3>
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
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 2)',
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
        ),
    )); ?>
</div>

<div id="cutting_detail_material_div" name="tabs">
    <h3>Sisa Potong</h3>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
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
                'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 2)',
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
        ),
    )); ?>
</div>

<script>
    var previousFlag = 0;
    previousFlag = showHideTab(0, previousFlag);	//for identifying which tab that the class 'active' is removed

    function showHideTab(flag, previousFlag) {
    var tabs = document.getElementsByName('tabs');
    var tabButtons = document.getElementsByName('tabButton');

    //hide all tabs
    for (var i = 0; i < tabs.length; i++) {
    tabs[i].style.display = 'none';
    }

    tabButtons[previousFlag].className = 'tabButton';

    //show one tab		
    switch (flag) {
    case 0:
    document.getElementById('receive_detail_div').style.display = 'block';
    break;

    case 1:
    document.getElementById('cutting_detail_material_div').style.display = 'block';
    break;
    }
    tabButtons[flag].className += " active";	//add active class

    return flag
    }
</script>