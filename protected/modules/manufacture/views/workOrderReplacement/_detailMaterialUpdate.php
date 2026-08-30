<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th colspan="7" style="text-align: center; border-right: 1px solid; border-bottom: 1px solid">Material Awal</th>
        <th colspan="8" style="text-align: center; border-left: 1px solid; border-bottom: 1px solid">Sisa Potong</th>
    </tr>
    <tr style="background-color: skyblue">
        <th style="text-align: center;">GRADE</th>
        <th style="text-align: center;">Category</th>
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center; border-right: 1px solid">Location</th>
        <th style="text-align: center; border-left: 1px solid">Category</th>	
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">Toleransi</th>
        <th style="text-align: center;">Location</th>
        <th style="text-align: center;">Tipe</th>
    </tr>

    <?php foreach ($workOrderReplacementDetailComponent->details as $i => $detail): ?>
        <tr>
            <?php $detailTransaction = empty($detail->receive_detail_id) ? $detail->workOrderReplacementDetailMaterial : $detail->receiveDetail; ?> 
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'product_name')); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'productCategory.name')); ?>
            </td>

            <!--height-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'height')); ?>
            </td>

            <!--width order-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'width')); ?>
            </td>

            <!--length awal-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'length')); ?>
            </td>

            <!--weight-->
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'weight')); ?>
            </td>

            <!--location-->
            <td style="text-align: center; border-right: 1px solid">
                <?php echo CHtml::encode(CHtml::value($detailTransaction, 'location.name')); ?>
            </td>
            
            <td style="text-align: center; border-left: 1px solid">
                <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name'));?>
            </td>
            
            <?php if ($detail->is_offcart) : ?>
                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]height", array('size' => 5));?>
                </td>

                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]width", array('size' => 5));?>
                </td>

                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]length", array('size' => 5));?>
                </td>

                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 5));?>
                </td>
            <?php else : ?>
                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]height", array('size' => 5));?>
                </td>

                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]width", array('size' => 5));?>
                </td>

                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]length", array('size' => 5));?>
                </td>

                <td style="text-align: center;">
                    <?php echo CHtml::activeTextField($detail, "[$i]weight", array('size' => 5));?>
                </td>
            <?php endif; ?>

            <td style="text-align: center;"><!--toleransi-->
                <?php echo CHtml::activeTextField($detail, "[$i]weight_tolerance", array('size' => 5)); ?>
                <?php echo CHtml::error($detail, 'weight_tolerance'); ?>
            </td>


            <td style="text-align: center;"><!--location-->
                <?php echo CHtml::activeDropDownList($detail, "[$i]location_id", CHtml::listData(Location::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => '-Location-'
                )); ?>
                <?php echo CHtml::error($detail, 'location_id'); ?>
            </td>

            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($detail, 'materialTypeValue'));?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>