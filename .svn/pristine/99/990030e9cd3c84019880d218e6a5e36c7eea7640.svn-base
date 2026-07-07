<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">Sisa Potong</th>
        <th style="text-align: center;">GRADE</th>		
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">Toleransi</th>
        <th style="text-align: center;">Location</th>
        <th style="text-align: center;">Qty</th>
        <th style="text-align: center;">Tipe</th>
        <th style=" width: 5%"></th>

    </tr>
    <?php if ($model->detailOffCuts): ?>
        <?php foreach ($model->detailOffCuts as $i => $detail): ?>
            <?php //if ($detail->receive_detail_id == $receiveDetailId) : ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]product_category_id", CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                            'onchange' => 'if ($(this).val() == 1) 
                                {
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", true);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", true);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", true)
                                }
                                else if ($(this).val() == 2)
                                {
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", false);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", true);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").val(0);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", false)
                                }else
                                {
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_height").attr("readonly", false);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_width").attr("readonly", false);
                                    $("#WorkOrderCuttingDetailMaterial_' . $i . '_weight").attr("readonly", false)
                                }
                            ' .
                            CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#weight_span_' . $i . '").html(data.weight);
                                }',
                            )),
                        ));
                        ?>
                        <?php echo CHtml::error($detail, 'is_offcart'); ?>
                    </td>
                    <td style="text-align: center;"><!--name-->
                        <?php echo CHtml::activeHiddenField($detail, "[$i]receive_detail_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_material_id"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]index"); ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                        <?php echo CHtml::encode($detail->product_name); ?>
                    </td>
                    <?php if ($detail->is_offcart) : ?>
                        <td style="text-align: center;"><!--height-->
                            <?php
                            echo CHtml::activeTextField($detail, "[$i]height", array('size' => 5,
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#weight_span_' . $i . '").html(data.weight);
                                        $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                    }',
                                )),
                            ));
                            ?>
                            <?php echo CHtml::error($detail, 'height'); ?>
                        </td>

                        <td style="text-align: center;"><!--width order-->
                            <?php
                            echo CHtml::activeTextField($detail, "[$i]width", array('size' => 5, 'class' => 'TabOnEnter',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#weight_span_' . $i . '").html(data.weight);
                                        $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);    
                                    }',
                                )),
                            ));
                            ?>
                            <?php echo CHtml::error($detail, 'width'); ?>
                        </td>

                        <td style="text-align: center;"><!--length awal-->
                            <?php
                            echo CHtml::activeTextField($detail, "[$i]length", array('size' => 5, 'class' => 'TabOnEnter',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#weight_span_' . $i . '").html(data.weight);
                                        $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                    }',
                                )),
                            ));
                            ?>
                            <?php echo CHtml::error($detail, 'length'); ?>
                        </td>

                        <td style="text-align: center;"><!--weight-->
                            <span id="weight_span_<?php echo $i; ?>">
                                <?php echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 5)); ?>
                            </span>
                            <?php echo CHtml::error($detail, 'weight'); ?>
                        </td>
                    <?php else : ?>

                        <td style="text-align: center;"><!--height-->
                            <?php
                            echo CHtml::activeTextField($detail, "[$i]height", array('size' => 5,
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#weight_span_' . $i . '").html(data.weight);
                                        $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                    }',
                                )),
                                'readonly' => true
                            ));
                            ?>
                            <?php echo CHtml::error($detail, 'height'); ?>
                        </td>

                        <td style="text-align: center;"><!--width order-->
                            <?php
                            echo CHtml::activeTextField($detail, "[$i]width", array('size' => 5,
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#weight_span_' . $i . '").html(data.weight);
                                        $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);       
                                    }',
                                )),
                                'readonly' => true
                            ));
                            ?>
                            <?php echo CHtml::error($detail, 'width'); ?>
                        </td>

                        <td style="text-align: center;"><!--length awal-->
                            <?php
                            echo CHtml::activeTextField($detail, "[$i]length", array('size' => 5,
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'dataType' => 'JSON',
                                    'url' => CController::createUrl('ajaxJsonGetProductWeight', array('id' => $model->header->id, 'index' => $i)),
                                    'success' => 'function(data) {
                                        $("#weight_span_' . $i . '").html(data.weight);
                                        $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);        
                                    }',
                                )),
                            ));
                            ?>
                            <?php echo CHtml::error($detail, 'length'); ?>
                        </td>

                        <td style="text-align: center;"><!--weight-->
                            <span id="weight_span_<?php echo $i; ?>">
                                <?php
                                echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 5,
                                    'readonly' => true
                                ));
                                ?>
                            </span>
                            <?php echo CHtml::error($detail, 'weight'); ?>
                        </td>
                    <?php endif; ?>

                    <td style="text-align: center;"><!--toleransi-->
                        <?php echo CHtml::activeTextField($detail, "[$i]weight_tolerance", array('size' => 5)); ?>
                        <?php echo CHtml::error($detail, 'length'); ?>
                    </td>


                    <td style="text-align: center;"><!--location-->
                        <?php
                        echo CHtml::activeDropDownList($detail, "[$i]location_id", CHtml::listData(Location::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-Location-'
                        ));
                        ?>
                        <?php echo CHtml::error($detail, 'location_id'); ?>
                    </td>

                    <td style="text-align: center;"><!--qty order-->
                        <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 5)); ?>
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
                                'update' => '#detail_offCart',
                            )),
                        )); ?>
                    </td>
                </tr>
            <?php //endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</table>