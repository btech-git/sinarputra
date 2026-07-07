<h3>Service</h3>

<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 5%">No</th>
        <th style="text-align: center; width: 5%">Job Number</th>
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; border-right: 1px solid" colspan="4">Permintaan</th>
        <th style="text-align: center; border-left: 1px solid" colspan="4">Penawaran</th>
        <th style="text-align: center; width: 10%">Kategori</th>
        <th style="text-align: center; width: 5%">Berat</th>
        <th style="text-align: center; width: 3%;">M</th>
        <th style="text-align: center; width: 3%;">SM</th>
        <th style="text-align: center; width: 3%;">G</th>
        <th style="text-align: center; width: 3%;">HT</th>
        <th style="text-align: center; width: 3%;">NTD</th>
        <th style="text-align: center; width: 3%;">Potong</th>
        <th style="text-align: center; width: 3%;">kg/pcs</th>
        <th style="text-align: center; width: 10%">Harga Satuan</th>
        <th style="text-align: center; width: 15%">Total</th>
        <th style="width: 5%"></th>
    </tr>
    <tr style="background-color: skyblue">
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th style="text-align: center; width: 3%">Tbl</th>
        <th style="text-align: center; width: 3%">Lbr</th>
        <th style="text-align: center; width: 3%">Pjg</th>
        <th style="text-align: center; width: 3%; border-right: 1px solid">Qty</th>
        <th style="text-align: center; width: 3%; border-left: 1px solid">Tbl</th>
        <th style="text-align: center; width: 3%">Lbr</th>
        <th style="text-align: center; width: 3%">Pjg</th>
        <th style="text-align: center; width: 3%">Qty</th>
        <th colspan="12">&nbsp;</th>
    </tr>

    <?php foreach ($quotation->quotationDetailServices as $i => $detail): ?>
        <?php $tabIndex = $i * 11; ?>
        <tr style="background-color: azure">
            <td><?php echo $i + 1; ?></td>
            <td style="text-align:center">
                <?php echo CHtml::activeTextField($detail, "[$i]job_number", array(
                    'size' => 10, 
                    'maxLength' => 60, 
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 1
                )); ?>
            </td>
            <td style="text-align:center">
                <?php echo CHtml::activeTextField($detail, "[$i]product_name", array(
                    'size' => 20, 
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 2
                )); ?>
            </td>

            <td><!--height request-->
                <?php echo CHtml::activeTextField($detail, "[$i]height_request", array(
                    'size' => 5, 
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 3
                )); ?>
                <?php echo CHtml::error($detail, "[$i]height_request"); ?>
            </td>		

            <td><!--width request-->
                <?php echo CHtml::activeTextField($detail, "[$i]width_request", array(
                    'size' => 5, 
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 4
                )); ?>
                <?php echo CHtml::error($detail, "[$i]width_request"); ?>
            </td>

            <td><!--length request-->
                <?php echo CHtml::activeTextField($detail, "[$i]length_request", array(
                    'size' => 5, 
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 5
                )); ?>
                <?php echo CHtml::error($detail, "[$i]length_request"); ?>
            </td>

            <td style="border-right: 1px solid"><!--quantity-->
                <?php echo CHtml::activeTextField($detail, "[$i]quantity_request", array(
                    'size' => 5, 
                    'maxLength' => 10
                )); ?>
                <?php echo CHtml::error($detail, 'quantity_request'); ?>
            </td>

            <td style="border-left: 1px solid"><!--height quote-->
                <?php echo CHtml::activeTextField($detail, "[$i]height_quote", array(
                    'size' => 5, 
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#weight_span_' . $i . '").html(data.weight);
                            $("#total_' . $i . '").html(data.total);
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#product_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 6
                )); ?>
                <?php echo CHtml::error($detail, "[$i]height_quote"); ?>
            </td>		

            <td><!--width quote-->
                <?php echo CHtml::activeTextField($detail, "[$i]width_quote", array(
                    'size' => 5, 
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#weight_span_' . $i . '").html(data.weight);
                            $("#total_' . $i . '").html(data.total);
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#product_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 7
                )); ?>
                <?php echo CHtml::error($detail, "[$i]width_quote"); ?>
            </td>

            <td><!--length quote-->
                <?php echo CHtml::activeTextField($detail, "[$i]length_quote", array(
                    'size' => 5, 
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#weight_span_' . $i . '").html(data.weight);
                            $("#total_' . $i . '").html(data.total);
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#product_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 8
                )); ?>
                <?php echo CHtml::error($detail, "[$i]length_quote"); ?>
            </td>

            <td><!--quantity-->
                <?php echo CHtml::activeTextField($detail, "[$i]quantity_quote", array(
                    'size' => 5,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetTotalQuantity', array('id' => $quotation->header->id, 'flag' => 2)),
                        'success' => 'function(data) {
                            $("#total_quantity_service_span").html(data.totalQuantity);
                        }',
                    )) .
                    '
                    //update weight
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#weight_span_' . $i . '").html(data.weight);
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                        }
                    })
                    ',
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 9
                )); ?>
                <?php echo CHtml::error($detail, 'quantity_quote'); ?>
            </td>

            <!--product category-->
            <td style="text-align:center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_category_id", CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                    'empty' => '-Select Category-',
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#weight_span_' . $i . '").html(data.weight);
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            $("#total_' . $i . '").html(data.total);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 10
                )); ?>
                <?php echo CHtml::error($detail, 'product_category_id'); ?>
            </td>

            <td><!--weight-->
                <?php echo CHtml::activeTextField($detail, "[$i]weight", array(
                    'size' => 6,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#product_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 11
                )); ?>
                <?php echo CHtml::error($detail, "[$i]weight"); ?>
            </td>

            <td style="text-align: center"><!--is miling-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_miling"); ?>
                <?php echo CHtml::error($detail, 'is_miling'); ?>
            </td>

            <td style="text-align: center"><!--is sidemiling-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_sidemiling"); ?>
                <?php echo CHtml::error($detail, 'is_sidemiling'); ?>
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

            <td style="text-align: center"><!--is cutting-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_cutting"); ?>
                <?php echo CHtml::error($detail, 'is_cutting'); ?>
            </td>

            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]is_using_weight", array(
                    QuotationDetailService::IS_USING_WEIGHT => QuotationDetailService::IS_USING_WEIGHT_LITERAL, 
                    QuotationDetailService::IS_USING_QUANTITY => QuotationDetailService::IS_USING_QUANTITY_LITERAL
                ));?>
                <?php echo CHtml::error($detail, 'is_using_weight'); ?>
            </td>
            
            <td style="text-align:right"><!--unit price-->
                <?php echo CHtml::activeTextField($detail, "[$i]unit_price", array(
                    'size' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetServiceWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#service_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#service_total_span_' . $i . '").html(data.total);
                            $("#total_detail_service_span").html(data.totalDetailService);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 11
//				CHtml::ajax(array(
//					'type' => 'POST',
//					'dataType' => 'JSON',
//					'url' => CController::createUrl('ajaxJsonTotal', array('id' => $quotation->header->id, 'index' => $i)),
//					'success' => 'function(data) {
//						$("#sub_total").html(data.subTotal);
//						$("#taxValue").html(data.taxValue);
//						$("#discount_amount").html(data.discountAmount);
//						$("#total_before_tax").html(data.totalBeforeTax);
//						$("#grand_total").html(data.grandTotal);
//					}',
//				)),
                )); ?>
                <span id="service_unit_price_span_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                </span>
            </td>

            <td style="text-align: right"><!--total-->
                <span id="service_total_span_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $detail->total)); ?>
                </span>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveService', array('id' => $quotation->header->id, 'index' => $i)),
                            'update' => '#detail_service_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

    <tr style="background-color: aquamarine">
        <td style="font-weight: bold; text-align: right" colspan="10">Total Quantity: </td>
        <td style="text-align: center">
            <span id="total_quantity_service_span">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quotation->getTotalQuantity(2))); ?>
            </span>
        </td>
        <td style="text-align: right" colspan="11">
            <span id="total_detail_service_span">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotation->header, 'totalDetailService'))); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>