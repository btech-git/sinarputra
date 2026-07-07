<h3>Product</h3>

<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 5%">No</th>
        <th style="text-align: center; width: 5%">Job Number</th>
        <th style="text-align: center; border-right: 2px solid" colspan="5">Permintaan</th>
        <th style="text-align: center;" colspan="5">Penawaran</th>
        <th style="text-align: center; width: 10%">Kategori</th>
        <th style="text-align: center; width: 5%">Berat</th>
        <th style="text-align: center; width: 3%;">M</th>
        <th style="text-align: center; width: 3%;">SM</th>
        <th style="text-align: center; width: 3%;">G</th>
        <th style="text-align: center; width: 3%;">HT</th>
        <th style="text-align: center; width: 3%;">NTD</th>
        <th style="text-align: center; width: 3%;">COA</th>
        <th style="text-align: center; width: 3%;">kg/pcs</th>
        <th style="text-align: center; width: 10%">Harga Satuan</th>
        <th style="text-align: center; width: 10%">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <tr style="background-color: skyblue">
        <th colspan="2">&nbsp;</th>
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 3%;">Tbl/Dmtr</th>
        <th style="text-align: center; width: 3%;">Lbr/Dmtr</th>
        <th style="text-align: center; width: 3%;">Pjg</th>
        <th style="text-align: center; width: 3%;border-right: 2px solid;">Qty.</th>
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 3%;">Tbl/Dmtr</th>
        <th style="text-align: center; width: 3%;">Lbr/Dmtr</th>
        <th style="text-align: center; width: 3%;">Pjg</th>
        <th style="text-align: center; width: 3%;">Qty.</th>
        <th colspan="12">&nbsp;</th>
    </tr>

    <?php foreach ($quotation->quotationDetailProducts as $i => $detail): ?>
        <?php $tabIndex = $i * 13; ?>
        <tr style="background-color: azure">
            <td><?php echo $i + 1; ?></td>
            <td style="text-align:center">
                <?php echo CHtml::activeTextField($detail, "[$i]job_number", array('size' => 10, 'maxLength' => 60, 'class' => 'TabOnEnter', 'tabindex' => $tabIndex + 1)); ?>
            </td>
            <!--product name request-->
            <td style="text-align:center">
                <?php echo CHtml::activeTextField($detail, "[$i]product_name_request", array('size' => 10, 'maxLength' => 60, 'class' => 'TabOnEnter', 'tabindex' => $tabIndex + 2)); ?>
            </td>

            <!--height request-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]height_request", array('size' => 5, 'class' => 'TabOnEnter', 'tabindex' => $tabIndex + 3)); ?>
                <?php echo CHtml::error($detail, "[$i]height_request"); ?>
            </td>

            <!--width request-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]width_request", array('size' => 5, 'class' => 'TabOnEnter', 'tabindex' => $tabIndex + 4)); ?>
                <?php echo CHtml::error($detail, "[$i]width_request"); ?>
            </td>

            <!--length request-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]length_request", array('size' => 5, 'class' => 'TabOnEnter', 'tabindex' => $tabIndex + 5)); ?>
                <?php echo CHtml::error($detail, "[$i]length_request"); ?>
            </td>

            <!--quantity request-->
            <td style="border-right: 2px solid;">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity_request", array(
                    'size' => 5,
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 6
                )); ?>
                <?php echo CHtml::error($detail, 'quantity_request'); ?>
            </td>

            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]product_name_quote", array('value' => CHtml::value($detail, 'product.name'), 'size' => 10, 'maxLength' => 60, 'class' => 'TabOnEnter', 'tabindex' => $tabIndex + 7)); ?>
            </td>

            <!--height quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]height_quote", array('size' => 5,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
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
                <?php echo CHtml::error($detail, "[$i]height_quote"); ?>
            </td>

            <td><!--width quote-->
                <?php echo CHtml::activeTextField($detail, "[$i]width_quote", array('size' => 5,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
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
                    'tabindex' => $tabIndex + 9
                )); ?>
                <?php echo CHtml::error($detail, "[$i]width_quote"); ?>
            </td>

            <td><!--length quote-->
                <?php echo CHtml::activeTextField($detail, "[$i]length_quote", array('size' => 5,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
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
                    'tabindex' => $tabIndex + 10
                )); ?>
                <?php echo CHtml::error($detail, "[$i]length_quote"); ?>
            </td>

            <!--quantity quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]quantity_quote", array('size' => 5,
                    'onchange' =>
                    //update total quantity
                    CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetTotalQuantity', array('id' => $quotation->header->id, 'flag' => 1)),
                        'success' => 'function(data) {
                            $("#total_quantity_product_span").html(data.totalQuantity);
                        }',
                    )) .
                    '
                    //update weight
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#weight_span_' . $i . '").html(data.weight);
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                        }
                    })
                    ' .
                    CHtml::ajax(array(
                        'type' => 'GET',
                        'url' => CController::createUrl('ajaxJsonCodeNumber', array('id' => $quotation->header->id)),
                        'success' => 'function(data) {
                            $("#quotation_header_code_number").html(data.codeNumber);
                        }
                        ',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 11
                )); ?>
                <?php echo CHtml::error($detail, 'quantity_quote'); ?>
            </td>

            <!--product category-->
            <td style="text-align:center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_category_id", CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                    'empty' => '-Select Category-',
                    'onchange' => '
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)) . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#weight_span_' . $i . '").html(data.weight);
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                $("#total_' . $i . '").html(data.total);
                                $("#total_detail_product_span").html(data.totalDetailProduct);
                                $("#grand_total").html(data.grandTotal);
                            }
                        })
                    ',
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 12
                )); ?>
                <?php echo CHtml::error($detail, 'product_category_id'); ?>
            </td>

            <td><!--weight-->
                <?php echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 5, 'maxLength' => 20,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#product_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 13
                )); ?>
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
            
            <td style="text-align: center"><!--is coating-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_coating"); ?>
                <?php echo CHtml::error($detail, 'is_coating'); ?>
            </td>
            
            <td>
                <?php echo CHtml::activeDropDownList($detail, "[$i]is_using_weight", array(
                    QuotationDetailProduct::IS_USING_WEIGHT => QuotationDetailProduct::IS_USING_WEIGHT_LITERAL, 
                    QuotationDetailProduct::IS_USING_QUANTITY => QuotationDetailProduct::IS_USING_QUANTITY_LITERAL
                ));?>
                <?php echo CHtml::error($detail, 'is_using_weight'); ?>
            </td>
            <td style="text-align: right">
                <?php echo CHtml::activeTextField($detail, "[$i]unit_price", array('size' => 10, 'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $quotation->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#product_unit_price_span_' . $i . '").html(data.unitPrice);
                            $("#total_detail_product_span").html(data.totalDetailProduct);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 14
                )); ?>

                <?php echo CHtml::error($detail, 'unit_price'); ?>

                <span id="product_unit_price_span_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'unit_price'))); ?>
                </span>
            </td>
            <td style="text-align: right">
                <span id="total_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'total'))); ?>
                </span>
            </td>
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveProduct', array('id' => $quotation->header->id, 'index' => $i)),
                            'update' => '#detail_product_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
        
    <tr style="background-color: aquamarine">
        <td colspan="11" style="font-weight: bold; text-align: right">Total Quantity:</td>
        <td style="text-align: center">
            <span id="total_quantity_product_span">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $quotation->getTotalQuantity(1))); ?>
            </span>
        </td>
        <td style="font-weight: bold; text-align: right" colspan="10">Total:</td>
        <td style="text-align: right">
            <span id="total_detail_product_span">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotation, 'totalDetailProduct'))); ?>
            </span>
        </td>
        <td></td>
    </tr>
</table>
