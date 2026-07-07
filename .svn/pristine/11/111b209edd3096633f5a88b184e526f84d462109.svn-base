
<?php $this->breadcrumbs = array(
    'Sale Invoice' => array('workOrderList'),
    'View',
); ?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $saleInvoice,
        'attributes' => array(
            array(
                'label' => 'Faktur #',
                'value' => $saleInvoice->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT),
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
                'label' => 'Customer PO #',
                'value' => CHtml::encode(CHtml::value($saleInvoice, 'workOrderCuttingHeader.saleHeader.customer_order_number')),
            ),
            array(
                'label' => 'SPK #',
                'value' => CHtml::encode($saleInvoice->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)),
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
            'grade_name: GRADE',
            array(
                'header' => 'Tebal',
                'value' => 'empty($data->workOrderCuttingDetail) ? "" : number_format($data->workOrderCuttingDetail->height_request, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Lebar',
                'value' => 'empty($data->workOrderCuttingDetail) ? "" : number_format($data->workOrderCuttingDetail->width_request, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: center',
                ),
            ),
            array(
                'header' => 'Panjang',
                'value' => 'empty($data->workOrderCuttingDetail) ? "" : number_format($data->workOrderCuttingDetail->length_request, 2)',
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
            ),
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
        <?php foreach($saleInvoice->salePaymentDetails as $salePaymentDetail): ?>
            <?php $salePayment = $salePaymentDetail->salePaymentHeader; ?>
            <tr>
                <td><?php echo CHtml::encode($salePayment->getCodeNumber(SalePaymentHeader::CN_CONSTANT)); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date_created)); ?></td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $salePayment->date)); ?></td>
                <td><?php echo CHtml::encode($salePayment->note); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <br/>

    <div id="link">
        <?php echo CHtml::link('Create', array('workOrderList')); ?>
        <?php echo CHtml::link('Manage', array('admin')); ?>
        <?php if ($saleInvoice->is_inactive == 0): ?>
            <?php echo CHtml::link('Print Invoice', array('memo', 'id' => $saleInvoice->id), array('target' => '_blank')); ?>
            <?php echo CHtml::link('Print SJ', array('memoDelivery', 'id' => $saleInvoice->id), array('target' => '_blank')); ?>        
        <?php else: ?>
            <span style="font-weight: bold; font-size: larger; color: red"><?php echo 'CANCELLED!!!'; ?></span>
        <?php endif; ?>
    </div>
</div>

