<?php $this->breadcrumbs = array(
    'Sale Invoice' => array('create'),
    'View',
); ?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $saleInvoice,
        'attributes' => array(
            array(
                'label' => 'Faktur #',
                'value' => $saleInvoice->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT),
            ),          
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleInvoice->date),
            ),        
            array(
                'label' => 'Jatuh Tempo',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleInvoice->due_date),
            ),       
            array(
                'label' => 'Tanggal Tukar TT',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleInvoice->date_receipt),
            ),   
            array(
                'label' => 'Customer',
                'value' => CHtml::encode(CHtml::value($saleInvoice, 'customer.company')),
            ),
            array(
                'label' => 'Alamat',
                'value' => CHtml::encode(CHtml::value($saleInvoice, 'customer.tax_address_main')),
            ),
            array(
                'label' => 'TOP',
                'value' => CHtml::encode(CHtml::value($saleInvoice, 'customer.invoice_due_days')),
            ),
            array(
                'label' => 'Jenis Invoice',
                'value' => CHtml::encode($saleInvoice->getServiceType($saleInvoice->service_type)),
            ),
//            array(
//                'label' => 'SPK #',
//                'value' => CHtml::encode($saleInvoice->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)),
//            ),
//            array(
//                'label' => 'SPK Tanggal',
//                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $saleInvoice->workOrderCuttingHeader->date),
//            ),
            array(
                'label' => 'Customer PO #',
                'value' => empty($saleInvoice->work_order_cutting_header_id) ? CHtml::encode(CHtml::value($saleInvoice, 'purchase_order_number')) : CHtml::encode(CHtml::value($saleInvoice, 'workOrderCuttingHeader.saleHeader.customer_order_number')),
            ),
            array(
                'label' => 'Faktur Pajak #',
                'value' => CHtml::encode(CHtml::value($saleInvoice, 'tax_number')),
            ),
            array(
                'label' => 'Salesman',
                'value' => CHtml::encode(CHtml::value($saleInvoice, 'employeeIdSalesman.name')),
            ),
            array(
                'label' => 'Catatan',
                'value' => $saleInvoice->note,
            ),
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'delivery-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'columns' => array(
            array(
                'header' => 'SPK #',
                'value' => 'empty($data->deliveryDetail) ? "" : $data->deliveryDetail->workOrderCuttingDetail->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)',
            ),
            array(
                'header' => 'SJ #',
                'value' => 'empty($data->deliveryDetail) ? "" : $data->deliveryDetail->deliveryHeader->getCodeNumber(DeliveryHeader::CN_CONSTANT)',
            ),
            array(
                'header' => 'Tanggal SJ',
                'value' => 'empty($data->deliveryDetail) ? "" : $data->deliveryDetail->deliveryHeader->date',
            ),
            'grade_name: GRADE',
            array(
                'header' => 'Tebal',
                'value' => 'empty($data->deliveryDetail->workOrderCuttingDetail) ? "" : number_format($data->deliveryDetail->workOrderCuttingDetail->height_request, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Lebar',
                'value' => 'empty($data->deliveryDetail->workOrderCuttingDetail) ? "" : number_format($data->deliveryDetail->workOrderCuttingDetail->width_request, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Panjang',
                'value' => 'empty($data->deliveryDetail->workOrderCuttingDetail) ? "" : number_format($data->deliveryDetail->workOrderCuttingDetail->length_request, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Berat',
                'value' => 'number_format($data->weight, 4)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Quantity',
                'value' => 'number_format($data->quantity, 0)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Unit Price',
                'value' => 'number_format($data->unit_price, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Pembulatan',
                'value' => 'number_format($data->rounding_amount, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Total',
                'value' => 'number_format($data->total, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            )
        ),
    )); ?>

    <table>
        <tr style="background-color: skyblue">
            <td style="font-weight: bold; text-align: right; width:80%;">Total:</td>
            <td style="font-weight: bold; text-align: right;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoice, 'subTotal'))); ?>
            </td>
        </tr>
        <tr style="background-color: skyblue">
            <td style="font-weight: bold; text-align: right; width:80%;">Discount:</td>
            <td style="font-weight: bold; text-align: right;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoice, 'discount'))); ?>
            </td>
        </tr>
        
        <tr style="background-color: skyblue">
            <td style="font-weight: bold; text-align: right; width:80%;">PPN <?php echo CHtml::encode(CHtml::value($saleInvoice, 'tax_percentage')); ?>%:</td>
            <td style="font-weight: bold; text-align: right;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoice, 'calculatedTax'))); ?>
            </td>
        </tr>

        <?php if ((int)$saleInvoice->is_tax_income === 1): ?>
            <tr style="background-color: skyblue">
                <td style="font-weight: bold; text-align: right; width:80%;">PPh 2%:</td>
                <td style="font-weight: bold; text-align: right;">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoice, 'calculatedTaxIncome'))); ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr style="background-color: skyblue">
            <td style="font-weight: bold; text-align: right; width:80%;">Grand Total:</td>
            <td style="font-weight: bold; text-align: right;">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoice, 'grandTotal'))); ?>
            </td>
        </tr>
    </table>
    
    <br/>

    <table style="border: 1px solid">
        <tr>
            <td style="text-align: center; font-weight: bold">Payment #</td>
            <td style="text-align: center; font-weight: bold">Tanggal Mutasi</td>
            <td style="text-align: center; font-weight: bold">Tanggal Pembayaran</td>
            <td style="text-align: center; font-weight: bold">Catatan</td>
        </tr>
        <?php foreach($saleInvoice->manualSalePaymentDetails as $salePaymentDetail): ?>
            <?php $salePayment = $salePaymentDetail->manualSalePaymentHeader; ?>
            <tr>
                <td><?php echo CHtml::encode($salePayment->getCodeNumber(ManualSalePaymentHeader::CN_CONSTANT)); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date_created)); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date)); ?></td>
                <td><?php echo CHtml::encode($salePayment->note); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <br/>

    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('Manage', array('admin')); ?>
        <?php if ($saleInvoice->is_inactive == 0): ?>
            <?php echo CHtml::link('Print Invoice', array('memo', 'id' => $saleInvoice->id), array('target' => '_blank')); ?>
        <?php else: ?>
            <span style="font-weight: bold; font-size: larger; color: red"><?php echo 'CANCELLED!!!'; ?></span>
        <?php endif; ?>
    </div>
</div>

