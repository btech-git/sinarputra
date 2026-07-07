<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Order</th>
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 5%;">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%;">PJG</th>
        <th style="text-align: center; width: 5%;">BERAT</th>
        <th style="text-align: center; width: 5%;">QTY SPK</th>
        <th style="text-align: center; width: 5%;">QTY Produksi</th>
        <th style="text-align: center; width: 5%;">QTY</th>
        <th style="text-align: center; width: 3%">M</th>
        <th style="text-align: center; width: 3%">SM</th>
        <th style="text-align: center; width: 3%">G</th>
        <th style="text-align: center; width: 3%">HT</th>
        <th style="text-align: center; width: 3%">NTD</th>
        <th style="text-align: center; width: 5%">PIC</th>
        <th style="text-align: center; width: 5%;">Tanggal QC</th>
        <th style="text-align: center; width: 5%;">Hasil QC</th>
        <th style="text-align: center; width: 5%;">Keterangan</th>
    </tr>
    
    <?php foreach ($qualityControl->details as $i => $detail): ?>
        <?php echo CHtml::errorSummary($detail); ?>
        <tr style="background-color: azure">
            <?php $productionCuttingDetail = (!empty($detail->productionCuttingDetail)) ? $detail->productionCuttingDetail : ''; ?>
            <td><!--code-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]production_cutting_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.job_number')); ?>
            </td>
            
            <td><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.product_name')); ?>
            </td>

            <td style="text-align: center"><!--height-->
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.height_quote')); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.width_quote')); ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.length_quote')); ?>
            </td>

            <td style="text-align: center"><!--weight-->
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.weight')); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.quantity')); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::hiddenField("production_quantity_{$i}", CHtml::value($productionCuttingDetail, 'quantityCuttingControlRemaining')); ?>
                <?php echo CHtml::encode(CHtml::value($productionCuttingDetail, 'quantityCuttingControlRemaining')); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 5, 'maxLength' => 10,
                    'onchange' => '
                        if (parseInt($(this).val()) > parseInt($("#production_quantity_' . $i . '").val())) 
                            $(this).val($("#production_quantity_' . $i . '").val()) 
                    '
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center"><!--is miling-->
                <?php echo (CHtml::value($detail, 'workOrderCuttingDetail.is_miling') == 1) ? "Yes" : ""; ?>
            </td>
            
            <td style="text-align: center"><!--is annelying-->
                <?php echo (CHtml::value($detail, 'workOrderCuttingDetail.is_sidemiling') == 1) ? "Yes" : ""; ?>
            </td>
            
            <td style="text-align: center"><!--is Grinding-->
                <?php echo (CHtml::value($detail, 'workOrderCuttingDetail.is_grinding') == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo (CHtml::value($detail, 'workOrderCuttingDetail.is_hardness') == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo (CHtml::value($detail, 'workOrderCuttingDetail.is_annelying') == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]employee_id", CHtml::listData(Employee::model()->findAll(array('condition' => 't.division_id = 1 AND t.is_inactive = 0')), 'id', 'name'), array(
                    'empty' => '-Pilih PIC-'
                )); ?>
                <?php echo CHtml::error($detail, 'employee_id'); ?>
            </td>

            <td style="text-align: center">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $detail,
                    'attribute' => "[$i]control_date",
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($detail, 'control_date'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]control_result", array(
                    'Good' => 'Good', 
                    'NG' => 'NG'
                )); ?>
                <?php echo CHtml::error($detail, 'control_result'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]memo", array('size' => 20, 'maxLength' => 100)); ?>
                <?php echo CHtml::error($detail, 'memo'); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>