<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 30%">Faktur Penjualan #</th>
        <th style="text-align: center; width: 20%">Tanggal</th>
        <th style="text-align: center; width: 20%">Total(Rp)</th>
        <th style="text-align: center; width: 30%">Memo</th>
        <th></th>
    </tr>
    <?php foreach ($saleReceipt->details as $i => $detail): ?>
        <?php $tabIndex = $i * 2; ?>
        <?php $detailSaleInvoice = $detail->manualSaleInvoiceHeader; ?>

        <tr style="background-color: azure">
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]manual_sale_invoice_header_id"); ?>
                <?php echo CHtml::encode($detailSaleInvoice->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($detailSaleInvoice, 'date')))); ?>
            </td>
            <td style="text-align: right">
                <?php echo CHtml::activeHiddenField($detail, "[$i]total_invoice"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'manualSaleInvoiceHeader.grand_total'))); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 30, 'maxlength' => 60, 'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $saleReceipt->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
                        ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL,
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr style="background-color: aquamarine">
        <td colspan="2" style="font-weight: bold; text-align: right">TOTAL</td>
        <td style="font-weight: bold; text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleReceipt, 'totalReceipt'))); ?>
        </td>
        <td colspan="2"></td>
    </tr>
</table>
