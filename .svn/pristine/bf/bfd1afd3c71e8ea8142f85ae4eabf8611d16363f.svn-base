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
            <?php //echo CHtml::activeDropDownlist($quotationHeader, 'customer_id', CHtml::listData(Customer::model()->findAll(array('order' => 'company ASC')), 'id', 'company'), array('empty' => '-- Semua Customer --')); ?>
            <?php echo CHtml::activeTextField($quotationHeader, 'customer_id', array(
                'readonly' => true,
                'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
            )); ?>

            <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id' => 'customer-dialog',
                // additional javascript options for the dialog plugin
                'options' => array(
                    'title' => 'Customer',
                    'autoOpen' => false,
                    'width' => 'auto',
                    'modal' => true,
                ),
            )); ?>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'customer-grid',
                'dataProvider' => $customerDataProvider,
                'filter' => $customer,
                'selectionChanged' => 'js:function(id) {
                    $("#' . CHtml::activeId($quotationHeader, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                    $("#customer-dialog").dialog("close");
                    if ($.fn.yiiGridView.getSelection(id) == "")
                    {
                        $("#customer_company").html("");
                    }
                    else
                    {
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonCustomer') . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#customer_company").html(data.customer_company);
                            },
                        });
                    }
                }',
                'columns' => array(
                    'name',
                    'company',
                    'address_main',
                ),
            ));
            ?>
            <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>  
            &nbsp;&nbsp;&nbsp; || &nbsp;&nbsp;&nbsp;   
            <?php echo 'Status Transaksi'; ?>
            <?php echo CHtml::activeDropdownList($quotationHeader, 'is_inactive', array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL, 
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL
            ), array('empty' => '-- all --')); ?>
        </div>

        <div class="row">
            <?php echo CHtml::label('Perusahaan', ''); ?>
            <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
            <?php echo CHtml::encode(CHtml::value($quotationHeader, 'customer.company')); ?>
            <?php echo CHtml::closeTag('span'); ?>
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