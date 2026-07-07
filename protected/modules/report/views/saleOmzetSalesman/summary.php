<?php
Yii::app()->clientScript->registerScript('report', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");

');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="hide">
    <div class="form" style="text-align: center">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('Save To Excel', array('name' => 'SaveToExcel')); ?>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>

<div>
    <?php $this->renderPartial('_summary', array('data' => $data, 'records' => $records)); ?>
</div>
