<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th colspan="2"></th>
        <th colspan="3" style="text-align: center; border-left: 1px solid">RAW</th>
        <th colspan="3" style="text-align: center; border-left: 1px solid; border-right: 1px solid">FINISH</th>
        <th colspan="5"></th>
    </tr>
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number</th>
        <th style="text-align: center">Item</th>
        <th style="text-align: center; width: 5%; border-left: 1px solid">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%;">PJG</th>
        <th style="text-align: center; width: 5%; border-left: 1px solid">TBL/DMTR</th>
        <th style="text-align: center; width: 5%;">LBR</th>
        <th style="text-align: center; width: 5%; border-right: 1px solid">PJG</th>
        <th style="text-align: center; width: 5%;">QTY</th>
        <th style="text-align: center; width: 5%;">BERAT</th>
        <th style="text-align: center; width: 5%;">FaceMil</th>
        <th style="text-align: center; width: 5%;">SideMil</th>
        <th style="text-align: center; width: 5%;">Grinding</th>
    </tr>
    
    <?php foreach ($model->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <?php $workOrderCuttingDetail = empty($detail->work_order_cutting_detail_id) ? $detail->workOrderReplacementDetail->workOrderCuttingDetail : $detail->workOrderCuttingDetail; ?>
            <td style="border-bottom: 1px solid"><!--code-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_replacement_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'job_number')); ?>
            </td>

            <td style="border-bottom: 1px solid"><!--Product name-->
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetail, 'product_name')); ?>
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

            <td style="text-align: center; border-bottom: 1px solid"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_quote"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length_quote')); ?>
                <?php echo CHtml::error($detail, 'length_quote'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid; border-left: 1px solid"><!--height-->
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
                <?php echo CHtml::activeHiddenField($detail, "[$i]quantity"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid"><!--weight-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid">
                <?php if ((int)$workOrderCuttingDetail->is_miling === 1): ?>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id_facemil", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 2')), 'id', 'fullSpecification'), array(
                            'empty' => '-Pilih Mesin-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'machine_id_facemil'); ?>
                    </div>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]job_group_facemil", array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'), array(
                            'empty' => '-Pilih Group-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'job_group_facemil'); ?>
                    </div>
                    <div>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]planning_date_facemil",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeHolder' => '-Tgl Proses-'
                            ),
                        )); ?>
                        <?php echo CHtml::error($detail, 'planning_date_facemil'); ?>
                    </div>
                <?php endif; ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid">
                <?php if ((int)$workOrderCuttingDetail->is_sidemiling === 1): ?>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id_sidemil", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 1')), 'id', 'name'), array(
                            'empty' => '-Pilih Mesin-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'machine_id_sidemil'); ?>
                    </div>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]job_group_sidemil", array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'), array(
                            'empty' => '-Pilih Group-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'job_group_sidemil'); ?>
                    </div>
                    <div>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]planning_date_sidemil",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeHolder' => '-Tgl Proses-'
                            ),
                        )); ?>
                        <?php echo CHtml::error($detail, 'planning_date_sidemil'); ?>
                    </div>
                <?php endif; ?>
            </td>

            <td style="text-align: center; border-bottom: 1px solid">
                <?php if ((int)$workOrderCuttingDetail->is_grinding === 1): ?>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]machine_id_grinding", CHtml::listData(Machine::model()->findAll(array('condition' => 't.machine_type_id = 3')), 'id', 'name'), array(
                            'empty' => '-Pilih Mesin-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'machine_id_grinding'); ?>
                    </div>
                    <div>
                        <?php echo CHtml::activeDropDownList($detail, "[$i]job_group_grinding", array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'), array(
                            'empty' => '-Pilih Group-'
                        )); ?>
                        <?php echo CHtml::error($detail, 'job_group_grinding'); ?>
                    </div>
                    <div>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $detail,
                            'attribute' => "[$i]planning_date_grinding",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'showAnim' => 'fold',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeHolder' => '-Tgl Proses-'
                            ),
                        )); ?>
                        <?php echo CHtml::error($detail, 'planning_date_grinding'); ?>
                    </div>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>