<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Code</th>
        <th style="text-align: center;">Product Name</th>
        <th style="text-align: right;">Quantity</th>
        <th style="text-align: right;">Unit Price</th>
        <th style="text-align: right;">Total</th>
    </tr>

    <?php foreach ($receiveItemHeader->receiveItemDetails as $detail): ?>
        <tr style="background-color: azure">
            <td><!--code-->
                <?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.code')); ?>
            </td>

            <td><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.name')); ?>
            </td>

            <td  style="text-align: right;"><!--quantity-->
                <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
            </td>

            <td  style="text-align: right;"><!--unit price-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->purchaseItemDetail->unit_price)); ?>

            </td>
            <td  style="text-align: right;"><!--Product name-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="4">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($receiveItemHeader, 'subTotal'))); ?>
        </td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="4">Disc</td>
        <td style="text-align: right; font-weight: bold">
            <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receiveItemHeader->purchaseItemHeader->discount)); ?>
            <?php echo CHtml::activeTextField($model, 'discount_amount', array(
                'size' => 10, 
                'maxLength' => 20,
                'onchange' => CHtml::ajax(array(
                    'type' => 'POST',
                    'dataType' => 'JSON',
                    'url' => CController::createUrl('ajaxJsonGrandTotal', array('id' => $model->id)),
                    'success' => 'function(data) {
                        $("#tax_item").html(data.taxItem);
                        $("#tax_income").html(data.taxIncome);
                        $("#grand_total").html(data.grandTotal);
                    }',
                )),
            )); ?>
        </td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="4">PPN 11%</td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax_item">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTax)); ?>
            </span>
        </td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="4">PPh 2%</td>
        <td style="text-align: right; font-weight: bold">
            <span id="tax_income">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTaxIncome)); ?>
            </span>
        </td>
    </tr>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="4">Grand Total:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->grandTotal)); ?>  
            </span>
        </td>  
    </tr>
</table>