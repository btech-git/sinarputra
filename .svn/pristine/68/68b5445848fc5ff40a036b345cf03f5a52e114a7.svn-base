<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">GRADE</th>
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr/Dmtr</th>
        <th style="text-align: center;">Pjg/Dmtr</th>
        <th style="text-align: center;">Weight</th>
        <th style="text-align: right;">Quantity</th>
        <th style="text-align: right;">Unit Price</th>
        <th style="text-align: right;">Total</th>
    </tr>
    <?php if ($receiveHeader->purchase_header_id != null) : ?>
        <?php foreach ($receiveHeader->purchaseHeader->purchaseDetails as $detail): ?>
            <tr style="background-color: azure">
                <td style="text-align: left;"><!--Product name-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                </td>

                <td style="text-align: right;"><!--height-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?>
                </td>

                <td style="text-align: right;"><!--width-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?>
                </td>

                <td style="text-align: right;"><!--length-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?>
                </td>

                <td style="text-align: right;"><!--weight-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?>
                </td>
                
                <td style="text-align: center;"><!--quantity-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                </td>

                <td style="text-align: right;"><!--unit price-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price)); ?>
                </td>
                
                <td style="text-align: right;"><!--total-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <tr style="background-color: aquamarine">
            <td style="text-align: right; font-weight: bold" colspan="7">Sub Total:</td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receiveHeader->purchaseHeader->subTotal)); ?>  
            </td>
        </tr>

        <tr style="background-color: aquamarine">
            <td style="text-align: right; font-weight: bold" colspan="7">Disc <?php echo CHtml::encode($receiveHeader->purchaseHeader->discount); ?>%</td>
            <td style="text-align: right; font-weight: bold">
                <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receiveHeader->discountAmount)); ?>
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
            <td style="text-align: right; font-weight: bold" colspan="7">PPN 11%</td>
            <td style="text-align: right; font-weight: bold">
                <span id="tax_item"></span>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTax)); ?>
            </td>
        </tr>
        
        <tr style="background-color: aquamarine">
            <td style="text-align: right; font-weight: bold" colspan="7">PPh 2%</td>
            <td style="text-align: right; font-weight: bold">
                <span id="tax_income">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTaxIncome)); ?>
            </td>
        </tr>
        
        <tr style="background-color: aquamarine">
            <td style="text-align: right; font-weight: bold" colspan="7">Grand Total:</td>
            <td style="text-align: right; font-weight: bold">
                <span id="grand_total"></span>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->grandTotal)); ?>  
            </td>  
        </tr>
    <?php endif; ?>
</table>