<h2>RETUR ITEM SPK POTONG <?php echo ((int)$model->header->is_service == 1) ? 'Jasa': 'Barang'; ?></h2>

<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number</th>
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center">Kategori</th>
        <th style="text-align: center; width: 5%">Tbl/Dmtr</th>
        <th style="text-align: center; width: 5%">Lbr/Dmtr</th>
        <th style="text-align: center; width: 5%">Pjg</th>
        <th style="text-align: center; width: 5%">Qty</th>
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 5%">M</th>
        <th style="text-align: center; width: 5%">SM</th>
        <th style="text-align: center; width: 5%">G</th>
        <th style="text-align: center; width: 5%">HT</th>
        <th style="text-align: center; width: 5%">NTD</th>
        <th style="text-align: center; width: 5%">QC Status</th>
        <?php if ((int)$model->header->is_service == 1): ?>
            <th style="text-align: center; width: 5%">Cut</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($model->details as $i => $detail): ?>
        <tr>
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]job_number"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'job_number')); ?>
            </td>

            <td><!--nama barang-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]work_order_cutting_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]quality_control_cutting_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]quality_control_miling_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_category_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
            </td>
            
            <td style="text-align: center"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height_quote"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]height_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'height_quote')); ?>
                <?php echo CHtml::error($detail, 'height_quote'); ?>
                <?php echo CHtml::error($detail, 'height_request'); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php if ($detail->product_category_id != 2) : ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width_quote"); ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width_request"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'width_quote')); ?>
                    <?php echo CHtml::error($detail, 'width_quote'); ?>
                    <?php echo CHtml::error($detail, 'width_request'); ?>
                <?php endif; ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_quote"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length_quote')); ?>
                <?php echo CHtml::error($detail, 'length_quote'); ?>
                <?php echo CHtml::error($detail, 'length_request'); ?>
            </td>

            <td style="text-align: center"><!--quantity-->
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 5, 'maxLength' => 10)); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>

            <td style="text-align: right"><!--weight-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]weight"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>
            
            <td style="text-align: center"><!--is miling-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]is_miling"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_miling') == 1) ? "Yes" : ""); ?>
                <?php echo CHtml::error($detail, 'is_miling'); ?>
            </td>
            
            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]is_sidemiling"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_sidemiling') == 1) ? "Yes" : ""); ?>
                <?php echo CHtml::error($detail, 'is_sidemiling'); ?>
            </td>
            
            <td style="text-align: center"><!--is Grinding-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]is_grinding"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_grinding') == 1) ? "Yes" : ""); ?>
                <?php echo CHtml::error($detail, 'is_grinding'); ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]is_hardness"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_hardness') == 1) ? "Yes" : ""); ?>
                <?php echo CHtml::error($detail, 'is_hardness'); ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]is_annelying"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_annelying') == 1) ? "Yes" : ""); ?>
                <?php echo CHtml::error($detail, 'is_annelying'); ?>
            </td>

            <td style="text-align: center">
                <?php echo 'NG'; ?>
            </td>
            
            <?php if ((int)$model->header->is_service == 1): ?>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_cut"); ?>
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_cut') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_cut'); ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>