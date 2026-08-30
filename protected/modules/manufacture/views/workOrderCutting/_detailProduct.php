<h2>Sales Order <?php echo ((int)$model->header->saleHeader->is_service == 1) ? 'Jasa': 'Barang'; ?></h2>

<?php
//$model as WorkOrderComponent component model
?>
<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th colspan="3">&nbsp;</th>
        <th colspan="3" style="text-align: center; border-left: 1px solid; border-right: 1px solid">Awal</th>
        <th colspan="3" style="text-align: center; border-left: 1px solid; border-right: 1px solid">Finish</th>
        <th colspan=<?php echo ((int)$model->header->saleHeader->is_service == 1) ? "13" : "12";?>>&nbsp;</th>
    </tr>

    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 10%">Job Number</th>
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center">Kategori</th>
        <th style="text-align: center; width: 5%; border-left: 1px solid">Tbl/Dmtr</th>
        <th style="text-align: center; width: 5%">Lbr/Dmtr</th>
        <th style="text-align: center; width: 5%; border-right: 1px solid">Pjg</th>
        <th style="text-align: center; width: 5%; border-left: 1px solid">Tbl/Dmtr</th>
        <th style="text-align: center; width: 5%">Lbr/Dmtr</th>
        <th style="text-align: center; width: 5%; border-right: 1px solid">Pjg</th>
        <th style="text-align: center; width: 5%">Qty</th>
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 5%">M</th>
        <th style="text-align: center; width: 5%">SM</th>
        <th style="text-align: center; width: 5%">G</th>
        <th style="text-align: center; width: 5%">HT</th>
        <th style="text-align: center; width: 5%">NTD</th>
        <th style="text-align: center; width: 5%">COA</th>
        <?php if ((int)$model->header->saleHeader->is_service == 1): ?>
            <th style="text-align: center; width: 5%">Cut</th>
        <?php endif; ?>
        <th style="text-align: center; width: 5%">Kirim</th>
        <th style="text-align: center; width: 5%">Urgent</th>
        <th style="text-align: center; width: 5%">Order Luar</th>
        <th style="text-align: center; width: 5%">MH PIC</th>
    </tr>

    <?php foreach ($model->details as $i => $detail): ?>
        <tr>
            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]job_number"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'job_number')); ?>
            </td>

            <td><!--nama barang-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]sale_detail_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_name"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_category_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
            </td>
            
            <td style="text-align: center"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height_quote"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'height_quote')); ?>
                <?php echo CHtml::error($detail, 'height_quote'); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php if ($detail->product_category_id != 2) : ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width_quote"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'width_quote')); ?>
                    <?php echo CHtml::error($detail, 'width_quote'); ?>
                <?php endif; ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_quote"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length_quote')); ?>
                <?php echo CHtml::error($detail, 'length_quote'); ?>
            </td>

            <td style="text-align: center"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'height_request')); ?>
                <?php echo CHtml::error($detail, 'height_request'); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php if ($detail->product_category_id != 2) : ?>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]width_request"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'width_request')); ?>
                    <?php echo CHtml::error($detail, 'width_request'); ?>
                <?php endif; ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length_request"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'length_request')); ?>
                <?php echo CHtml::error($detail, 'length_request'); ?>
            </td>

            <td style="text-align: center"><!--quantity-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]quantity"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?>
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
                <?php echo CHtml::activeHiddenField($detail, "[$i]is_coating"); ?>
                <?php echo CHtml::encode((CHtml::value($detail, 'is_coating') == 1) ? "Yes" : ""); ?>
                <?php echo CHtml::error($detail, 'is_coating'); ?>
            </td>

            <?php if ((int)$model->header->saleHeader->is_service == 1): ?>
                <td style="text-align: center">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]is_cut"); ?>
                    <?php echo CHtml::encode((CHtml::value($detail, 'is_cut') == 1) ? "Yes" : ""); ?>
                    <?php echo CHtml::error($detail, 'is_cut'); ?>
                </td>
            <?php endif; ?>

            <td style="text-align: center"><!--is external order-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_delivery"); ?>
            </td>

            <td style="text-align: center"><!--is external order-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_urgent"); ?>
            </td>

            <td style="text-align: center"><!--is external order-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_external_order"); ?>
            </td>
            
            <td style="text-align: center;">
                <?php echo CHtml::activeDropDownList($detail, "[$i]employee_id", CHtml::listData(Employee::model()->findAll(array(
                    'condition' => 't.division_id = 9 AND t.is_inactive = 0',
                    'order' => 't.name ASC',
                )), 'id', 'nameAndGroup'), array(
                    'empty' => '-Pilih MH-'
                )); ?>
                <?php echo CHtml::error($detail, 'employee_id'); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>