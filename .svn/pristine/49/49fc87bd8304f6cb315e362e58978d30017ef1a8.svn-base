<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 15%">Invoice #</th>
        <th style="text-align: center; width: 15%">Tanggal</th>
        <th style="text-align: center; width: 10%">PPh 23</th>
        <th style="text-align: center; width: 15%">Amount</th>
        <th style="text-align: center;">Memo</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php foreach ($model->details as $i => $detail): ?>
        <?php $receiveHeader = empty($detail->purchaseInvoice->receiveHeader) ? $detail->purchaseInvoice->receiveItemHeader : $detail->purchaseInvoice->receiveHeader; ?>
        <tr style="background-color: azure">
            <td><!--purchase invoice #-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]purchase_invoice_id"); ?>
                <?php echo CHtml::encode($detail->purchaseInvoice->getCodeNumber(PurchaseInvoice::CN_CONSTANT)); ?>
            </td>
            <td style="text-align:center"><!--Date-->
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $detail->purchaseInvoice->date)); ?>
            </td>
            <td style="text-align:right"><!--amount-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $receiveHeader->calculatedTaxIncome)); ?>
            </td>
            <td style="text-align:right"><!--amount-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->purchaseInvoice->grand_total)); ?>
            </td>
            <td style="text-align:center"><!--memo-->
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 50, 'maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $model->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => 'Active', 
                        ActiveRecord::INACTIVE => 'Inactive'
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td style="text-align: right; font-weight: bold" colspan="3">Sub Total:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->getSubtotal())); ?>
        </td>
        <td style="text-align: right; font-weight: bold" colspan="2">&nbsp;</td>
    </tr>
</table>