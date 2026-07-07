<table style="border: 1px solid">
	<tr style="background-color: skyblue">
<!--		<th style="text-align: center;">Code</th>-->
		<th style="text-align: center;">Width</th>
		<th style="text-align: center;">Height</th>
		<th style="text-align: center; width: 5%"></th>
	</tr>
	<?php foreach ($model->details as $i => $detail): ?>
		<tr>
			<!--code-->
<!--			<td style="text-align: center">
				<?php //echo CHtml::activeTextField($detail, "[$i]product_code", array('maxLength' => 20)); ?>
				<?php //echo CHtml::error($detail, 'code'); ?>
				<?php //echo CHtml::activeHiddenField($detail, "[$i]product_id");	?>
			</td>-->
			
			<!--width-->
			<td style="text-align: center">
				<?php echo CHtml::activeTextField($detail, "[$i]width", array('maxLength' => 13)); ?>
				<?php echo CHtml::error($detail, 'width'); ?>
			</td>	
			
			<!--height-->
			<td style="text-align: center">
				<?php
				echo CHtml::activeTextField($detail, "[$i]height", array('maxLength' => 20));	?>
				<?php echo CHtml::error($detail, 'height'); ?>
			</td>		
			
			<td>
				<?php if ($detail->isNewRecord): ?>
					<?php
					echo CHtml::button('Delete', array(
						'onclick' => CHtml::ajax(array(
							'type' => 'POST',
							'url' => CController::createUrl('ajaxHtmlRemoveDetail', array( 'id' => $model->header->id, 'index' => $i )),
							'update' => '#detail_div',
						)),
					));
					?>
				<?php else: ?>
					<?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array( ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive' )); ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>