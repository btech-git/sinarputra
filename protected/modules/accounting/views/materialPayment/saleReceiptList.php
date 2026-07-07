<h1>List Tanda Terima</h1>
   
<div id="link">
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-receipt-grid',
    'dataProvider' => $saleReceiptHeaderDataProvider,
    'filter' => $saleReceiptHeader,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Tanda Terima #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($saleReceiptHeader, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . SaleReceiptHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($saleReceiptHeader, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($saleReceiptHeader, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(SaleReceiptHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Jatuh Tempo',
            'name' => 'due_date',
            'filter' => false, 
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->due_date)',
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany, array('size' => '30', 'maxLength' => '60')),
            'value' => 'CHtml::value($data, "customer.company")',
        ),
        array(
            'header' => 'Grand Total',
            'name' => 'grand_total',
            'filter' => false, 
            'value' => 'number_format($data->grand_total, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
        ),
        array(
            'header' => 'Pembayaran',
            'name' => 'payment_total',
            'filter' => false, 
            'value' => 'number_format($data->payment_total, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
        ),
        array(
            'header' => 'Sisa',
            'name' => 'remaining',
            'filter' => false, 
            'value' => 'number_format($data->remaining, 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            ),
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Create", array("create", "saleReceiptId"=>$data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
));
?>
