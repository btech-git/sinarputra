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
    <?php
    echo CHtml::link('Lembaran', '', array(
        'name' => 'tabButton',
        'class' => 'tabButton',
        'onclick' => 'previousFlag = showHideTab(0, previousFlag)'
    ));
    ?>
    <?php
    echo CHtml::link('Sisa Potong', '', array(
        'name' => 'tabButton',
        'class' => 'tabButton',
        'onclick' => 'previousFlag = showHideTab(1, previousFlag)'
    ));
    ?>
</div>

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
                'value' => 'CHtml::encode(CHtml::value($data, "height"))'
            ),
            array(
                'header' => 'Lebar',
                'filter' => CHtml::activeTextField($receiveDetail, 'width'),
                'value' => 'CHtml::encode(CHtml::value($data, "width"))'
            ),
            array(
                'header' => 'Panjang',
                'filter' => CHtml::activeTextField($receiveDetail, 'length'),
                'value' => 'CHtml::encode(CHtml::value($data, "length"))'
            ),
        ),
    ));
    ?>
</div>

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
            'height: Tebal',
            'width: Lebar',
            'length: Panjang',
        ),
    ));
    ?>
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