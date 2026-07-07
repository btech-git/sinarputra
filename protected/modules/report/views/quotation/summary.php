<?php
Yii::app()->clientScript->registerScript('report', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#PageSize").val("' . $quotationSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($quotationSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="hide">
    <div class="form" style="text-align: center">

        <?php echo CHtml::beginForm(array(''), 'get'); ?>
        
        <div class="row" style="background-color: #DFDFDF">
            Customer
            <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'model' => $quotationHeader,
                'attribute' => 'customer_id',
                'source' => 'js:function(request, response) {
                    $.ajax({
                        type: "GET",
                        dataType: "JSON",
                        url: "' . CController::createUrl('/completion/ajaxJsonCustomer') . '",
                        data: {"term": request["term"]},
                        success: function(data) {
                            response(data);
                        },
                        error: function(data) {
                            response("");
                        },
                    });
                }',
                //additional javascript options for the autocomplete plugin
                'options' => array(
                    'minLength' => '2',
                    'select' => 'js:function(event, ui) {
                        $("#customer_name").html(ui.item.id);
                    }',
                )
            )); ?>
            <?php $saleCustomer = $quotationHeader->customer(array('scopes' => 'resetScope')); ?>
            <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
            <?php echo CHtml::encode(CHtml::value($saleCustomer, 'company')); ?>
            <?php echo CHtml::closeTag('span'); ?>  
            &nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;   
            <?php echo 'Status Transaksi'; ?>
            <?php echo CHtml::activeDropdownList($quotationHeader, 'is_inactive', array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
            ), array('empty' => '-- all --')); ?>
        </div>

        <div class="row">
            Jumlah per Halaman
            <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>

            Halaman saat ini
            <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
        </div>

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
    <div class="right"><?php echo ReportHelper::summaryText($quotationSummary->dataProvider); ?></div>
    <div class="clear"></div>
    <div class="right"><?php echo ReportHelper::sortText($quotationSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
    <div class="clear"></div>
</div>

<div>
    <?php $this->renderPartial('_summary', array('quotationSummary' => $quotationSummary, 'startDate' => $startDate, 'endDate' => $endDate)); ?>
</div>

<div class="hide">
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $quotationSummary->dataProvider->pagination->itemCount,
            'pageSize' => $quotationSummary->dataProvider->pagination->pageSize,
            'currentPage' => $quotationSummary->dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>