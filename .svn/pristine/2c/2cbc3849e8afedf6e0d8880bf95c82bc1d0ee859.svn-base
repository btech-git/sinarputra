<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">Company Name</th>
        <th style="text-align: center;">Position</th>
        <th style="text-align: center;">Period</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>
    <?php foreach ($model->detailExperiences as $i => $detail): ?>
        <tr>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]company_name", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'company_name'); ?>
            </td>	


            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]position", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'position'); ?>
            </td>
            
             <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]period", array('maxLength' => 60)); ?>
                <?php echo CHtml::error($detail, 'period'); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetailExperience', array('id' => $model->header->id, 'index' => $i)),
                            'update' => '#detail_experience',
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