<?php
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
');
?>

<div id="memoheader">
    <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
    <div style="font-size: 2.5em">JOB ORDER PPIC</div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Job Order #</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($model->getCodeNumber(JobOrderHeader::CN_CONSTANT)); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'date')))); ?></div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Order Note</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($model, 'workOrderCuttingHeader.saleHeader.note')); ?></div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">SPK #</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo (isset($model->workOrderCuttingHeader)) ? CHtml::encode($model->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : 'No Work Order Header'; ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo (isset($model->workOrderCuttingHeader)) ? CHtml::encode($model->workOrderCuttingHeader->saleHeader->customer->company) : 'No Work Order Header'; ?>
                    </div>
                </div>
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Tanggal SPK</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($model, 'workOrderCuttingHeader.date')))); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<br />
<?php if (isset($model->jobOrderDetailProducts) && $model->jobOrderDetailProducts != null): ?> 
    <table class="memo">
        <tr id="theader">
            <th style="text-align:center; border-bottom: 0px solid;">Job Number</th>
            <th style="text-align:center; border-bottom: 0px solid;">GRADE</th>
            <th style="text-align:center; border-bottom: 0px solid;">Ord Lr</th>
            <th colspan="2">Material Order</th>
            <th style="text-align:center;border-bottom: 0px solid;">PJG </th>
            <th style="text-align:center;border-bottom: 0px solid;">QTY</th>
            <th style="text-align:center;border-bottom: 0px solid;">BERAT</th>
            <th style="text-align:center;border-bottom: 0px solid;">MESIN</th>
            <th style="text-align:center;border-bottom: 0px solid;">M</th>
            <th style="text-align:center;border-bottom: 0px solid;">SM</th>
            <th style="text-align:center;border-bottom: 0px solid;">G</th>
            <th style="text-align:center;border-bottom: 0px solid;">HT</th>
            <th style="text-align:center;border-bottom: 0px solid;">NTD</th>

            <th style="text-align:center;border-bottom: 0px solid;">JAM</th>
        </tr>
        <tr class="theader">
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 10%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">&nbsp;</th>
            <th style="text-align:center;border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">TBL/DMTR</th>
            <th style="text-align:center;border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">LBR/DMTR</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 15%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 3%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 3%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 3%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 3%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 3%">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid; width: 5%">&nbsp;</th>
        </tr>

        <?php foreach ($model->jobOrderDetailProducts as $i => $detail): ?>
            <tr class="titems">
                <td><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetailProduct.saleDetailProduct.quotationDetailProduct.job_number')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetailProduct.saleDetailProduct.quotationDetailProduct.product.name')); ?></td>
                <td style="text-align: center">
                    <?php echo CHtml::encode((CHtml::value($detail, 'workOrderCuttingDetailProduct.is_external_order') == 1) ? "Yes" : ""); ?>
                </td>

                <td style="text-align: center; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?>
                </td>
                <td style="text-align: center; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?>
                </td>
                <td style="text-align: center; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?>
                </td>
                <td style="text-align: center; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                </td>
                <td style="text-align: center; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'machine.fullSpecification')); ?></td>
                <td style="text-align: center;"><?php echo $detail->is_miling ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_sidemiling ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_grinding ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_hardness ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_annelying ? 'Yes' : ''; ?></td>
                <td style="text-align: center; "><?php echo CHtml::encode(CHtml::value($detail, 'time') . ':00'); ?></td>
            </tr>
            <tr class="titems">
                <td colspan="17" style="border: 2px solid; ">Material Awal :</td>
            </tr>
            <tr class="titems">
                <td colspan="17">Sipot :</td>
            </tr>
            <tr class="titems">
                <td colspan="17" style="border: 2px solid;">Sipot :</td>
            </tr>
        <?php endforeach; ?>
        <?php for ($j = 5, $i = $i % $j + 1; $j > $i; $j--): ?>
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
            </tr>
        <?php endfor; ?>
    </table>

<?php else: ?>

    <table class="memo">
        <tr id="theader">
            <th style="text-align:center; border-bottom: 0px solid;">GRADE</th>
            <th colspan="2">Permintaan</th>
            <th colspan="2">Penawaran</th>
            <th style="text-align:center; border-bottom: 0px solid;">PJG</th>
            <th style="text-align:center; border-bottom: 0px solid;">QTY</th>
            <th style="text-align:center; border-bottom: 0px solid;">BERAT</th>
            <th style="text-align:center; border-bottom: 0px solid;">MESIN</th>
            <th style="text-align:center; border-bottom: 0px solid;">M</th>
            <th style="text-align:center; border-bottom: 0px solid;">G</th>
            <th style="text-align:center; border-bottom: 0px solid;">FH</th>
            <th style="text-align:center; border-bottom: 0px solid;">ANNL</th>
            <th style="text-align:center; border-bottom: 0px solid;">SM</th>
            <th style="text-align:center; border-bottom: 0px solid;">JAM</th>
        </tr>
        <tr class="theader">
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="text-align:center;border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">TBL / DMTR</th>
            <th style="text-align:center;border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">LBR / DMTR</th>
            <th style="text-align:center;border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">TBL / DMTR</th>
            <th style="text-align:center;border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">LBR / DMTR</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
            <th style="border-left: 1px solid;border-bottom: 2px solid;border-right: 1px solid;">&nbsp;</th>
        </tr>

        <?php foreach ($model->jobOrderDetailServices as $i => $detail): ?>
            <tr class="titems">
                <td><?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.product_name')); ?></td>
                <td style="text-align: center"><!--height-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.height_request')); ?>
                </td>

                <td style="text-align: center"><!--width-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.width_request')); ?>
                </td>
                <td style="text-align: right; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.height_quote'))); ?>
                </td>
                <td style="text-align: right; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.width_quote'))); ?>
                </td>
                <td style="text-align: right; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.length_quote'))); ?>
                </td>
                <td style="text-align: right; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.quantity'))); ?>
                </td>
                <td style="text-align: right; ">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetailService.saleDetailService.quotationDetailService.weight'))); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'machine.name')); ?></td>
                <td style="text-align: center;"><?php echo $detail->is_miling ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_grinding ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_hardness ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_annelying ? 'Yes' : ''; ?></td>
                <td style="text-align: center;"><?php echo $detail->is_sidemiling ? 'Yes' : ''; ?></td>
                <td style="text-align: center; "><?php echo CHtml::encode(CHtml::value($detail, 'time') . ':00'); ?></td>
            </tr>	
        <?php endforeach; ?>
        <?php for ($j = 10, $i = $i % $j + 1; $j > $i; $j--): ?>
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
            </tr>
        <?php endfor; ?>
    </table>

<?php endif; ?>


<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($model, 'note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div></div>
        </div>
        <div  class="divtablecell sig2">
            <div>Mengetahui,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($model, 'employeeIdAuthorized.name'));         ?></div>
        </div>
        <div  class="divtablecell sig3">
            <div>Disetujui,</div>
            <div style="height: 50px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($model, 'employeeIdApproved.name'));         ?></div>
        </div>
        <div class="divtablecell sig4">
            <div></div>
        </div>
    </div>
</div>
