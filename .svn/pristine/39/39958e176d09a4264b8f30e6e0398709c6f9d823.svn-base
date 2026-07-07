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

    table.memo, table.memo tr.theader th, table.memo tr.titems td {
        border-left: 1px solid;
        border-right: 1px solid;
        vertical-align:text-top;
    }

    table.memo tr.theader th {
        text-align: center;
        border-bottom: 2px solid;
    }
	
');
?>

<table style="border: 1px solid">
    <tr>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">GRADE</th>
        <th style="text-align: center; border: 1px solid; width: 10%" rowspan="2">Serial #</th>
        <th style="text-align: center; border: 1px solid" colspan="3">Material Awal</th>
        <th style="text-align: center; border: 1px solid" colspan="3">REQUEST CUSTOMER</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">Qty</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">STAT</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">ORD LUAR</th>
        <th style="text-align: center; border: 1px solid; width: 5%" rowspan="2">Berat</th>
        <th style="text-align: center; border: 1px solid" colspan="2">Lokasi</th>
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
        <th style="text-align: center; border: 1px solid; width: 5%">Awal</th>
        <th style="text-align: center; border: 1px solid; width: 5%">Sipot</th>
    </tr>
    
    <?php foreach ($model->workOrderCuttingDetails as $cuttingDetail): ?>
        <?php foreach ($cuttingDetail->workOrderCuttingDetailMaterials as $detail): ?>
            <?php $initialMaterial = ($detail->work_order_cutting_detail_material_id !== null) ? $detail->workOrderCuttingDetailMaterial : $detail->receiveDetail; ?>
            <tr>
                <td style="text-align: center;"><!--name-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
                </td>

                <td style="text-align: center;"><!--Serial NUmber-->
                    <?php echo CHtml::encode(CHtml::value($detail, 'serialConstant')); ?>
                </td>                                

                <td style="text-align: center"><!--height-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($initialMaterial, 'height'))); ?>
                </td>

                <td style="text-align: center"><!--width order-->
                    <?php echo ($detail->product_category_id == 2) ? 0 : CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($initialMaterial, 'width'))); ?>
                </td>

                <td style="text-align: center"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($initialMaterial, 'length'))); ?>
                </td>

                <td style="text-align: center"><!--height-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?>
                </td>

                <td style="text-align: center"><!--width order-->
                    <?php echo ($detail->product_category_id == 2) ? 0 : CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?>
                </td>

                <td style="text-align: center"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?>
                </td>

                <td style="text-align: center"><!--qty order-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
                </td>

                <td style="text-align: center">
                    <?php echo CHtml::encode(CHtml::value($detail, 'materialTypeValue')); ?>
                </td>
                
                <td>&nbsp;</td>
                
                <td style="text-align: right"><!--weight-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?>
                </td>

                <td>
                    <?php echo CHtml::encode(CHtml::value($initialMaterial, 'location.name')); ?>
                </td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($detail, 'location.name')); ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>                            
        <?php endforeach; ?>
        <?php if ($cuttingDetail->is_inactive == 0): ?>
            <tr>
                <td style="border-top: 1px solid; text-align: center; font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($cuttingDetail, 'product_name')); ?>
                </td>

                <td style="border-top: 1px solid" colspan="4">
                    <?php echo CHtml::encode(CHtml::value($cuttingDetail, 'job_number')); ?>
                </td>

                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($cuttingDetail, 'height_quote'))); ?>
                </td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                    <?php echo ($cuttingDetail->product_category_id == 2) ? 0.00 : CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($cuttingDetail, 'width_quote'))); ?>
                </td>
                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($cuttingDetail, 'length_quote'))); ?>
                </td>

                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--length awal-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($cuttingDetail, 'quantity'))); ?>
                </td>

                <td style="text-align: center; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($cuttingDetail, 'deliveryStatus')); ?>
                </td>

                <td style="text-align: center; border-top: 1px solid; font-weight: bold">
                    <?php echo CHtml::encode(CHtml::value($cuttingDetail, 'externalOrderStatus')); ?>
                </td>

                <td style="text-align: center; border-top: 1px solid; font-weight: bold"><!--weight-->
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($cuttingDetail, 'weight'))); ?>
                </td>

                <td style="border-top: 1px solid" colspan="4">
                    <?php if ($cuttingDetail->is_urgent === 1): ?>
                        <?php echo CHtml::encode(CHtml::value($cuttingDetail, 'urgentStatus')); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
   