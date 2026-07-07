<?php
Yii::app()->clientScript->registerScript('report', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="hide">
    <div class="form" style="text-align: center">
        <?php echo CHtml::beginForm(array(''), 'get'); ?>
        <div class="row">
            Tanggal Mulai
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'StartDate',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                ),
            )); ?>

            Sampai
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'EndDate',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                ),
            )); ?>
        </div>

        <div class="row button">
            <?php echo CHtml::submitButton('Show'); ?>
            <?php echo CHtml::resetButton('Clear'); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
    <hr />
</div>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Balance Sheet</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table style="width: 60%; margin: 0 auto; border-spacing: 0pt">
    <?php foreach ($accountCategories as $accountCategory): ?>
        <tr>
            <td style="padding-left: 25px; font-weight: bold; text-transform: capitalize">
                <?php echo CHtml::encode(CHtml::value($accountCategory, 'name')); ?>
            </td>
            <td style="text-align: right; font-weight: bold">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $accountCategory->getBalanceTotal($startDate, $endDate))); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>