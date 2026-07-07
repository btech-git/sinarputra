<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">Education Background</th>
        <th style="text-align: center;">Major</th>
        <th style="text-align: center;">Description</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($model->detailEducations as $i => $detail): ?>
        <tr>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]educational_background", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'educational_background'); ?>
            </td>	


            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]major", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'major'); ?>
            </td>

           
            <td>	
                <?php echo CHtml::activeTextArea($detail, "[$i]description", array('rows' => 6, 'cols' => 50)); ?>
                <?php echo CHtml::error($detail, 'description'); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetailEducation', array('id' => $model->header->id, 'index' => $i)),
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