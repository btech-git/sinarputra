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
        <div class="row" style="background-color: #DFDFDF">
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

        <div id="account_div" class="row" style="background-color: #DFDFDF">
            Account
            <?php echo CHtml::textField('AccountId', $accountId, array(
                'readonly' => true,
                'onclick' => 'jQuery("#account-dialog").dialog("open"); return false;',
                'onkeypress' => 'if (event.keyCode == 13) { $("#account-dialog").dialog("open"); return false; }'
            )); ?>
            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'account-dialog',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => 'Account COA',
                    'autoOpen' => false,
                    'width' => 'auto',
                    'modal' => true,
                ),
            )); ?>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'account-grid',
                'dataProvider' => $accountDataProvider,
                'filter' => $account,
                'selectionChanged' => 'js:function(id){
                    $("#AccountId").val($.fn.yiiGridView.getSelection(id));
                    $("#account-dialog").dialog("close");
                    if ($.fn.yiiGridView.getSelection(id) == "") {
                        $("#account_name").html("");
                    } else {
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonCoa') . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#account_name").html(data.account_name);
                            },
                        });
                    }
                }',
                'columns' => array(
                    'code',
                    'name',
                    array(
                        'name' => 'account_category_id',
                        'value' => 'CHtml::encode(CHtml::value($data, "accountCategory.name"))',
                    ),
                ),
            )); ?>
            <?php $this->endWidget(); ?>
            <?php echo CHtml::openTag('span', array('id' => 'account_name')); ?>
            <?php $account = Account::model()->findByPk($accountId); ?>
            <?php echo CHtml::encode(CHtml::value($account, 'name')); ?>
            <?php echo CHtml::closeTag('span'); ?> 
        </div>

        <div class="row">
            <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
        </div>

        <div class="row button">
            <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
            <?php echo CHtml::resetButton('Clear'); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
        
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::submitButton('Save To Excel', array('name' => 'SaveToExcel')); ?>
        <?php echo CHtml::endForm(); ?>

    </div>

    <hr />

    <div class="right"><?php //echo ReportHelper::summaryText($generalLedgerSummary->dataProvider); ?></div>
    <div class="clear"></div>
</div>

<div>
    <?php $this->renderPartial('_summary', array(
        'generalLedgerReport' => $generalLedgerReport,
        'ledgerBeginningBalanceData' => $ledgerBeginningBalanceData,
        'startDate' => $startDate, 
        'endDate' => $endDate
    )); ?>
</div>

<div class="hide">
    <div class="right">
        <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $generalLedgerSummary->dataProvider->pagination->itemCount,
            'pageSize' => $generalLedgerSummary->dataProvider->pagination->pageSize,
            'currentPage' => $generalLedgerSummary->dataProvider->pagination->getCurrentPage(false),
        ));*/ ?>
    </div>
    <div class="clear"></div>
</div>
