<?php
Yii::app()->clientScript->registerCss('detail', '
		.detailAlignRight {
			text-align: right;
		}
	');
?>
<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center;">Job Number</th>
        <th style="text-align: center;" colspan="5">Permintaan</th>
        <th style="text-align: center; border-left: 2px solid;" colspan="5">Penawaran</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">Kategori</th>
        <th style="text-align: center;">Harga Satuan</th>
        <th style="text-align: center;">Total</th>
        <th style="text-align: center; width: 5%"></th>
    </tr>

    <tr style="background-color: skyblue">
        <th></th>
        <th>GRADE</th>
        <th>Tbl/Dmtr</th>
        <th>Lbr/Dmtr</th>
        <th>Pjg</th>
        <th>Qty.</th>
        <th style="border-left: 2px solid;">GRADE</th>
        <th>Tbl/Dmtr</th>
        <th>Lbr/Dmtr</th>
        <th>Pjg</th>
        <th>Qty.</th>
        <th colspan="5"></th>
    </tr>

    <?php foreach ($sale->saleDetails as $i => $detail): ?>
        <?php $detailProductService = ((int)$sale->header->is_service === 0) ? $detail->quotationDetailProduct : $detail->quotationDetailService; ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeHiddenField($detail, "[$i]quotation_detail_product_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]quotation_detail_service_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'job_number')); ?>
            </td>
            <!--nama barang request-->
            <td>
                <?php echo CHtml::encode(CHtml::value($detailProductService, ((int)$sale->header->is_service === 0) ? 'product_name_request' : 'product_name')); ?>
            </td>

            <!--height request-->
            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'height_request')); ?>
            </td>

            <!--width request-->
            <td style="text-align:center">
                <?php if ($detailProductService->product_category_id != 2): ?>
                    <?php echo CHtml::encode(CHtml::value($detailProductService, 'width_request')); ?>
                <?php else: ?>
                    <?php echo '0.00'; ?>
                <?php endif; ?>
            </td>
                        
            <!--length request-->
            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'length_request')); ?>
            </td>

            <!--quantity request-->
            <td style="text-align:center">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProductService, 'quantity_request'))); ?>
            </td>

<!--            BAGIAN PENAWARAN -->

            <!--nama barang quote-->
            <td style="border-left: 2px solid;">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'product_name_quote')); ?>
            </td>

            <!--height quote-->
            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'height_quote')); ?>
            </td>

            <!--width quote-->
            <td style="text-align:center">
                <?php if ($detailProductService->product_category_id != 2) :?>
                    <?php echo CHtml::encode(CHtml::value($detailProductService, 'width_quote')); ?>
                <?php else: ?>
                    <?php echo '0.00'; ?>
                <?php endif; ?>
            </td>

            <!--length quote-->
            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'length_quote')); ?>
            </td>

            <!--quantity quote-->
            <td style="text-align:center">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProductService, 'quantity_quote'))); ?>
            </td>

            <!--weight-->
            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'weight')); ?>
            </td>

            <!--kategori-->
            <td style="text-align:center">
                <?php echo CHtml::encode(CHtml::value($detailProductService, 'productCategory.name')); ?>
            </td>

            <!--unit price-->
            <td class="detailAlignRight">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'unit_price'))); ?>
            </td>

            <!--total-->
            <td class="detailAlignRight">
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'total'))); ?>
            </td>

            <td>
                <?php if ($detail->isNewRecord): ?>
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $sale->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                <?php else: ?>
                    <?php echo CHtml::activeDropDownList($detail, "[$i]is_inactive", array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>
    <tr style="background-color: aquamarine">
        <td colspan="5" style="font-weight: bold; text-align: right">Total Quantity: </td>
        <td style="text-align: center">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($sale, 'totalQuantityRequest'))); ?>
        </td>
        <td colspan="4"></td>
        <td style="text-align: center">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($sale, 'totalQuantityQuote'))); ?>
        </td>
        <td style="font-weight: bold; text-align: right" colspan="3">Grand Total: </td>
        <td style="text-align: right">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($sale, 'grandTotal'))); ?>
        </td>
        <td></td>
    </tr>
</table>
