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
        <div style="font-size: 2.5em">SPK POTONG</div>
    </div>
    <div class="clear"></div>

</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">SPK #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($model->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal PPC</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal Kirim</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.estimate_delivery_date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">PO #</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.customer_order_number')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.customer.company')); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header">&nbsp;</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(nl2br(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.customer.address'))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Sales</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.customer.employee.name')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />
 
<table style="border: 1px solid">
    <tr>
        <th style="text-align: center; border: 1px solid; width: 10%" rowspan="2">GRADE</th>
        <th style="text-align: center; border: 1px solid; width: 10%" rowspan="2">Serial #</th>
        <th style="text-align: center; border: 1px solid" colspan="3">Material Awal</th>
        <th style="text-align: center; border: 1px solid" colspan="3">REQUEST CUSTOMER</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">Qty</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">STAT</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">Berat</th>
        <th style="text-align: center; border: 1px solid; width: 10%" rowspan="2">Lokasi</th>
        <th style="text-align: center; border: 1px solid; width: 10%" rowspan="2">Operator</th>
        <th style="text-align: center; border: 1px solid; width: 15%" rowspan="2">Mesin</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">M/G</th>
    </tr>
    <tr>
        <th style="text-align: center; border: 1px solid; width: 5%">T/D</th>
        <th style="text-align: center; border: 1px solid; width: 5%">L</th>
        <th style="text-align: center; border: 1px solid; width: 5%">P</th>
        <th style="text-align: center; border: 1px solid; width: 5%">T/D</th>
        <th style="text-align: center; border: 1px solid; width: 5%">L</th>
        <th style="text-align: center; border: 1px solid; width: 5%">P</th>
    </tr>
    <?php foreach ($model->productionPlanningCuttingDetails as $planningDetail): ?>
        <?php foreach ($planningDetail->workOrderCuttingDetail->workOrderCuttingDetailMaterials as $detail): ?>
            <?php $initialMaterial = ($detail->receiveDetail === null) ? $detail->workOrderCuttingDetailMaterial : $detail->receiveDetail; ?>
            <tr>
                <td style="text-align: center;"><!--name-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                </td>

                <td style="text-align: center;"><!--Serial NUmber-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'serialConstant')); ?>
                </td>                                

                <td style="text-align: center"><!--height-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($initialMaterial, 'height'))); ?>
                </td>

                <td style="text-align: center"><!--width order-->
                    <?php echo ($initialMaterial->product_category_id == 2) ? 0 : CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($initialMaterial, 'width'))); ?>
                </td>

                <td style="text-align: center"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($initialMaterial, 'length'))); ?>
                </td>

                <td style="text-align: center"><!--height-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height'))); ?>
                </td>

                <td style="text-align: center"><!--width order-->
                    <?php echo ($detail->product_category_id == 2) ? 0 : CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width'))); ?>
                </td>

                <td style="text-align: center"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length'))); ?>
                </td>

                <td style="text-align: center"><!--qty order-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::encode(CHtml::value($detail, 'materialTypeValue')); ?>
                </td>
                
                <td style="text-align: right"><!--weight-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($detail, 'weight'))); ?>
                </td>

                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'location.name')); ?>
                </td>
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>                            
        <?php endforeach; ?>
        <tr>
            <td style="border-top: 1px solid; text-align: center; font-weight: bold">
                <?php echo CHtml::encode(CHtml::value($planningDetail, 'workOrderCuttingDetail.product_name')); ?>
            </td>
            
            <td style="border-top: 1px solid" colspan="4">&nbsp;</td>
            
            <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($planningDetail, 'height'))); ?>
            </td>
            
            <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($planningDetail, 'width'))); ?>
            </td>
            
            <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($planningDetail, 'length'))); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($planningDetail, 'quantity'))); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid; font-weight: bold">KRM</td>
            
            <td style="text-align: right; border-top: 1px solid; font-weight: bold"><!--weight-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', CHtml::value($planningDetail, 'weight'))); ?>
            </td>
            
            <td style="border-top: 1px solid" colspan="2">&nbsp;</td>
            
            <td style="text-align: center; border-top: 1px solid; font-weight: bold">
                <?php echo (CHtml::value($planningDetail, "machine.fullSpecification")); ?>
            </td>
            
            <td style="border-top: 1px solid">&nbsp;</td
        </tr>
    <?php endforeach; ?>
</table>
   
<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($model, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div>Admin,</div>
            <div style="height: 30px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($model, 'admin.name'));      ?></div>
        </div>
        <div class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 30px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($model, 'employeeIdCounter.name'));      ?></div>
        </div>
    </div>
</div>