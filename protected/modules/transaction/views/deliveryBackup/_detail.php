<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 10%">Kategori</th>
        <th style="text-align: center; width: 10%">Tbl/Dmtr</th>
        <th style="text-align: center; width: 10%">Lbr/Dmtr</th>
        <th style="text-align: center; width: 10%">Pjg</th>
        <th style="text-align: center; width: 10%">Qty Kirim</th>
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 3%;">M</th>
        <th style="text-align: center; width: 3%;">SM</th>
        <th style="text-align: center; width: 3%;">G</th>
        <th style="text-align: center; width: 3%;">HT</th>
        <th style="text-align: center; width: 3%;">NTD</th>
        <th style="text-align: center; width: 3%;">COA</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <?php foreach ($deliveryBackup->details as $i => $detail): ?>
        <tr style="background-color: azure;">
            <td><!--nama barang-->
                <?php echo CHtml::activeTextField($detail, "[$i]grade_name", array('style' => 'width: 300px;')); ?>
                <?php echo CHtml::error($detail, 'grade_name'); ?>
            </td>

            <td style="text-align:center">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_category_id", CHtml::listData(ProductCategory::model()->findAll(), 'id', 'name'), array(
                    'empty' => '-Select Category-',
                )); ?>
                <?php echo CHtml::error($detail, 'product_category_id'); ?>
            </td>
            
            <!--height-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]height", array('style' => 'width: 100px;')); ?>
                <?php echo CHtml::error($detail, 'height'); ?>
            </td>

            <!--height-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]width", array('style' => 'width: 100px;')); ?>
                <?php echo CHtml::error($detail, 'width'); ?>
            </td>

            <!--height-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]length", array('style' => 'width: 100px;')); ?>
                <?php echo CHtml::error($detail, 'length'); ?>
            </td>

            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('style' => 'width: 100px;')); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>    

            <!--weight-->
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]weight", array('style' => 'width: 100px;')); ?>
                <?php echo CHtml::error($detail, 'weight'); ?>
            </td>

            <td style="text-align: center"><!--is miling-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_miling"); ?>
                <?php echo CHtml::error($detail, 'is_miling'); ?>
            </td>

            <td style="text-align: center"><!--is sidemiling-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_sidemiling"); ?>
                <?php echo CHtml::error($detail, 'is_sidemiling'); ?>
            </td>

            <td style="text-align: center"><!--is Grinding-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_grinding"); ?>
                <?php echo CHtml::error($detail, 'is_grinding'); ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_hardness"); ?>
                <?php echo CHtml::error($detail, 'is_hardness'); ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_annelying"); ?>
                <?php echo CHtml::error($detail, 'is_annelying'); ?>
            </td>
            
            <td style="text-align: center"><!--is coating-->
                <?php echo CHtml::activeCheckBox($detail, "[$i]is_coating"); ?>
                <?php echo CHtml::error($detail, 'is_coating'); ?>
            </td>
            
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $deliveryBackup->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(
                        ActiveRecord::ACTIVE => 'Active', 
                        ActiveRecord::INACTIVE => 'Inactive'
                    )); ?>
                <?php endif; ?>
            </td>
        </tr>		
    <?php endforeach; ?>
</table>