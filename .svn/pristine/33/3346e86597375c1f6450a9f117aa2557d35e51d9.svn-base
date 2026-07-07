<?php
//$sale as SaleHeader model

$this->breadcrumbs = array(
    'Sale' => array('create'),
    'View',
);
?>

<h1><?php //echo $sale->id . '/' . $sale->action->id; ?></h1>

<?php 
$this->widget('zii.widgets.CDetailView', array(
    'data' => $sale,
    'attributes' => array(
        array(
            'label' => 'Order Penjualan #',
            'value' => $sale->getCodeNumber(SaleHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $sale->date),
        ),
        array(
            'label' => 'Customer',
            'value' => CHtml::encode(CHtml::value($sale, 'customer.company')),
        ),
        array(
            'label' => 'Alamat Pusat',
            'value' => $sale->customer->address_main,
        ),
        array(
            'label' => 'Alamat Kirim',
            'value' => $sale->customer->address_secondary,
        ),
        array(
            'label' => 'PO Pending',
            'value' => $sale->orderStatus,
        ),
        array(
            'label' => 'Lembaran / Batangan',
            'value' => $sale->originalMaterialStatus,
        ),
        array(
            'label' => 'Customer PO',
            'value' => $sale->customer_order_number
        ),
        array(
            'label' => 'Tanggal PO',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $sale->customer_order_date),
        ),
        array(
            'label' => 'Tanggal Kirim',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $sale->estimate_delivery_date),
        ),
        array(
            'label' => 'Barang / Jasa',
            'value' => $sale->productServiceStatus,
        ),
        array(
            'label' => 'Status SO',
            'value' => $sale->transactionStatus,
        ),
        array(
            'label' => 'Catatan',
            'value' => $sale->note,
        ),
        array(
            'label' => 'Memo Penawaran',
            'value' => empty($sale->saleDetails[0]->quotationDetailProduct) ? $sale->saleDetails[0]->quotationDetailService->quotationHeader->note : $sale->saleDetails[0]->quotationDetailProduct->quotationHeader->note,
        ),
    ),
));
?>
<br />

<hr />

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'sale-detail-grid',
    'dataProvider' => $detailDataProvider,
    'columns' => array(
        array(
            'header' => 'Job Number',
            'value' => '((int)$data->quotation_detail_product_id == null) ? CHtml::encode(CHtml::value($data, "quotationDetailService.job_number")) : CHtml::encode(CHtml::value($data, "quotationDetailProduct.job_number"))'
        ),
        array(
            'header' => 'GRADE',
            'value' => '((int)$data->quotation_detail_product_id == null) ? CHtml::encode(CHtml::value($data, "quotationDetailService.product_name")) : CHtml::encode(CHtml::value($data, "quotationDetailProduct.product_name_quote"))'
        ),
        array(
            'header' => 'Tbl / Dmtr Permintaan',
            'value' => '(int)$data->quotation_detail_product_id == null ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.height_request")), 2) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.height_request")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Lbr Permintaan',
            'value' => '((int)$data->quotation_detail_product_id == null) ? ($data->quotationDetailService->product_category_id != 2 ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.width_request")), 2) : "") : ($data->quotationDetailProduct->product_category_id != 2 ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.width_request")), 2) : "")',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Pjg Permintaan',
            'value' => '((int)$data->quotation_detail_product_id == null) ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.length_request")), 2) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.length_request")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Tbl / Dmtr Penawaran',
            'value' => '((int)$data->quotation_detail_product_id == null) ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.height_quote")), 2) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.height_quote")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Lbr Penawaran',
            'value' => '((int)$data->quotation_detail_product_id == null) ? ($data->quotationDetailService->product_category_id != 2 ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.width_quote")), 2) : "") : ($data->quotationDetailProduct->product_category_id != 2 ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.width_quote")), 2) : "")',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Pjg Penawaran',
            'value' => '((int)$data->quotation_detail_product_id == null) ? CHtml::encode(CHtml::value($data, "quotationDetailService.length_quote")) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.length_quote")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Jumlah',
            'value' => '((int)$data->quotation_detail_product_id == null) ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.quantity_quote")), 2) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.quantity_quote")), 0)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Berat',
            'value' => '((int)$data->quotation_detail_product_id == null) ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.weight")), 5) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.weight")), 5)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Harga',
            'value' => '((int)$data->quotation_detail_product_id == null) ? number_format(CHtml::encode(CHtml::value($data, "quotationDetailService.unit_price")), 2) : number_format(CHtml::encode(CHtml::value($data, "quotationDetailProduct.unit_price")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'Total',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "total")), 2)',
            'htmlOptions' => array(
                'style' => 'text-align: right',
            ),
        ),
        array(
            'header' => 'M',
            'value' => '((int)$data->quotation_detail_product_id == null ? CHtml::encode(CHtml::value($data, "quotationDetailService.is_miling")) : (CHtml::value($data, "quotationDetailProduct.is_miling")) == 1) ? "Yes" : ""',
        ),
        array(
            'header' => 'SM',
            'value' => '((int)$data->quotation_detail_product_id == null ? CHtml::encode(CHtml::value($data, "quotationDetailService.is_sidemiling")) : (CHtml::value($data, "quotationDetailProduct.is_sidemiling")) == 1) ? "Yes" : ""',
        ),
        array(
            'header' => 'G',
            'value' => '((int)$data->quotation_detail_product_id == null ? CHtml::encode(CHtml::value($data, "quotationDetailService.is_grinding")) : (CHtml::value($data, "quotationDetailProduct.is_grinding")) == 1) ? "Yes" : ""',
        ),
        array(
            'header' => 'HT',
            'value' => '((int)$data->quotation_detail_product_id == null ? CHtml::encode(CHtml::value($data, "quotationDetailService.is_hardness")) : (CHtml::value($data, "quotationDetailProduct.is_hardness")) == 1) ? "Yes" : ""',
        ),
        array(
            'header' => 'NTD',
            'value' => '((int)$data->quotation_detail_product_id == null ? CHtml::encode(CHtml::value($data, "quotationDetailService.is_annelying")) : (CHtml::value($data, "quotationDetailProduct.is_annelying")) == 1) ? "Yes" : ""',
        ),
        array(
            'header' => 'QTN #',
            'value' => '((int)$data->quotation_detail_product_id == null) ? CHtml::encode($data->quotationDetailService->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)) : CHtml::encode($data->quotationDetailProduct->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT))',
        ),
    ),
));
?>
<br />

<table>
    <tr style="background-color: skyblue">
        <td style="font-weight: bold; width: 80%; text-align:right">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($sale, 'grandTotalTransaction'))); ?>
        </td>
        <td style="font-weight: bold; width: 12%; text-align:right">&nbsp;</td>
    </tr>	
</table>

<div id="link">
    <?php echo CHtml::link('Create', array('create')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print', array('memo', 'id' => $sale->id), array('target'=>'_blank'));  ?>
</div>