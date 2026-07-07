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
    
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
            
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

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

<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($model, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div><?php echo CHtml::encode(CHtml::value($model, 'admin.name')); ?>,</div>
            <div style="height: 30px;"></div>
            <div ></div>
        </div>
        <div class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 30px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($model, 'employeeIdCounter.name'));      ?></div>
        </div>
    </div>
</div>