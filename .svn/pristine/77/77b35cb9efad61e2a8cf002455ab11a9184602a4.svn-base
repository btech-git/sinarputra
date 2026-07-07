<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%;">GRADE</th>
        <th style="text-align: center; width: 10%;">Kategori</th>
        <th style="text-align: center; width: 10%;">Tbl/Dmtr</th>
        <th style="text-align: center; width: 10%;">Lbr/Dmtr</th>
        <th style="text-align: center; width: 10%;">Pjg</th>
        <th style="text-align: center; width: 5%;">Qty.</th>		
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 15%">Harga</th>
        <th style="text-align: center; width: 15%">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php foreach ($purchase->details as $i => $detail): ?>
        <?php $tabIndex = $i * 8; ?>
        <tr>
            <!--nama barang-->
            <?php if ($detail->work_order_cutting_detail_id != NULL): ?>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_category_id"); ?>
                </td>
            <?php else: ?>
                <td>
                    <?php echo CHtml::activeTextField($detail, "[$i]product_name", array(
                        'size' => 10, 
                        'maxLength' => 60, 
                        'class' => 'TabOnEnter', 
                        'tabindex' => $tabIndex + 1,
                    )); ?>
                </td>
                <!--product category -->
                <td style="text-align:center">
                    <?php echo CHtml::activeDropDownList($detail, "[$i]product_category_id", CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                        'empty' => '-Select Category-',
                        'onchange' => ' if ($(this).val() == 2) {
                            $("#PurchaseDetail_' . $i . '_height").attr("readonly", false);
                            $("#PurchaseDetail_' . $i . '_width").attr("readonly", true);
                            $("#PurchaseDetail_' . $i . '_width").val(0);
                            $("#PurchaseDetail_' . $i . '_weight").attr("readonly", false)
                        } else {
                            $("#PurchaseDetail_' . $i . '_height").attr("readonly", false);
                            $("#PurchaseDetail_' . $i . '_width").attr("readonly", false);
                            $("#PurchaseDetail_' . $i . '_weight").attr("readonly", false)
                        }
			' .
                        CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'data' => 'js:$(form).serialize()',
                            'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);
                            }',
                        )),
                        'class' => 'TabOnEnter',
                        'tabindex' => $tabIndex + 2
                    )); ?>
                    <?php echo CHtml::error($detail, 'product_category_id'); ?>
                </td>
            <?php endif; ?>

            <!--height-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]height", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#PurchaseDetail_' . $i . '_weight").html(data.weight);
                            $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 3,
                )); ?>
                <?php echo CHtml::error($detail, 'height'); ?>
            </td>

            <!--width-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]width", array(
                    'size' => 5, 
                    'maxLength' => 10, 
                    'readonly' => $detail->product_category_id == 2 ? 'TRUE' : 'FALSE',
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#PurchaseDetail_' . $i . '_weight").val(data.weight);
                            $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);    
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 4,
                )); ?>
                <?php echo CHtml::error($detail, 'width'); ?>
            </td>	

            <!--length-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]length", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#PurchaseDetail_' . $i . '_weight").val(data.weight);
                            $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);    
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 5,
                )); ?>
                <?php echo CHtml::error($detail, 'length'); ?>
            </td>		

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#PurchaseDetail_' . $i . '_weight").val(data.weight);
                            $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);    
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 6,
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]weight", array(
                    'size' => 5, 
                    'maxLength' => 10,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);    
                            $("#all_detail_sub_total").html(data.subTotal);
                            $("#discount_amount").html(data.discountAmount);
                            $("#tax_value").html(data.taxValue);
                            $("#tax_income_value").html(data.taxIncomeValue);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 7,
                ));
                ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: right">
                <?php
                echo CHtml::activeTextField($detail, "[$i]unit_price", array(
                    'size' => 10, 
                    'maxLength' => 18,
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonTotalByWeight', array('id' => $purchase->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#total_' . $i . '").html(data.total);
                            $("#' . CHtml::activeId($detail, 'weight') . '").val(data.weight);    
                            $("#all_detail_sub_total").html(data.subTotal);
                            $("#discount_amount").html(data.discountAmount);
                            $("#tax_value").html(data.taxValue);
                            $("#tax_income_value").html(data.taxIncomeValue);
                            $("#grand_total").html(data.grandTotal);
                        }',
                    )),
                    'class' => 'TabOnEnter',
                    'tabindex' => $tabIndex + 8,
                ));
                ?>
                <div id="amount_<?php echo $i; ?>" style="text-align: right;">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                </div>
                <?php echo CHtml::error($detail, 'unit_price'); ?>
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
                            'url' => CController::createUrl('ajaxHtmlRemoveProduct', array('id' => $purchase->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>