<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">Account</th>
        <th style="text-align: center;">Payment Type</th>
        <th style="text-align: center;">Amount</th>
        <th style="text-align: center;">Memo</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php foreach ($model->details as $i => $detail): ?>
        <?php $tabIndex = $i * 2; ?>
        <tr style="background-color: azure">

            <td style="">
                <?php echo CHtml::activeHiddenField($detail, "[$i]account_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'account.name')); ?>
            </td>

            <td style="text-align: center; margin-left: 20%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]payment_type_id", CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
                <?php echo CHtml::error($detail, 'payment_type_id'); ?>
            </td>
            <td style="text-align:center"><!--amount-->
                <?php echo CHtml::activeTextField($detail, "[$i]amount", array('class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1)); ?>
                <?php echo CHtml::error($detail, 'amount'); ?>
            </td>

            <td style="text-align:center"><!--memo-->
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 2)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $model->header->id, 'index' => $i)),
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

</table>