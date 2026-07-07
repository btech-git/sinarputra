<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number</th>
        <th style="text-align: center">Item</th>
        <th style="text-align: center; width: 5%;">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%;">PJG</th>
        <th style="text-align: center; width: 5%;">QTY PPC</th>
        <th style="text-align: center; width: 5%;">QTY</th>
        <th style="text-align: center; width: 5%;">BERAT</th>
        <th style="text-align: center; width: 5%;">MESIN</th>
        <th style="text-align: center; width: 5%;">OPERATOR</th>
        <th></th>
        <th style="text-align: center; width: 5%;">JAM MULAI</th>
        <th style="text-align: center; width: 5%;">JAM SELESAI</th>
<!--        <th style="text-align: center; width: 5%;">TANGGAL PRODUKSI</th>-->
    </tr>
    
    <?php foreach ($model->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <?php $detailCuttingReplace = ((int)$detail->productionPlanningCuttingDetail->work_order_cutting_detail_id == null) ? $detail->productionPlanningCuttingDetail->workOrderReplacementDetail : $detail->productionPlanningCuttingDetail->workOrderCuttingDetail; ?>
            <td><!--code-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]production_planning_cutting_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailCuttingReplace, 'job_number')); ?>
            </td>

            <td><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($detailCuttingReplace, 'product_name')); ?>
            </td>

            <td style="text-align: center"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'height')); ?>
                <?php echo CHtml::error($detail, 'height'); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php //if ($detail->workOrderCuttingDetailProduct->saleDetailProduct->quotationDetailProduct->product_category_id != 2) : ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'width')); ?>
                    <?php echo CHtml::error($detail, 'width'); ?>
                <?php //endif; ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length')); ?>
                <?php echo CHtml::error($detail, 'length'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningQuantity')); ?>
                <?php echo CHtml::hiddenField("production_planning_quantity_{$i}", CHtml::value($detail, 'productionPlanningQuantity')); ?>
            </td>

            <td style="text-align: center"><!--quantity-->
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'size' => 3, 'maxLength' => 10,
                    'onchange' => '
                        if (parseInt($(this).val()) > parseInt($("#production_planning_quantity_' . $i . '").val())) 
                            $(this).val($("#production_planning_quantity_' . $i . '").val()) 
                    '
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center"><!--weight-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 4')), 'id', 'fullSpecification')); ?>
                <?php echo CHtml::error($detail, 'machine_id'); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::activeHiddenField($detail, "[$i]job_group"); ?>
                <?php echo CHtml::activeDropDownList($detail, "[$i]employee_id", CHtml::listData(Employee::model()->findAll(array('condition' => 't.division_id = 5 AND t.is_inactive = 0')), 'id', 'nameAndGroup'), array(
                    'empty' => '-Pilih Operator-'
                )); ?>
                <?php echo CHtml::error($detail, 'employee_id'); ?>
            </td>

            <td style="text-align: center">
                <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $detail,
                    'attribute' => "[$i]production_date",
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
//                        'changeMonth' => 'true',
//                        'changeYear' => 'true',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                ));*/ ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]production_date"); ?>
                <?php echo CHtml::error($detail, 'production_date'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]production_time_start", array('class' => 'time_start', 'size' => 5)); ?>
                <?php echo CHtml::error($detail, 'production_time_start'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]production_time_end", array('class' => 'time_end', 'size' => 5)); ?>
                <?php echo CHtml::error($detail, 'production_time_end'); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>