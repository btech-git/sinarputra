<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; border-right: 2px solid" colspan="4">Awal</th>
        <th style="text-align: center;" colspan="4">Akhir</th>
        <th style="text-align: center; width: 5%">Weight</th>
        <th style="text-align: center; width: 3%;">M</th>
        <th style="text-align: center; width: 3%;">G</th>
        <th style="text-align: center; width: 3%;">FH</th>
        <th style="text-align: center; width: 3%;">ANNL</th>
        <th style="text-align: center; width: 3%;">SM</th>
        <th style="text-align: center; width: 15%">Harga</th>
        <th style="text-align: center; width: 15%">Total</th>
        <th style="width: 5%"></th>
    </tr>
    <tr style="background-color: skyblue">
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 3%;">Tbl/Dmtr</th>
        <th style="text-align: center; width: 3%;">Lbr/Dmtr</th>
        <th style="text-align: center; width: 3%; border-right: 2px solid;">Pjg</th>
        <th style="text-align: center; width: 3%;">Tbl/Dmtr</th>
        <th style="text-align: center; width: 3%;">Lbr</th>
        <th style="text-align: center; width: 3%;">Pjg/Dmtr</th>
        <th>Qty.</th>
        <th colspan="9"></th>
    </tr>

    <?php foreach ($purchase->purchaseDetailServices as $i => $detail): ?>
        <tr style="background-color: azure">
            <td style="text-align:center"><?php echo CHtml::activeTextField($detail, "[$i]name", array('size' => 40)); ?></td>


            <!--height initial-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]height_initial", array('size' => 5)); ?>
                <?php echo CHtml::error($detail, "[$i]height_initial"); ?>
            </td>

            <!--width initial-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]width_initial", array('size' => 5)); ?>
                <?php echo CHtml::error($detail, "[$i]width_initial"); ?>
            </td>

            <!--length initial-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]length_initial", array('size' => 5)); ?>
                <?php echo CHtml::error($detail, "[$i]length_initial"); ?>
            </td>

            <td><!--height-->
                <?php echo CHtml::activeTextField($detail, "[$i]height_final", array('size' => 5, 'maxLength' => 13)); ?>
                <?php echo CHtml::error($detail, 'height_final'); ?>
            </td>

            <td><!--width-->
                <?php echo CHtml::activeTextField($detail, "[$i]width_final", array('size' => 5, 'maxLength' => 13)); ?>
                <?php echo CHtml::error($detail, 'width_final'); ?>
            </td>	

            <td><!--length-->
                <?php
                echo CHtml::activeTextField($detail, "[$i]length_final", array('size' => 5, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
							$("#total_service_' . $i . '").html(data.total);
							$("#amount_span_' . $i . '").html(data.amount);
							$("#service_sub_total_span").html(data.serviceSubTotal);
							$("#service_tax_span").html(data.formattedServiceTax);
							$("#' . CHtml::activeId($purchase->header, 'service_tax') . '").val(data.serviceTax);
							$("#total_service_span").html(data.totalService);
							$("#all_detail_sub_total").html(data.allDetailSubTotal);
							$("#discount_amount").html(data.discountAmount);
							$("#total_before_tax").html(data.totalBeforeTax);
							$("#taxPercentage").html(data.taxPercentage);
							$("#taxValue").html(data.taxValue);
							$("#grand_total").html(data.grandTotal);
							}',
                    )),
                ));
                ?>
                <?php echo CHtml::error($detail, 'length_final'); ?>
            </td>	

            <td style="text-align: right">

                <?php
                echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 5, 'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
							$("#total_service_' . $i . '").html(data.total);
							$("#amount_span_' . $i . '").html(data.amount);
							$("#service_sub_total_span").html(data.serviceSubTotal);
							$("#service_tax_span").html(data.formattedServiceTax);
							$("#' . CHtml::activeId($purchase->header, 'service_tax') . '").val(data.serviceTax);
							$("#total_service_span").html(data.totalService);
							$("#all_detail_sub_total").html(data.allDetailSubTotal);
							$("#discount_amount").html(data.discountAmount);
							$("#total_before_tax").html(data.totalBeforeTax);
							$("#taxPercentage").html(data.taxPercentage);
							$("#taxValue").html(data.taxValue);
							$("#grand_total").html(data.grandTotal);
							}',
                    )),
                ));
                ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: right">

                <?php
                echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 5, 'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
							$("#total_service_' . $i . '").html(data.total);
							$("#amount_span_' . $i . '").html(data.amount);
							$("#service_sub_total_span").html(data.serviceSubTotal);
							$("#service_tax_span").html(data.formattedServiceTax);
							$("#' . CHtml::activeId($purchase->header, 'service_tax') . '").val(data.serviceTax);
							$("#total_service_span").html(data.totalService);
							$("#all_detail_sub_total").html(data.allDetailSubTotal);
							$("#discount_amount").html(data.discountAmount);
							$("#total_before_tax").html(data.totalBeforeTax);
							$("#taxPercentage").html(data.taxPercentage);
							$("#taxValue").html(data.taxValue);
							$("#grand_total").html(data.grandTotal);
							}',
                    )),
                ));
                ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: center"><!--is miling-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_miling"); ?>
                <?php echo CHtml::error($detail, 'is_miling'); ?>
            </td>

            <td style="text-align: center"><!--is Grinding-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_grinding"); ?>
                <?php echo CHtml::error($detail, 'is_grinding'); ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_hardness"); ?>
                <?php echo CHtml::error($detail, 'is_hardness'); ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_annelying"); ?>
                <?php echo CHtml::error($detail, 'is_annelying'); ?>
            </td>
            <td style="text-align: center"><!--is sidemiling-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_sidemiling"); ?>
                <?php echo CHtml::error($detail, 'is_sidemiling'); ?>
            </td>

            <td style="text-align:right">
                <?php
                echo CHtml::activeTextField($detail, "[$i]amount", array('size' => 15,
                    'onchange' =>
                    CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
						$("#total_service_' . $i . '").html(data.total);
						$("#amount_span_' . $i . '").html(data.amount);
						$("#service_sub_total_span").html(data.serviceSubTotal);
						$("#service_tax_span").html(data.formattedServiceTax);
						$("#' . CHtml::activeId($purchase->header, 'service_tax') . '").val(data.serviceTax);
						$("#total_service_span").html(data.totalService);
						$("#all_detail_sub_total").html(data.allDetailSubTotal);
						$("#discount_amount").html(data.discountAmount);
						$("#total_before_tax").html(data.totalBeforeTax);
						$("#taxPercentage").html(data.taxPercentage);
						$("#taxValue").html(data.taxValue);
						$("#grand_total").html(data.grandTotal);
					}',
                    )),
                ));
                ?>
                <span id="amount_span_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                </span>
            </td>

            <td style="text-align: right">
                <span id="total_service_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'totalService'))); ?>
                </span>
            </td>
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveService', array('id' => $purchase->header->id, 'index' => $i)),
                            'update' => '#service_div',
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