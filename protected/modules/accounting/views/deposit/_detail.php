<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Akun</th>
        <th style="text-align: center">Jumlah</th>
        <th style="text-align: center">Memo</th>
        <th style="text-align: center"></th>
    </tr>
    <?php foreach ($deposit->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <!--akun-->
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]account_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?>
                <?php echo CHtml::error($detail, 'account_id'); ?>
            </td>

            <!--amount-->
            <td style="text-align: center;">
                <?php
                echo CHtml::activeTextField($detail, "[$i]amount", array('size' => 10, 'maxlength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $deposit->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                                            $("#amount_' . $i . '").html(data.amount);
                                            $("#grand_total").html(data.grandTotal);
                                        }',
                    )),
                ));
                ?>
                <div id="amount_<?php echo $i; ?>" style="text-align: right; font-size: smaller">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'amount'); ?>
            </td>

            <!--memo-->
            <td style="text-align: center;">
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 30, 'maxlength' => 60)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $deposit->header->id, 'index' => $i)),
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
        <td style="font-weight: bold; text-align: right">Total</td>
        <td style="font-weight: bold; text-align: right">
            <span id="grand_total">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', ceil(CHtml::value($deposit, 'grandTotal')))); ?>
            </span>
        </td>
        <td colspan="2"></td>
    </tr>
</table>
