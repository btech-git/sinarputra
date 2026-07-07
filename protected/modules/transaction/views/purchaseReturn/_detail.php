<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center; width: 5%">Qty Retur</th>
        <th style="text-align: center; width: 15%">Harga</th>
        <th style="text-align: center; width: 15%">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php foreach ($purchaseReturn->details as $i => $detail): ?>
        <?php $tabIndex = $i * 1; ?>
        <tr style="background-color: azure">
            <?php if ($detail->receiveDetail->purchase_detail_id != null): ?>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]receive_detail_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'receiveDetail.purchaseDetail.product_name')); ?>
                </td>
            <?php else: ?>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]receive_detail_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'receiveDetail.product.name')); ?>
                </td>
            <?php endif; ?>
            <td style="text-align:center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 5, 'maxlength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $purchaseReturn->header->id, 'index' => $i)),
                        'success' => 'function(data) {
							$("#total_' . $i . '").html(data.total);
							$("#sub_total").html(data.subTotal);
						}',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1,
                ));
                ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]unit_price"); ?>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
            </td>
            <td style="text-align: right">
                <span id="total_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                </span>
            </td>
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $purchaseReturn->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    ));
                    ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="3">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="sub_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseReturn->subTotal)); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>