<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th colspan="2"></th>
        <th colspan="3" style="text-align: center; width: 10%">RAW</th>
        <th colspan="3" style="text-align: center; width: 5%">FINISH</th>
        <th colspan="4"></th>
        <th style="text-align: center; width: 3%;">SM</th>
        <th style="text-align: center; width: 3%;" colspan="3">Toleransi</th>
        <th style="text-align: center; width: 3%;">G</th>
        <th style="text-align: center; width: 3%;" colspan="3">Toleransi</th>
        <th colspan="6"></th>
    </tr>
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Order</th>
        <th style="text-align: center; width: 10%">GRADE</th>
        <th style="text-align: center; width: 5%">TBL/DMTR</th>
        <th style="text-align: center; width: 5%">LBR</th>
        <th style="text-align: center; width: 5%">PJG</th>
        <th style="text-align: center; width: 5%">TBL/DMTR</th>
        <th style="text-align: center; width: 5%">LBR</th>
        <th style="text-align: center; width: 5%">PJG</th>
        <th style="text-align: center; width: 5%">BERAT</th>
        <th style="text-align: center; width: 5%">QTY Produksi</th>
        <th style="text-align: center; width: 5%">QTY</th>
        <th style="text-align: center; width: 5%">M</th>
        <th>&nbsp;</th>
        <th style="text-align: center; width: 5%">T</th>
        <th style="text-align: center; width: 5%">L</th>
        <th style="text-align: center; width: 5%">P</th>
        <th>&nbsp;</th>
        <th style="text-align: center; width: 5%">T</th>
        <th style="text-align: center; width: 5%">L</th>
        <th style="text-align: center; width: 5%">P</th>
        <th style="text-align: center; width: 5%">HT</th>
        <th style="text-align: center; width: 5%">NTD</th>
        <th style="text-align: center; width: 5%">PIC</th>
        <th style="text-align: center; width: 5%">Tanggal QC</th>
        <th style="text-align: center; width: 5%">Hasil QC</th>
        <th style="text-align: center; width: 5%">Keterangan</th>
    </tr>
    
    <?php foreach ($qualityControl->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <?php 
            $workOrderCuttingDetail = (!empty($detail->workOrderCuttingDetail)) ? $detail->workOrderCuttingDetail : ''; 
            $productionMilingDetail = (!empty($detail->productionMilingDetail)) ? $detail->productionMilingDetail : ''; 
            ?>
            <td><!--code-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]production_miling_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'job_number')); ?>
            </td>
            
            <td><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'product_name')); ?>
            </td>

            <td style="text-align: center"><!--height-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'height_quote')); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'width_quote')); ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'length_quote')); ?>
            </td>

            <td style="text-align: center"><!--height-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'height_request')); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'width_request')); ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'length_request')); ?>
            </td>

            <td style="text-align: center"><!--weight-->
                <?php echo CHtml::encode(CHtml::value($productionMilingDetail, 'weight')); ?>
            </td>

            <td style="text-align: center"><!--weight-->
                <?php echo CHtml::hiddenField("production_quantity_{$i}", CHtml::value($detail, 'productionMilingDetail.quantityMilingControlRemaining')); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'productionMilingDetail.quantityMilingControlRemaining')); ?>
            </td>

            <td style="text-align: center"><!--quantity-->
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
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_miling"); ?>
                <?php echo CHtml::error($detail, 'is_miling'); ?>
            </td>
            
            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_sidemiling"); ?>
                <?php echo CHtml::error($detail, 'is_sidemiling'); ?>
            </td>
            
            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]sidemiling_height_tolerance", array('size' => 5)); ?>
            </td>

            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]sidemiling_width_tolerance", array('size' => 5)); ?>
            </td>

            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]sidemiling_length_tolerance", array('size' => 5)); ?>
            </td>

            <td style="text-align: center"><!--is Grinding-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_grinding"); ?>
                <?php echo CHtml::error($detail, 'is_grinding'); ?>
            </td>

            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]grinding_height_tolerance", array('size' => 5)); ?>
            </td>

            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]grinding_width_tolerance", array('size' => 5)); ?>
            </td>

            <!--product name quote-->
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]grinding_length_tolerance", array('size' => 5)); ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_hardness"); ?>
                <?php echo CHtml::error($detail, 'is_hardness'); ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_annelying"); ?>
                <?php echo CHtml::error($detail, 'is_annelying'); ?>
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