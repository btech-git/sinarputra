<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">NIK Keluarga</th>
        <th style="text-align: center;">Relationship</th>
        <th style="text-align: center;">Phone</th>
        <th style="text-align: center;">Address</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($model->detailRelationships as $i => $detail): ?>
        <tr>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]name", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'name'); ?>
            </td>	


            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]relationship", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'relationship'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]phone", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'phone'); ?>
            </td>

            <td>	
                <?php echo CHtml::activeTextArea($detail, "[$i]address", array('rows' => 6, 'cols' => 50)); ?>
                <?php echo CHtml::error($detail, 'address'); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetailRelationship', array('id' => $model->header->id, 'index' => $i)),
                            'update' => '#detail_relationship',
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