<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">Nama Barang</th>
        <th style="text-align: center; width: 5%;">Tebal</th>
        <th style="text-align: center; width: 5%;">Lebar</th>
        <th style="text-align: center; width: 5%;">Panjang</th>
        <th style="text-align: center; width: 5%;">Quantity</th>	
        <th style="text-align: center; width: 10%;">Satuan</th>
        <th style="text-align: center; width: 10%;">Berat (kg)</th>
        <th style="text-align: center; width: 3%;">kg/pcs</th>
        <th style="text-align: center; width: 15%">Harga Satuan (Rp)</th>
        <th style="text-align: center; width: 10%;">Pembulatan</th>
        <th style="text-align: center; width: 15%">Jumlah (Rp)</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($materialInvoice->details as $i => $detail): ?>
        <tr>
            <td><?php echo CHtml::activeTextField($detail, "[$i]material_name", array('size' => 50, 'maxLength' => 200)); ?></td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]height", array(
                    'size' => 10, 
                    'maxLength' => 10,
                )); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]width", array(
                    'size' => 10, 
                    'maxLength' => 10,
                )); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]length", array(
                    'size' => 10, 
                    'maxLength' => 10,
                )); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 10, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $materialInvoice->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#tax_value").html(data.calculatedTax);
                            $("#tax_income").html(data.calculatedTaxIncome);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center">
		<?php echo CHtml::activeDropDownList($detail, "[$i]unit_id", CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => '-Select Unit-')); ?>
                <?php echo CHtml::error($detail, 'unit_id'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]weight", array(
                    'size' => 10, 
                    'maxLength' => 10,
                )); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>
            
            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]is_using_weight", array(
                    MaterialInvoiceDetail::IS_USING_WEIGHT => MaterialInvoiceDetail::IS_USING_WEIGHT_LITERAL, 
                    MaterialInvoiceDetail::IS_USING_QUANTITY => MaterialInvoiceDetail::IS_USING_QUANTITY_LITERAL
                ), array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $materialInvoice->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#tax_value").html(data.calculatedTax);
                            $("#tax_income").html(data.calculatedTaxIncome);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                ));?>
                <?php echo CHtml::error($detail, 'is_using_weight'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]unit_price", array(
                    'size' => 15, 
                    'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $materialInvoice->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#tax_value").html(data.calculatedTax);
                            $("#tax_income").html(data.calculatedTaxIncome);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
            </td>

            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]rounding_amount", array(
                    'size' => 15, 
                    'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $materialInvoice->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#tax_value").html(data.calculatedTax);
                            $("#tax_income").html(data.calculatedTaxIncome);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                )); ?>
            </td>
            
            <td style="text-align: right">
                <span id="total_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                </span>
            </td>
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveItem', array('id' => $materialInvoice->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => 'Active', 
                        ActiveRecord::INACTIVE => 'Inactive',
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="10">Sub Total</td>
        <td style="text-align: right; font-weight: bold">
            <span id="sub_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->header->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="10">Discount</td>
        <td style="text-align: right">
            (<?php echo CHtml::activeTextField($materialInvoice->header, 'discount', array(
                'size' => 10, 
                'maxLength' => 18,
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $materialInvoice->header->id)),
                    'success' => 'function(data) {
                        $("#tax_value").html(data.taxValue);
                        $("#tax_income_value").html(data.taxIncomeValue);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            )); ?>)
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="10">
            PPn <?php echo CHtml::activeHiddenField($materialInvoice->header, "tax_percentage",array(
                'size' => 3, 
                'maxLength' => 2,
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $materialInvoice->header->id)),
                    'success' => 'function(data) {
                        $("#tax_value").html(data.taxValue);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            )); ?>
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $materialInvoice->header->tax_percentage)); ?>%
        </td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax_value">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->header->calculatedTax)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="10">
            PPh 2% &nbsp;
            <?php echo CHtml::activeCheckBox($materialInvoice->header, 'is_tax_income',array(
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $materialInvoice->header->id)),
                    'success' => 'function(data) {
                        $("#tax_income").html(data.taxIncomeValue);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            )); ?>
        </td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax_income">
                (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->header->calculatedTaxIncome)); ?>)
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="10">Grand Total</td>
        <td style="text-align: right; font-weight: bold">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $materialInvoice->header->grandTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>