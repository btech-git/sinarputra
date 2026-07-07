<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Invoice #</th>
        <th style="text-align: center; width: 10%">Tanggal</th>
        <th style="text-align: center; width: 10%">Nama Akun</th>
        <th style="text-align: center; width: 10%">Tipe Pembayaran</th>
        <th style="text-align: center">Memo</th>
        <th style="text-align: center; width: 10%">Piutang</th>
        <th style="text-align: center; width: 10%">PPh 23</th>
        <th style="text-align: center; width: 10%">Pembayaran</th>
        <th style="text-align: center; width: 10%">Akun Selisih 1</th>
        <th style="text-align: center; width: 10%">Selisih Bayar 1</th>
        <th style="text-align: center; width: 10%">Akun Selisih 2</th>
        <th style="text-align: center; width: 10%">Selisih Bayar 2</th>
        <th style="width: 3%"></th>
    </tr>
    <?php foreach ($salePayment->details as $i => $detail): ?>
        <?php $tabIndex = $i * 2; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]manual_sale_invoice_header_id"); ?>
                <?php echo CHtml::encode($detail->manualSaleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT)); ?>
                <?php echo CHtml::error($detail, 'manual_sale_invoice_header_id'); ?>
            </td>
            <td>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($detail, 'manualSaleInvoiceHeader.date'))); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]account_id", CHtml::listData(Account::model()->findAllByAttributes(array('account_category_id' => 2)), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
                <?php echo CHtml::error($detail, 'account_id'); ?>
            </td>
            <td style="text-align: center; margin-left: 20%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]payment_type_id", CHtml::listData(PaymentType::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
                <?php echo CHtml::error($detail, 'payment_type_id'); ?>
            </td>
            <td style="text-align: right">
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array(
                    'size' => 20, 
                    'maxlength' => 60, 
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 2
                )); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
            <td style="text-align: right">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'manualSaleInvoiceHeader.remaining'))); ?>
            </td>
            <td style="text-align: center; margin-left: 20%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]income_tax"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'income_tax')); ?>
                <?php echo CHtml::error($detail, 'income_tax'); ?>
            </td>
            <td style="text-align: center; margin-left: 20%">
                <?php echo CHtml::activeTextField($detail, "[$i]amount", array('maxLength' => 18, 'size' => 8,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $salePayment->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#amount_' . $i . '").html(data.amount);
                            $("#payment").html(data.payment);
                            $("#remaining").html(data.remaining);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1
                )); ?>
                <div id="amount_<?php echo $i; ?>" style="text-align: left; font-size: smaller; margin-left: 15px;">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'amount'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]account_id_additional_payment_1", CHtml::listData(Account::model()->findAll(array('condition' => 'account_category_id IN (7, 31)')), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
                <?php echo CHtml::error($detail, 'account_id_additional_payment_1'); ?>
            </td>
            <td style="text-align: center; margin-left: 20%">
                <?php echo CHtml::activeTextField($detail, "[$i]additional_payment_1", array('maxLength' => 18, 'size' => 8,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $salePayment->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#additional_payment_1").html(data.totalAdditionalPayment1);
                            $("#remaining").html(data.remaining);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1
                )); ?>
                <?php echo CHtml::error($detail, 'additional_payment_1'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]account_id_additional_payment_2", CHtml::listData(Account::model()->findAll(array('condition' => 'account_category_id IN (7, 31)')), 'id', 'name'), array('empty' => '-- Pilih --')); ?>
                <?php echo CHtml::error($detail, 'account_id_additional_payment_2'); ?>
            </td>
            <td style="text-align: center; margin-left: 20%">
                <?php echo CHtml::activeTextField($detail, "[$i]additional_payment_2", array('maxLength' => 18, 'size' => 8,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotal', array('id' => $salePayment->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#additional_payment_2").html(data.totalAdditionalPayment2);
                            $("#remaining").html(data.remaining);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1
                )); ?>
                <?php echo CHtml::error($detail, 'additional_payment_2'); ?>
            </td>
            <td style="width: 5%">
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $salePayment->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
                        ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td colspan="11" style="text-align: right; font-weight: bold">Total Piutang:</td>
        <td style="text-align: right; font-weight: bold">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalReceivable'))); ?>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr style="background-color: aquamarine">
        <td colspan="11" style="text-align: right; font-weight: bold">Total Pelunasan:</td>
        <td style="text-align: right;font-weight: bold">
            <span id="payment">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalPayment'))); ?>
            </span>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr style="background-color: aquamarine">
        <td colspan="11" style="text-align: right; font-weight: bold">Total Selisih Bayar 1</td>
        <td style="text-align: right; font-weight: bold">
            <span id="additional_payment_1">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'additional_payment_1'))); ?>
            </span>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr style="background-color: aquamarine"> 
        <td colspan="11" style="text-align: right; font-weight: bold">Total Selisih Bayar 2</td>
        <td style="text-align: right; font-weight: bold">
            <span id="additional_payment_2">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'additional_payment_2'))); ?>
            </span>
        </td>
        <td>&nbsp;</td>
    </tr>
    <tr style="background-color: aquamarine">
        <td colspan="11" style="text-align: right; font-weight: bold">Sisa:</td>
        <td style="text-align: right; font-weight: bold">
            <span id="remaining">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'remaining'))); ?>
            </span>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
