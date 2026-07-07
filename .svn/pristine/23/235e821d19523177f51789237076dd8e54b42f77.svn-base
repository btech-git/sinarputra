<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%;">Kode</th>
        <th style="text-align: center; width: 10%;">Nama Barang</th>
        <th style="text-align: center; width: 10%;">Description</th>
        <th style="text-align: center; width: 10%;">Kategori</th>
        <th style="text-align: center; width: 5%;">Jumlah</th>	
        <th style="text-align: center; width: 15%">Harga</th>
        <th style="text-align: center; width: 15%">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($purchaseItem->details as $i => $detail): ?>
        <?php $tabIndex = $i * 2; ?>
        <tr>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]item_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, "item.code")); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, "item.name")); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, "item.description")); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, "item.itemCategory.name")); ?>
            </td>

            <!--quantity-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchaseItem->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#tax_value").html(data.calculatedTax);
                            $("#tax_income").html(data.calculatedTaxIncome);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1,
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]unit_price", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchaseItem->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#sub_total").html(data.subTotal);
                            $("#tax_value").html(data.calculatedTax);
                            $("#tax_income").html(data.calculatedTaxIncome);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 2,
                )); ?>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
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
                            'url' => CController::createUrl('ajaxHtmlRemoveItem', array('id' => $purchaseItem->header->id, 'index' => $i)),
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
        <td style="text-align: right; font-weight: bold" colspan="6">Sub Total</td>
        <td style="text-align: right; font-weight: bold">
            <span id="sub_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->header->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="6">Discount</td>
        <td style="text-align: right">
            (<?php echo CHtml::activeTextField($purchaseItem->header, 'discount', array(
                'size' => 10, 
                'maxLength' => 18,
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $purchaseItem->header->id)),
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
        <td style="text-align: right; font-weight: bold" colspan="6">
            PPn <?php echo CHtml::activeTextField($purchaseItem->header, "tax_percentage",array(
                'size' => 3, 
                'maxLength' => 2,
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $purchaseItem->header->id)),
                    'success' => 'function(data) {
                        $("#tax_value").html(data.taxValue);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            )); ?>% &nbsp;
            <?php /*echo CHtml::activeCheckBox($purchaseItem->header, 'is_tax',array(
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $purchaseItem->header->id)),
                    'success' => 'function(data) {
                        $("#tax_value").html(data.taxValue);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            ));*/ ?>
        </td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax_value">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->header->calculatedTax)); ?>
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="6">
            PPh 2% &nbsp;
            <?php echo CHtml::activeCheckBox($purchaseItem->header, 'is_tax_income',array(
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $purchaseItem->header->id)),
                    'success' => 'function(data) {
                        $("#tax_income").html(data.taxIncomeValue);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            )); ?>
        </td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax_income">
                (<?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->header->calculatedTaxIncome)); ?>)
            </span>
        </td>
        <td></td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="6">Grand Total</td>
        <td style="text-align: right; font-weight: bold">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseItem->header->grandTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>