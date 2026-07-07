<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number</th>
        <th style="text-align: center">Item</th>
        <th style="text-align: center; width: 5%;">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%;">PJG</th>
        <th style="text-align: center; width: 5%;">QTY SPK</th>
        <th style="text-align: center; width: 5%;">QTY</th>
        <th style="text-align: center; width: 5%;">BERAT</th>
        <th style="text-align: center; width: 5%;">MESIN</th>
        <th style="text-align: center; width: 5%;">GROUP</th>
        <th style="text-align: center; width: 5%;">TANGGAL PROSES</th>
        <th style="text-align: center; width: 5%;">URGENT</th>
    </tr>
    
    <?php foreach ($model->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <?php $workOrderCuttingDetail = empty($detail->work_order_cutting_detail_id) ? $detail->workOrderReplacementDetail->workOrderCuttingDetail : $detail->workOrderCuttingDetail; ?>
            <td><!--code-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_replacement_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'job_number')); ?>
            </td>

            <td><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'product_name')); ?>
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
                <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.quantityProductionPlanningCuttingRemaining')); ?>
            </td>

            <td style="text-align: center"><!--quantity-->
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 2, 'maxLength' => 8)); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center"><!--weight-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 4')), 'id', 'fullSpecification'), array(
                    'empty' => '-Pilih-',
                )); ?>
                <?php echo CHtml::error($detail, 'machine_id'); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]job_group", array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'), array(
                    'empty' => '-Pilih-'
                )); ?>
                <?php echo CHtml::error($detail, 'job_group'); ?>
            </td>

            <td style="text-align: center">
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $detail,
                    'attribute' => "[$i]planning_date",
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'showAnim' => 'fold',
//                        'changeMonth' => 'true',
//                        'changeYear' => 'true',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'size' => 5,
                    ),
                )); ?>
                <?php echo CHtml::error($detail, 'planning_date'); ?>
            </td>
            
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'urgentStatus')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>