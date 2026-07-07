<?php
Yii::app()->clientScript->registerScript('report', '
	$("#header").addClass("hide");
	$("#mainmenu").addClass("hide");
	$(".breadcrumbs").addClass("hide");
	$("#footer").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#PageSize").val("' . $saleInvoiceSamplePerYearSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($saleInvoiceSamplePerYearSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="hide">
    <div class="form" style="text-align: center">

        <?php echo CHtml::beginForm(array(''), 'get'); ?>

        <div class="row" style="background-color: #DFDFDF">
            Customer
            <?php echo CHtml::textField('CustomerName', $customerName); ?>
        </div>

        <div class="row">
            Jumlah per Halaman
            <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>

            Halaman saat ini
            <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
        </div>
        
        <div class="row" style="background-color: #DFDFDF">
            Tahun
            <?php echo CHtml::dropDownlist('YearChoose', $yearChoose, $yearList, array('empty' => '-- Pilih Tahun --')); ?>
        </div>

        <div class="row">
            <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
        </div>

        <div class="row button">
            <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
            <?php echo CHtml::resetButton('Clear'); ?>
        </div>

        <?php echo CHtml::endForm(); ?>

    </div>

    <hr />

    <div class="right"><?php echo ReportHelper::summaryText($saleInvoiceSamplePerYearSummary->dataProvider); ?></div>
    <div class="clear"></div>
    <div class="right"><?php echo ReportHelper::sortText($saleInvoiceSamplePerYearSummary->dataProvider->sort, array('Customer')); ?></div>
    <div class="clear"></div>
</div>

<div>
    <?php $this->renderPartial('_summary', array('saleInvoiceSamplePerYearSummary' => $saleInvoiceSamplePerYearSummary, 'yearChoose' => $yearChoose)); ?>
</div>

<div class="hide">
    <div class="right">
        <?php
        $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $saleInvoiceSamplePerYearSummary->dataProvider->pagination->itemCount,
            'pageSize' => $saleInvoiceSamplePerYearSummary->dataProvider->pagination->pageSize,
            'currentPage' => $saleInvoiceSamplePerYearSummary->dataProvider->pagination->getCurrentPage(false),
        ));
        ?>
    </div>
    <div class="clear"></div>
</div>