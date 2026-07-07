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
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'StartDate',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                ),
            ));
            ?>

            Sampai
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'EndDate',
                'options' => array(
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                ),
            ));
            ?>
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
    <div style="font-size: larger">LAPORAN LABA / RUGI</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div> 

<br /><br />

<div id="data_div">
    <?php
    $this->renderPartial('_summary', array(
        'accounts' => $accounts,
        'row' => $row,
        'startDate' => $startDate,
        'endDate' => $endDate,
    ));
    ?>
</div>
