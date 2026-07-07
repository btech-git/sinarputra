<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Produk</th>
        <th style="text-align: center; width: 5%">Sekarang</th>
        <th style="text-align: center; width: 10%">Penyesuaian</th>
        <th style="text-align: center; width: 5%">Perbedaan</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($adjustment->details as $i => $detail): ?>
        <?php $tabIndex = $i * 1; ?>
        <tr style="background-color: azure; width: 20%">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
            </td>

            <td style="text-align: center">
                <?php //echo CHtml::hiddenField("quantity_current_{$i}", ($quantityCurrent = $detail->getCurrentStock($adjustment->header->warehouse_id))); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_current", array('value' => ($quantityCurrent = $detail->getCurrentStock($adjustment->header->warehouse_id)))); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quantityCurrent)); ?>
            </td>
            <td style="text-align: center">
                <?php
                echo CHtml::activeTextField($detail, "[$i]quantity_adjustment", array('size' => 5, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonDifference', array('id' => $adjustment->header->id, 'index' => $i)),
                        'success' => 'function(data) {
							$("#quantity_difference_' . $i . '").html(data.quantityDifference);
						}',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1,
                ));
                ?>
                <?php echo CHtml::error($detail, 'quantity_adjustment'); ?>
            </td>
            <td style="text-align: center">
                <span id="quantity_difference_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getQuantityDifference($adjustment->header->warehouse_id))); ?>
                </span>
            </td>

            <td>
                <?php
                echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveProduct', array('id' => $adjustment->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                ));
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
