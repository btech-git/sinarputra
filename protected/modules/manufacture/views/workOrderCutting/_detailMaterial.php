<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th colspan="8" style="text-align: center; border-right: 1px solid; border-bottom: 1px solid">Material Awal</th>
        <th colspan="8" style="text-align: center; border-left: 1px solid; border-bottom: 1px solid">Sisa Potong</th>
        <th></th>
    </tr>
    <tr style="background-color: skyblue">
        <th style="text-align: center;">GRADE</th>
        <th style="text-align: center;">Category</th>
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">Location</th>
        <th style="text-align: center; border-right: 1px solid">Qty Order</th>
        <th style="text-align: center; border-left: 1px solid">Category</th>	
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">Toleransi</th>
        <th style="text-align: center;">Location</th>
        <th style="text-align: center;">Tipe</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php //$count = count($model->detailStocks); ?>
    <?php foreach ($model->detailOffCuts as $i => $detail): ?>
        <tr>
            <?php $detailTransaction = !empty($detail->work_order_cutting_detail_material_id) ? $detail->workOrderCuttingDetailMaterial : $detail->receiveDetail; ?> 
            <td style="text-align: center;">
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]receive_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_material_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'product_name')); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'productCategory.name')); ?>
            </td>

            <!--height-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'height')); ?>
            </td>

            <!--width order-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'width')); ?>
            </td>

            <!--length awal-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'length')); ?>
            </td>

            <!--weight-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'weight')); ?>
            </td>

            <!--location-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'location.name')); ?>
            </td>
            
            <td style="text-align: center; border-right: 1px solid">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 3, 'maxLength' => 10)); ?>
            </td>
            
            <td style="text-align: center; border-left: 1px solid">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_category_id", CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                    'empty' => '-- Category --',
                    'onchange' => 'if ($(this).val() == 1) 
                        {
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", true);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", true);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_length").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", true);
                        }
                        else if ($(this).val() == 2)
                        {
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", true);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").val(0);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_length").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", true);
                        }
                        else if ($(this).val() == 3)
                        {
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_length").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", true);
                        }
                        else
                        {
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_length").attr("readonly", false);
                            $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", false);
                        }
                    ' .
                    CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                        }',
                    )),
                ));
                ?>
                <?php echo CHtml::error($detail, 'is_offcart'); ?>
            </td>
            
            <?php if ($detail->is_offcart) : ?>
                <td style="text-align: center;"><!--height-->
                    <?php echo CHtml::activeTextField($detail, "[$i]height", array('size' => 5,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            }',
                        )),
                        'readonly' => ((int)$detail->product_category_id !== 2 && (int)$detail->product_category_id !== 3 && (int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'height'); ?>
                </td>

                <td style="text-align: center;"><!--width order-->
                    <?php echo CHtml::activeTextField($detail, "[$i]width", array('size' => 5, 'class' => 'TabOnEnter',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);    
                            }',
                        )),
                        'readonly' => ((int)$detail->product_category_id !== 3 && (int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'width'); ?>
                </td>

                <td style="text-align: center;"><!--length awal-->
                    <?php echo CHtml::activeTextField($detail, "[$i]length", array('size' => 5, 'class' => 'TabOnEnter',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            }',
                        )),
                        'readonly' => ((int)$detail->product_category_id !== 1 && (int)$detail->product_category_id !== 2 && (int)$detail->product_category_id !== 3 && (int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'length'); ?>
                </td>

                <td style="text-align: center;"><!--weight-->
                    <?php echo CHtml::activeTextField($detail, "[$i]weight", array(
                        'size' => 5,
                        'readonly' => ((int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'weight'); ?>
                </td>
            <?php else : ?>
                <td style="text-align: center;"><!--height-->
                    <?php echo CHtml::activeTextField($detail, "[$i]height", array('size' => 5,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                            }',
                        )),
                        'readonly' => ((int)$detail->product_category_id !== 2 && (int)$detail->product_category_id !== 3 && (int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'height'); ?>
                </td>

                <td style="text-align: center;"><!--width order-->
                    <?php echo CHtml::activeTextField($detail, "[$i]width", array('size' => 5,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);       
                            }',
                        )),
                        'readonly' => ((int)$detail->product_category_id !== 3 && (int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'width'); ?>
                </td>

                <td style="text-align: center;"><!--length awal-->
                    <?php echo CHtml::activeTextField($detail, "[$i]length", array('size' => 5,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);        
                            }',
                        )),
                        'readonly' => ((int)$detail->product_category_id !== 1 && (int)$detail->product_category_id !== 2 && (int)$detail->product_category_id !== 3 && (int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'length'); ?>
                </td>

                <td style="text-align: center;"><!--weight-->
                    <?php echo CHtml::activeTextField($detail, "[$i]weight", array(
                        'size' => 5,
                        'readonly' => ((int)$detail->product_category_id !== 4),
                    )); ?>
                    <?php echo CHtml::error($detail, 'weight'); ?>
                </td>
            <?php endif; ?>

            <td style="text-align: center;"><!--toleransi-->
                <?php echo CHtml::activeTextField($detail, "[$i]weight_tolerance", array('size' => 5)); ?>
                <?php echo CHtml::error($detail, 'weight_tolerance'); ?>
            </td>


            <td style="text-align: center;"><!--location-->
                <?php echo CHtml::activeDropDownList($detail, "[$i]location_id", CHtml::listData(Location::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => '-Location-'
                )); ?>
                <?php echo CHtml::error($detail, 'location_id'); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]material_type", array(
                    WorkOrderCuttingDetailMaterial::REMAINING => WorkOrderCuttingDetailMaterial::REMAINING_LITERAL,
                    WorkOrderCuttingDetailMaterial::SLICE => WorkOrderCuttingDetailMaterial::SLICE_LITERAL
                )); ?>
            </td>

            <td>
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('ajaxHtmlRemoveDetailMaterial', array('id' => $model->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>