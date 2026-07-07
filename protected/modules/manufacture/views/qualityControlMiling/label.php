<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 100% }

    .hcolumn1header { width: 25% }
    .hcolumn1value { width: 75% }
');
?>

<div id="memoheader">
    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" width="100%"/></div>
    <div style="font-size: larger; font-family: 'Arial'; font-weight: bold">PT. Sinar Putra Metalindo</div>
</div>

<div class="memonote" style="font-size: 12px; font-family: 'Arial'; font-weight: bold">
    <?php $workOrderCuttingDetail = $qualityControlMilingDetail->workOrderCuttingDetail; ?>
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Customer</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(CHtml::value($qualityControlMilingDetail, 'qualityControlMilingHeader.workOrderCuttingHeader.saleHeader.customer.company')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Jenis Material</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($workOrderCuttingDetail->product_name); ?></div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Qty</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($qualityControlMilingDetail, 'quantity')); ?> pcs</div>
                </div>
				
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Ukuran(mm)</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($qualityControlMilingDetail, 'workOrderCuttingDetail.height_request'))); ?> x
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($qualityControlMilingDetail, 'workOrderCuttingDetail.width_request'))); ?> x
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($qualityControlMilingDetail, 'workOrderCuttingDetail.length_request'))); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">SPK</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode($qualityControlMilingDetail->qualityControlMilingHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?></div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Jenis Proses</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo (int) $workOrderCuttingDetail->is_miling == 1 ? 'M, ' : ''; ?>
                        <?php echo (int) $workOrderCuttingDetail->is_sidemiling == 1 ? 'SM, ' : ''; ?>
                        <?php echo (int) $workOrderCuttingDetail->is_grinding == 1 ? 'G, ' : ''; ?>
                        <?php echo (int) $workOrderCuttingDetail->is_hardness == 1 ? 'HT, ' : ''; ?>
                        <?php echo (int) $workOrderCuttingDetail->is_annelying == 1 ? 'NTD' : ''; ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">Kode Barang</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode($workOrderCuttingDetail->job_number); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header">No PO</div>
                    <div class="divtablecell info hcolumn1value"><?php echo CHtml::encode(CHtml::value($qualityControlMilingDetail, 'qualityControlMilingHeader.workOrderCuttingHeader.saleHeader.customer_order_number')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
