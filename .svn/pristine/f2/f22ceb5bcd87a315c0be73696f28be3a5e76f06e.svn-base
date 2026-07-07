<?php
$this->breadcrumbs = array(
    'Delivery' => array('workOrderList'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $delivery,
        'attributes' => array(
            array(
                'label' => 'Pengiriman #',
                'value' => $delivery->getCodeNumber(ManualDeliveryHeader::CN_CONSTANT),
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $delivery->date),
            ),
            array(
                'label' => 'Tanggal Kirim Invoice',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $delivery->date_invoice_sent),
            ),
            array(
                'label' => 'Gudang',
                'value' => CHtml::encode(CHtml::value($delivery, 'warehouse.name')),
            ),
            array(
                'label' => 'Customer',
                'value' => CHtml::encode(CHtml::value($delivery, 'workOrderCuttingHeader.saleHeader.customer.company')),
            ),
            array(
                'label' => 'SO #',
                'type' => 'raw',
                'value' => ($delivery->workOrderCuttingHeader != null) ? CHtml::encode($delivery->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : 'N/A',
            ),
            array(
                'label' => 'SPK #',
                'type' => 'raw',
                'value' => ($delivery->workOrderCuttingHeader != null) ? CHtml::encode($delivery->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : 'N/A',
            ),
            array(
                'label' => 'Tanggal SO',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $delivery->workOrderCuttingHeader->saleHeader->date),
            ),
            array(
                'label' => 'Customer PO#',
                'value' => CHtml::encode(CHtml::value($delivery, 'workOrderCuttingHeader.saleHeader.customer_order_number')),
            ),
            array(
                'label' => 'Alamat Pusat',
                'value' => CHtml::encode(CHtml::value($delivery, 'workOrderCuttingHeader.saleHeader.customer.address_main')),
            ),
            array(
                'label' => 'Alamat Kirim',
                'value' => $delivery->customer_address,
            ),
            array(
                'label' => 'Kota Tujuan',
                'value' => $delivery->customer_city,
            ),
            array(
                'label' => 'Sopir',
                'value' => $delivery->driver,
            ),
            array(
                'label' => 'Status SJ',
                'value' => $delivery->delivery_status,
            ),
            array(
                'label' => 'Catatan',
                'value' => $delivery->note,
            ),
        ),
    ));
    ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'delivery-detail-grid',
        'dataProvider'=>new CArrayDataProvider($delivery->manualDeliveryDetails),
        'columns' => array(
            'grade_name: Name',
            'productCategory.name: Category',
            array(
                'header' => 'Tebal',
                'value' => 'number_format($data->height, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar',
                'value' => 'number_format($data->width, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Panjang',
                'value' => 'number_format($data->length, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'M',
                'value' => '(CHtml::value($data, "is_miling") == 1) ? "Yes" : ""',
            ),
            array(
                'header' => 'SM',
                'value' => '(CHtml::value($data, "is_sidemiling") == 1) ? "Yes" : ""',
            ),
            array(
                'header' => 'G',
                'value' => '(CHtml::value($data, "is_grinding") == 1) ? "Yes" : ""',
            ),
            array(
                'header' => 'HT',
                'value' => '(CHtml::value($data, "is_hardness") == 1) ? "Yes" : ""',
            ),
            array(
                'header' => 'NTD',
                'value' => '(CHtml::value($data, "is_annelying") == 1) ? "Yes" : ""',
            ),
            array(
                'header' => 'Berat',
                'value' => 'number_format(CHtml::value($data, "weight"), 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Quantity',
                'value' => 'number_format(CHtml::value($data, "quantity"), 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
        ),
    )); ?>

    <div id="link">
        <?php echo CHtml::link('Create', array('workOrderList')); ?> &nbsp; &nbsp;
        <?php echo CHtml::link('Manage', array('admin')); ?> &nbsp; &nbsp;
        <?php echo CHtml::link('Print', array('memo', 'id' => $delivery->id), array('target' => '_blank')); ?>
    </div>
</div>