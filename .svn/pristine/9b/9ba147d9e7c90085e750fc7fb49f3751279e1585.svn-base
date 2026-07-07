<table style="border: 1px solid">
    <thead>
        <tr style="background-color: skyblue">
            <th style="text-align: center">GRADE</th>
            <th style="text-align: center; width: 10%">Kategori</th>
            <th style="text-align: center; width: 10%">Tbl/Dmtr</th>
            <th style="text-align: center; width: 10%">Lbr/Dmtr</th>
            <th style="text-align: center; width: 10%">Pjg</th>
            <th style="text-align: center; width: 3%;">M</th>
            <th style="text-align: center; width: 3%;">SM</th>
            <th style="text-align: center; width: 3%;">G</th>
            <th style="text-align: center; width: 3%;">HT</th>
            <th style="text-align: center; width: 3%;">NTD</th>
            <th style="text-align: center; width: 10%">Qty Kirim</th>
            <th style="text-align: center; width: 10%">Berat</th>
            <th style="text-align: center; width: 5%"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($delivery->details as $i => $detail): ?>
            <tr style="background-color: azure;">
                <td><!--nama barang-->
                    <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]grade_name"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'grade_name')); ?>
                    <?php echo CHtml::error($detail, 'grade_name'); ?>
                </td>

                <!--product category-->
                <td style="text-align:center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_category_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
                    <?php echo CHtml::error($detail, 'product_category_id'); ?>
                </td>

                <!--height-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]height"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'height')); ?>
                    <?php echo CHtml::error($detail, 'height'); ?>
                </td>

                <!--width-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'width')); ?>
                    <?php echo CHtml::error($detail, 'width'); ?>
                </td>

                <!--length-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]length"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'length')); ?>
                    <?php echo CHtml::error($detail, 'length'); ?>
                </td>

                <td style="text-align: center"><!--is miling-->
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_miling"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_miling') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_miling'); ?>
                </td>

                <td style="text-align: center"><!--is sidemiling-->
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_sidemiling"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_sidemiling') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_sidemiling'); ?>
                </td>

                <td style="text-align: center"><!--is Grinding-->
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_grinding"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_grinding') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_grinding'); ?>
                </td>

                <td style="text-align: center"><!--is hardness-->
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_hardness"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_hardness') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_hardness'); ?>
                </td>

                <td style="text-align: center"><!--is annelying-->
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_annelying"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_annelying') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_annelying'); ?>
                </td>

                <!--quantity-->
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 5, 'maxLength' => 10,
                        'empty' => '-Select Category-',
                        'onchange' => '
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonGetTotalQuantityWeight', array('id' => $delivery->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#total_quantity_span").html(data.totalQuantity);
                                }
                            })
                        ',
                    )); ?>
                    <?php echo CHtml::error($detail, 'quantity'); ?>
                </td>    

                <!--weight-->
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 10, 'maxLength' => 10,
                        'empty' => '-Select Category-',
                        'onchange' => '
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonGetTotalQuantityWeight', array('id' => $delivery->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#total_weight_span").html(data.totalWeight);
                                }
                            })
                        ',
                    )); ?>
                    <?php echo CHtml::error($detail, 'weight'); ?>
                </td>

                <td>
                    <?php if ($detail->isNewRecord): ?>
                        <?php echo CHtml::button('Delete', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $delivery->header->id, 'index' => $i)),
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
    </tbody>
    <tfoot>
        <tr style="background-color: greenyellow">
            <td style="font-weight: bold; text-align: right" colspan="10">Total</td>
            <td style="font-weight: bold; text-align: center">
                <span id="total_quantity_span">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $delivery->totalQuantity)); ?>
                </span>
            </td>
            <td style="font-weight: bold; text-align: center">
                <span id="total_weight_span">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', $delivery->totalWeight)); ?>
                </span>
            </td>
            <td>&nbsp;</td>
        </tr>
    </tfoot>
</table>