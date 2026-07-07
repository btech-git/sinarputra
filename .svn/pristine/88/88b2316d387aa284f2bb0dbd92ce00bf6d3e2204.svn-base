<h2>Jasa</h2>
<?php
//$model as WorkOrderCuttingComponent component model
?>
<?php echo CHtml::error($model->header, 'error'); ?>

<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">GRADE</th>
        <th style="text-align: center; width: 5%">Tbl/Dmtr</th>
        <th style="text-align: center; width: 5%">Lbr/Dmtr</th>
        <th style="text-align: center; width: 5%">Pjg</th>
        <th style="text-align: center; width: 5%;">Qty</th>
        <th style="text-align: center; width: 10%">Berat</th>
        <th style="text-align: center; width: 5%">M</th>
        <th style="text-align: center; width: 5%">SM</th>
        <th style="text-align: center; width: 5%">G</th>
        <th style="text-align: center; width: 5%">HT</th>
        <th style="text-align: center; width: 5%">NTD</th>

    </tr>

    <?php foreach ($model->details as $i => $detail): ?>
        <tr>
            <td><!--nama barang-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]sale_detail_service_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'saleDetailService.quotationDetailService.product_name')); ?>
            </td>

            <td style="text-align: center"><!--height-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]height"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'saleDetailService.quotationDetailService.height_quote')); ?>
                <?php echo CHtml::error($detail, 'height'); ?>
            </td>

            <td style="text-align: center"><!--width-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]width"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'saleDetailService.quotationDetailService.width_quote')); ?>
                <?php echo CHtml::error($detail, 'width'); ?>
            </td>

            <td style="text-align: center"><!--length-->
                <?php echo CHtml::activeHiddenField($detail, "[$i]length"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'saleDetailService.quotationDetailService.length_quote')); ?>
                <?php echo CHtml::error($detail, 'length'); ?>
            </td>

            <td style="text-align: center"><!--quantity-->
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'saleDetailService.quotationDetailService.quantity_quote'))); ?>
            </td>

            <td style="text-align: center"><!--weight-->
                <?php echo CHtml::encode(CHtml::value($detail, 'saleDetailService.quotationDetailService.weight')); ?>
            </td>

            <td style="text-align: center"><!--is miling-->
                <?php echo CHtml::encode((CHtml::value($detail, 'saleDetailService.quotationDetailService.is_miling') == 1) ? "Yes" : ""); ?>
            </td>

            <td style="text-align: center"><!--is Grinding-->
                <?php echo CHtml::encode((CHtml::value($detail, 'saleDetailService.quotationDetailService.is_grinding') == 1) ? "Yes" : ""); ?>
            </td>

            <td style="text-align: center"><!--is hardness-->
                <?php echo CHtml::encode((CHtml::value($detail, 'saleDetailService.quotationDetailService.is_hardness') == 1) ? "Yes" : ""); ?>
            </td>

            <td style="text-align: center"><!--is annelying-->
                <?php echo CHtml::encode((CHtml::value($detail, 'saleDetailService.quotationDetailService.is_annelying') == 1) ? "Yes" : ""); ?>
            </td>

            <td style="text-align: center"><!--is sidemiling-->
                <?php echo CHtml::encode((CHtml::value($detail, 'saleDetailService.quotationDetailService.is_sidemiling') == 1) ? "Yes" : ""); ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>