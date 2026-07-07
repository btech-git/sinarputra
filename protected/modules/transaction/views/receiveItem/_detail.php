<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center; width: 15%;">Kode</th>
        <th style="text-align: center;">Nama Barang</th>
        <th style="text-align: center; width: 20%;">Description</th>
        <th style="text-align: center; width: 15%;">Kategori</th>
        <th style="text-align: center; width: 10%;">Quantity Order</th>
        <th style="text-align: center; width: 10%;">Quantity Terima</th>
        <th style="width: 5%"></th>
    </tr>

    <?php foreach ($receiveItem->details as $i => $detail): ?>
        <?php $tabIndex = $i * 4; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, "purchaseItemDetail.item.code")); ?>
            </td>
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]purchase_item_detail_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.name')); ?>
            </td>
            <td>
                <?php echo CHtml::encode(CHtml::value($detail, "purchaseItemDetail.item.description")); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.item.itemCategory.name')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::encode(CHtml::value($detail, 'purchaseItemDetail.quantity')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::activeTextField($detail, "[$i]quantity", array('size' => 10, 'maxLength' => 10)); ?>
                <?php echo CHtml::error($detail, 'quantity'); ?>
            </td>
            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php
                    echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $receiveItem->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    ));
                    ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
</table>