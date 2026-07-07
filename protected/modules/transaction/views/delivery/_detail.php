<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 10%">Kategori</th>
        <th style="text-align: center; width: 10%">Tbl/Dmtr</th>
        <th style="text-align: center; width: 10%">Lbr/Dmtr</th>
        <th style="text-align: center; width: 10%">Pjg</th>
        <th style="text-align: center; width: 3%;">M</th>
        <th style="text-align: center; width: 3%;">SM</th>
        <th style="text-align: center; width: 3%;">G</th>
        <th style="text-align: center; width: 3%;">HT</th>
        <th style="text-align: center; width: 3%;">NTD</th>
        <th style="text-align: center; width: 10%">Qty QC</th>
        <th style="text-align: center; width: 10%">Qty Kirim</th>
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php foreach ($delivery->details as $i => $detail): ?>
        <tr style="background-color: azure;">
            <td style="text-align:center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.job_number')); ?>
            </td>

            <td><!--nama barang-->
                <?php echo CHtml::activeTextField($detail, "[$i]grade_name"); ?>
            </td>

            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.productCategory.name')); ?>
            </td>

            <!--height-->
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.height_request')); ?>
            </td>

            <!--width-->
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.width_request')); ?>
            </td>

            <!--length-->
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.length_request')); ?>
            </td>

            <td style="text-align: center"><!--is miling-->
                <?php echo (CHtml::value($detail, "workOrderCuttingDetail.is_miling") == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center"><!--is sidemiling-->
                <?php echo (CHtml::value($detail, "workOrderCuttingDetail.is_sidemiling") == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center"><!--is Grinding-->
                <?php echo (CHtml::value($detail, "workOrderCuttingDetail.is_grinding") == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo (CHtml::value($detail, "workOrderCuttingDetail.is_hardness") == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo (CHtml::value($detail, "workOrderCuttingDetail.is_annelying") == 1) ? "Yes" : ""; ?>
            </td>
            <!--quantity-->
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'qualityControlCuttingDetail.quantity')); ?>
            </td>

            <!--quantity-->
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]quantity"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>    

            <!--weight-->
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $delivery->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>		
    <?php endforeach; ?>
</table>