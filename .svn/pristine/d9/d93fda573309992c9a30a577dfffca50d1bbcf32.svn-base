<?php
//$model as WorkOrderCuttingHeader model

Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }
    
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 25% }
    .sig2 { width: 25% }
    .sig3 { width: 25% }
    .sig4 { width: 25% }
	
	table.memo, table.memo tr.theader th, table.memo tr.titems td
	{
		border-left: 1px solid;
		border-right: 1px solid;
		vertical-align:text-top;
	}
	
	table.memo tr.theader th
	{
		text-align: center;
		border-bottom: 2px solid;
	}
	
');
?>

<?php /*
$detailsCount = 0;

//if (!CHtml::value($model, 'saleHeader.is_service'))
    $detailsCount = count($model->workOrderCuttingDetails);
//else
//    $detailsCount = count($model->workOrderCuttingDetailServices);

$pages = ceil($detailsCount / 30);


for ($i = 1; $i <= $pages; $i++) {

    $counterStart = ($i - 1) * 30;
    $counterEnd = $i * 30;
    $spacing = 0;

    if ($i == $pages)
        $spacing = 1;

    $this->renderPartial('memoDetail', array(
        'model' => $model,
        'counterStart' => $counterStart,
        'counterEnd' => $counterEnd,
        'spacing' => $spacing,
    ));


    if ($i == $pages) {
        $this->renderPartial('memoFooter', array(
            'model' => $model
        ));
    }
    ?>

    <div style="height: 250px">&nbsp;</div>

    <?php
} */
?>

<div id="memoheader">
    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" height="90px"/></div>
    <div class="memo-title">
<!--        <div style="font-size: larger">PT. Sinar Putra Metalindo</div>-->
        <div style="font-size: 2.5em">SPK Replacement Miling</div>
    </div>
    <div class="clear"></div>

</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">SPK Replacement Miling #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($model->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Remark C3</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.note')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Order Penjualan #</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php
                        echo ($model->workOrderCuttingHeader->saleHeader != null) ? CHtml::encode($model->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : 'No Sale Header';
                        ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer PO #</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.customer_order_number')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
    
<table style="border: 1px solid">
    <tr>
        <th style="text-align: center;">Job Number</th>
        <th style="text-align: center;">GRADE</th>
        <th style="text-align: center; border-left: 1px solid" colspan="3">Awal</th>
        <th style="text-align: center; border-left: 1px solid; border-right: 1px solid" colspan="3">Finish</th>
        <th style="text-align: center;">Qty</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">M</th>
        <th style="text-align: center;">SM</th>
        <th style="text-align: center;">G</th>
        <th style="text-align: center;">HT</th>
        <th style="text-align: center;">NTD</th>
    </tr>
    <tr class="theader">
        <th colspan="2">&nbsp;</th>
        <th style="text-align: center; border-left: 1px solid">Tbl / Dmtr</th>
        <th style="text-align: center;">Lebar</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center; border-left: 1px solid">Tbl / Dmtr</th>
        <th style="text-align: center;">Lebar</th>
        <th style="text-align: center; border-right: 1px solid">Pjg</th>
        <th colspan="6">&nbsp;</th>
    </tr>
    <?php foreach ($model->workOrderReplacementDetails as $replacementDetail): ?>
        <tr>
            <td style="border-top: 1px solid">
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'job_number')); ?>
            </td>
            <td style="border-top: 1px solid">
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'product_name')); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid; border-left: 1px solid"><!--height-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'height_quote'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'width_quote'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'length_quote'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid; border-left: 1px solid"><!--height-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'height_request'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'width_request'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid; border-right: 1px solid"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'length_request'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($replacementDetail, 'quantity'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid"><!--weight-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($replacementDetail, 'weight'))); ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::encode(CHtml::value($replacementDetail, 'is_miling')) == 1) ? "Yes" : ""; ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::encode(CHtml::value($replacementDetail, 'is_sidemiling')) == 1) ? "Yes" : ""; ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::value($replacementDetail, "is_grinding") == 1) ? "Yes" : ""; ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::value($replacementDetail, "is_hardness") == 1) ? "Yes" : ""; ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::value($replacementDetail, "is_annelying") == 1) ? "Yes" : ""; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
   
<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($model, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div><?php echo CHtml::encode(CHtml::value($model, 'admin.name')); ?>,</div>
            <div style="height: 30px;"></div>
            <div></div>
        </div>
        <div class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 30px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($model, 'employeeIdCounter.name'));      ?></div>
        </div>
    </div>
</div>