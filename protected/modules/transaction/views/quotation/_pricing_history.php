<style>
    h3 {
        text-align: center;
    }

    .tabButtonHistory {
        display: inline-block;
        cursor: pointer;
        padding: 10px;
    }

    .active {
        background-color: #E5E5E5;
    }
</style>

<h1>Pricing History</h1>

<div>
    <?php echo CHtml::link('Barang', '', array(
        'name' => 'tabButtonHistory',
        'class' => 'tabButtonHistory',
        'onclick' => 'prevFlag = showUpTab(0, prevFlag)'
    )); ?>
    <?php echo CHtml::link('Jasa', '', array(
        'name' => 'tabButtonHistory',
        'class' => 'tabButtonHistory',
        'onclick' => 'prevFlag = showUpTab(1, prevFlag)'
    )); ?>
</div>

<div id="quotation_detail_product_div" name="tabsHistory">
    <h3>Barang</h3>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'detail-product-grid',
        'dataProvider' => $quotationDetailProductDataProvider,
        'filter' => $quotationDetailProduct,
        'columns' => array(
            array(
                'header' => 'Customer',
                'filter' => false,
                'value' => '$data->quotationHeader->customer->company',
            ),
            array(
                'header' => 'Tanggal',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->quotationHeader->date)'
            ),
            array(
                'header' => 'GRADE',
                'filter' => CHtml::activeTextField($quotationDetailProduct, 'product_name_quote'),
                'value' => 'CHtml::value($data, "product_name_quote")'
            ),
            array(
                'header' => 'Tebal',
                'filter' => CHtml::activeTextField($quotationDetailProduct, 'height_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "height_quote"))',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'filter' => CHtml::activeTextField($quotationDetailProduct, 'width_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "width_quote"))',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Harga',
                'value' => 'number_format($data->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>
</div>

<div id="quotation_detail_service_div" name="tabsHistory">
    <h3>Jasa</h3>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'detail-service-grid',
        'dataProvider' => $quotationDetailServiceDataProvider,
        'filter' => $quotationDetailService,
        'columns' => array(
            array(
                'header' => 'Customer',
                'filter' => false,
                'value' => '$data->quotationHeader->customer->company',
            ),
            array(
                'header' => 'Tanggal',
                'filter' => false,
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->quotationHeader->date)'
            ),
            array(
                'header' => 'GRADE',
                'filter' => CHtml::activeTextField($quotationDetailService, 'product_name'),
                'value' => 'CHtml::value($data, "product_name")'
            ),
            array(
                'header' => 'Tebal',
                'filter' => CHtml::activeTextField($quotationDetailService, 'height_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "height_quote"))',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'filter' => CHtml::activeTextField($quotationDetailService, 'width_quote'),
                'value' => 'CHtml::encode(CHtml::value($data, "width_quote"))',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Harga',
                'value' => 'number_format($data->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    ));
    ?>
</div>

<script>
    var prevFlag = 0;
    prevFlag = showUpTab(0, prevFlag);	//for identifying which tab that the class 'active' is removed

    function showUpTab(flag, prevFlag) {
        var tabsHistory = document.getElementsByName('tabsHistory');
        var tabButtonsHistory = document.getElementsByName('tabButtonHistory');

        //hide all tabs
        for (var i = 0; i < tabsHistory.length; i++) {
            tabsHistory[i].style.display = 'none';
        }

        tabButtonsHistory[prevFlag].className = 'tabButtonHistory';

        //show one tab		
        switch (flag) {
            case 0:
            document.getElementById('quotation_detail_product_div').style.display = 'block';
            break;

            case 1:
            document.getElementById('quotation_detail_service_div').style.display = 'block';
            break;
        }
        tabButtonsHistory[flag].className += " active";	//add active class

        return flag
    }
</script>