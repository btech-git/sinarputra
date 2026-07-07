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
    <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
    <div style="font-size: 2.5em">SPK Potong</div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">SPK Potong #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($model->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Remark C3</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'saleHeader.note')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Order Penjualan #</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo ($model->saleHeader != null) ? CHtml::encode($model->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : 'No Sale Header'; ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'saleHeader.date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($model, 'saleHeader.customer.company')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />

<table class="memo">
    <tr class="theader">
        <th style="border-bottom: 0px solid;">No.</th>
        <th style="border-bottom: 0px solid;">Job Number</th>
        <th colspan="5">Permintaan</th>
        <th colspan="5">Penawaran</th>
        <th style="border-bottom: 0px solid;">Berat</th>
        <th style="border-bottom: 0px solid;">M</th>
        <th style="border-bottom: 0px solid;">SM</th>
        <th style="border-bottom: 0px solid;">G</th>
        <th style="border-bottom: 0px solid;">HT</th>
        <th style="border-bottom: 0px solid;">NTD</th>
    </tr>
    <tr class="theader">
        <th style="width: 3%">&nbsp;</th>
        <th style="width: 8%">&nbsp;</th>
        <th>GRADE</th>
        <th style="width: 5%">Tbl</th>
        <th style="width: 5%">Lebar</th>
        <th style="width: 5%">Pjg</th>
        <th style="width: 5%">Quantity</th>
        <th>GRADE</th>
        <th style="width: 5%">Tbl</th>
        <th style="width: 5%">Lebar</th>
        <th style="width: 5%">Pjg</th>
        <th style="width: 5%">Quantity</th>
        <th style="width: 5%">&nbsp;</th>
        <th style="width: 3%">&nbsp;</th>
        <th style="width: 3%">&nbsp;</th>
        <th style="width: 3%">&nbsp;</th>
        <th style="width: 3%">&nbsp;</th>
        <th style="width: 3%">&nbsp;</th>
    </tr>

    <?php foreach ($model->workOrderReplacementDetails as $i => $detail): ?>
        <?php if ($i < 31) : ?>
            <tr class="titems">
                <td style="text-align:center"><?php echo $i + 1; ?></td>
                <td style="text-align:center">
                    <?php echo CHtml::encode(CHtml::value($detail, 'job_number')); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height_request'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width_request'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length_request'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height_quote'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width_quote'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length_quote'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_quote'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_miling') == 1) ? "Yes" : ""); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_sidemiling') == 1) ? "Yes" : ""); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_grinding') == 1) ? "Yes" : ""); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_hardness') == 1) ? "Yes" : ""); ?>
                </td>
                <td style="text-align: center">
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_annelying') == 1) ? "Yes" : ""); ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    <?php if (count($model->workOrderCuttingDetailProducts) > 30): ?>      
        <?php for ($j = 6, $i = $i % $j + 1; $j > $i; $j--): ?>
            <tr class="titems">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php endfor; ?>
    <?php endif; ?>
</table>

<br />

<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($model, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div>Admin,</div>
            <div style="height: 30px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($model, 'admin.name'));       ?></div>
        </div>
        <div class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 30px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($model, 'employeeIdCounter.name'));       ?></div>
        </div>
    </div>
</div>