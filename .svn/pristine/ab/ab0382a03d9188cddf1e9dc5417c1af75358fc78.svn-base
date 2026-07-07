<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th colspan="2"></th>
        <th colspan="3" style="border-left: 1px solid; border-right: 1px solid; text-align: center">RAW</th>
        <th colspan="3" style="border-right: 1px solid; text-align: center">FINISH</th>
        <th colspan="8"></th>
    </tr>
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number</th>
        <th style="text-align: center; width: 10%">Item</th>
        <th style="text-align: center; width: 5%; border-left: 1px solid">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%; border-right: 1px solid">PJG</th>
        <th style="text-align: center; width: 5%;">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%; border-right: 1px solid">PJG</th>
        <th style="text-align: center; width: 5%;">QTY SPK</th>
        <th style="text-align: center; width: 5%;">QTY</th>
        <th style="text-align: center; width: 5%;">BERAT</th>
        <th style="text-align: center; width: 5%;">FaceMil</th>
        <th style="text-align: center; width: 5%;">SideMil</th>
        <th style="text-align: center; width: 5%;">Grinding</th>
        <th style="text-align: center; width: 5%;">JAM MULAI</th>
        <th style="text-align: center; width: 5%;">JAM SELESAI</th>
    </tr>
    
    <?php foreach ($model->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td style="border-bottom: 1px solid"><!--code-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]production_planning_miling_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.job_number')); ?>
            </td>

            <td style="border-bottom: 1px solid"><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.product_name')); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid; border-left: 1px solid"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height_quote"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'height_quote')); ?>
                <?php echo CHtml::error($detail, 'height_quote'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--width-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]width_quote"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'width_quote')); ?>
                <?php echo CHtml::error($detail, 'width_quote'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid; border-right: 1px solid"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_quote"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length_quote')); ?>
                <?php echo CHtml::error($detail, 'length_quote'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'height_request')); ?>
                <?php echo CHtml::error($detail, 'height_request'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--width-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]width_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'width_request')); ?>
                <?php echo CHtml::error($detail, 'width_request'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid; border-right: 1px solid"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length_request')); ?>
                <?php echo CHtml::error($detail, 'length_request'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--quantity-->
                <?php echo CHtml::hiddenField("production_planning_quantity_{$i}", CHtml::value($detail, 'productionPlanningMilingDetail.quantityMilingProductionRemaining')); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.quantityMilingProductionRemaining')); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--quantity-->
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array(
                    'maxLength' => 10, 'size' => 5,
                    'onchange' => '
                        if (parseInt($(this).val()) > parseInt($("#production_planning_quantity_' . $i . '").val())) 
                            $(this).val($("#production_planning_quantity_' . $i . '").val()) 
                    '
                )); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--weight-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid">
                <?php if ((int)$detail->productionPlanningMilingDetail->workOrderCuttingDetail->is_miling === 1): ?>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id_facemil", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 2')), 'id', 'fullSpecification'), array(
                            'empty' => '-Pilih Mesin-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'machine_id_facemil'); ?>
                    </div>
                    <div>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]job_group_facemil"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'job_group_facemil')); ?>
                        <?php echo CHtml::error($detail, 'job_group_facemil'); ?>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]employee_id_facemil", CHtml::listData(Employee::model()->findAll(array('condition' => 't.division_id = 2 AND t.is_inactive = 0')), 'id', 'nameAndGroup'), array(
                            'empty' => '-Pilih Operator-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'employee_id_facemil'); ?>
                    </div>
                    <div>
                        <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]production_date_facemil",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeHolder' => '-Tgl Proses-'
                            ),
                        ));*/ ?>
                        
                        <?php echo CHtml::activeHiddenField($detail, "[$i]production_date_facemil"); ?>
                        <?php echo CHtml::error($detail, 'production_date_facemil'); ?>
                    </div>
                <?php endif; ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid">
                <?php if ((int)$detail->productionPlanningMilingDetail->workOrderCuttingDetail->is_sidemiling === 1): ?>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id_sidemil", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 1')), 'id', 'name'), array(
                            'empty' => '-Pilih Mesin-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'machine_id_sidemil'); ?>
                    </div>
                    <div>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]job_group_sidemil"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'job_group_sidemil')); ?>
                        <?php echo CHtml::error($detail, 'job_group_sidemil'); ?>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]employee_id_sidemil", CHtml::listData(Employee::model()->findAll(array('condition' => 't.division_id = 2 AND t.is_inactive = 0')), 'id', 'nameAndGroup'), array(
                            'empty' => '-Pilih Operator-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'employee_id_sidemil'); ?>
                    </div>
                    <div>
                        <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]production_date_sidemil",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeHolder' => '-Tgl Proses-'
                            ),
                        ));*/ ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]production_date_sidemil"); ?>
                        <?php echo CHtml::error($detail, 'production_date_sidemil'); ?>
                    </div>
                <?php endif; ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid">
                <?php if ((int)$detail->productionPlanningMilingDetail->workOrderCuttingDetail->is_grinding === 1): ?>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id_grinding", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 3')), 'id', 'name'), array(
                            'empty' => '-Pilih Mesin-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'machine_id_grinding'); ?>
                    </div>
                    <div>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]job_group_grinding"); ?>
                        <?php echo CHtml::encode(CHtml::value($detail, 'job_group_grinding')); ?>
                        <?php echo CHtml::error($detail, 'job_group_grinding'); ?>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]employee_id_grinding", CHtml::listData(Employee::model()->findAll(array('condition' => 't.division_id = 2 AND t.is_inactive = 0')), 'id', 'nameAndGroup'), array(
                            'empty' => '-Pilih Operator-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'employee_id_grinding'); ?>
                    </div>
                    <div>
                        <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]production_date_grinding",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeHolder' => '-Tgl Proses-'
                            ),
                        ));*/ ?>
                        <?php echo CHtml::activeHiddenField($detail, "[$i]production_date_grinding"); ?>
                        <?php echo CHtml::error($detail, 'production_date_grinding'); ?>
                    </div>
                <?php endif; ?>
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