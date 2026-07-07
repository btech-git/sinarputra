<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <?php if (!$receive->header->isNewRecord): ?>
            <th style="text-align: center; width: 5%">Serial Number</th>
        <?php endif; ?>
        <th style="text-align: center">Nama Barang</th>
        <th style="text-align: center; width: 10%">Kategori</th>
        <th style="text-align: center; width: 10%">Tbl/Dmtr</th>
        <th style="text-align: center; width: 10%">Lbr</th>
        <th style="text-align: center; width: 10%">Pjg</th>
        <th style="text-align: center; width: 10%">Packing List (kg)</th>
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 10%">HRC</th>
        <th style="text-align: center; width: 10%">Number Heat</th>
        <th style="text-align: center;">Location</th>
        <th style="text-align: center;">Memo</th>
        <th style="width: 5%"></th>
    </tr>

    <?php foreach ($receive->details as $i => $detail): ?>
        <?php $tabIndex = $i * 4; ?>
        <tr style="background-color: azure">
            <?php if (!$receive->header->isNewRecord): ?>
                <td style="text-align: center">
                    <?php echo CHtml::encode(CHtml::value($detail, 'serial_number')); ?>
                </td>
            <?php endif; ?>
                
            <?php if ($receive->header->receiving_type == ReceiveHeader::LOCAL): ?>
                <!--nama barang-->
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]purchase_detail_id"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                </td>

                <!--kategory-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_category_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
                </td>

                <!--height-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]height"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?>
                    <?php echo CHtml::error($detail, 'height'); ?>
                </td>

                <!--width-->
                <td style="text-align: center">
                    <?php if($detail->product_category_id != 2) : ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?>
                    <?php echo CHtml::error($detail, 'width'); ?>
                    <?php endif; ?>
                </td>

                <!--length-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]length"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?>
                    <?php echo CHtml::error($detail, 'length'); ?>
                </td>
                
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]weight_packing", array('size' => 5, 'maxLength' => 10)); ?>
                    <?php echo CHtml::error($detail, 'weight_packing'); ?>
                </td>

                <!--weight-->
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]weight"); ?>
                    <?php //echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?>
                    <?php echo CHtml::error($detail, 'weight'); ?>
                </td>
                
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]hardness_scale", array('size' => 5, 'maxLength' => 20)); ?>
                    <?php echo CHtml::error($detail, 'hardness_scale'); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]number_heat", array('size' => 5, 'maxLength' => 20)); ?>
                    <?php echo CHtml::error($detail, 'number_heat'); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::activeDropDownList($detail, "[$i]location_id", CHtml::listData(Location::model()->findAll(), 'id', 'name'), array(
                        'empty' => '-Select Location-'
                    )); ?>
                    <?php echo CHtml::error($detail, 'location_id'); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]memo"); ?>
                    <?php echo CHtml::error($detail, 'memo'); ?>
                </td>

            <?php else : ?>
                <!--product-->
                <td>
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeTextField($detail, "[$i]product_name"); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'product_name'); ?>
                </td>

                <!--category-->
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_category_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
                    <?php echo CHtml::error($detail, 'product_category_id'); ?>
                </td>

                <!--height-->
                <td style="text-align: center">
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]height"); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeTextField($detail, "[$i]height", array(
                            'size' => 5, 
                            'maxLength' => '10',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $receive->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#weight_span_' . $i . '").html(data.weight);
                                    $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                }',
                            )),
                        )); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'height'); ?>
                </td>

                <!--width-->
                <td style="text-align: center">
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]width"); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeTextField($detail, "[$i]width", array(
                            'size' => 5, 
                            'maxLength' => '10',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $receive->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#weight_span_' . $i . '").html(data.weight);
                                    $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                }',
                            )),
                        )); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'width'); ?>
                </td>

                <!--length-->
                <td style="text-align: center">
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]length"); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeTextField($detail, "[$i]length", array(
                            'size' => 5, 
                            'maxLength' => '10',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonGetProductWeightRequest', array('id' => $receive->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#weight_span_' . $i . '").html(data.weightFormatted);
                                    $("#' . CHtml::activeId($detail, "[$i]weight") . '").val(data.weight);
                                }',
                            )),
                        )); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'length'); ?>
                </td>
                
                <td style="text-align: right">
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]weight_packing"); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight_packing'))); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeTextField($detail, "[$i]weight_packing", array('size' => 5, 'maxLength' => 10)); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'weight_packing'); ?>
                </td>

                <!--weight-->
                <td style="text-align: right">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                    <span id="weight_span_<?php echo $i; ?>">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?>
                    </span>
                    <?php echo CHtml::error($detail, 'weight'); ?>
                </td>
                
                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]hardness_scale", array('size' => 5, 'maxLength' => 20)); ?>
                    <?php echo CHtml::error($detail, 'hardness_scale'); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::activeTextField($detail, "[$i]number_heat", array('size' => 5, 'maxLength' => 20)); ?>
                    <?php echo CHtml::error($detail, 'number_heat'); ?>
                </td>

                <td>
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]location_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'location.name')); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeDropDownList($detail, "[$i]location_id", CHtml::listData(Location::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-Select Location-'
                        )); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'location_id'); ?>
                </td>
                <td>
                    <?php if ($receive->header->isNewRecord): ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]memo"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?>
                    <?php else: ?> 
                        <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 20)); ?>
                    <?php endif; ?>
                    <?php echo CHtml::error($detail, 'memo'); ?>
                </td>
            <?php endif; ?>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $receive->header->id, 'index' => $i)),
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
</table>