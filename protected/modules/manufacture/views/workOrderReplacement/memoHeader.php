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

<div id="memoheader">

    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" height="90px"/></div>
    <div class="memo-title">
        <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
        <div style="font-size: 2.5em">SPK REPLACEMENT</div>
    </div>
    <div class="clear"></div>

</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">SPK Replacement #</div>
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
                        <?php echo ($model->workOrderCuttingHeader->saleHeader != null) ? CHtml::encode($model->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : 'No Sales Order'; ?>
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