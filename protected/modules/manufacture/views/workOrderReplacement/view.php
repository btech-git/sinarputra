<?php
//$model as a WorkOrderCuttingHeader model

$this->breadcrumbs = array(
    'SPK Replacement' => array('qualityControlList'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1><?php echo 'SPK Replacement /' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'SPK Replacement #',
            'value' => $model->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'SPK #',
            'value' => $model->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'SO #',
            'value' => $model->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT),
        ),
        array(
            'label' => 'Customer',
            'value' => $model->workOrderCuttingHeader->saleHeader->customer->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $model->note,
        ),
    ),
));
?>
<br />

<h2>Item Penawaran Customer</h2>
    
<table style="border: 1px solid">
    <tr style="background-color: yellow">
        <th style="text-align: center;">Job Number</th>
        <th style="text-align: center;">GRADE</th>		
        <th style="text-align: center;">Tbl/Dmtr</th>
        <th style="text-align: center;">Lbr</th>
        <th style="text-align: center;">Pjg</th>
        <th style="text-align: center;">Qty</th>
        <th style="text-align: center;">Berat</th>
        <th style="text-align: center;">M</th>
        <th style="text-align: center;">SM</th>
        <th style="text-align: center;">G</th>
        <th style="text-align: center;">HT</th>
        <th style="text-align: center;">NTD</th>
        <?php if ($model->is_service == 1): ?>
            <th style="text-align: center;">CUT</th>
        <?php endif; ?>
        <th style="width: 3%"></th>
    </tr>
    <tr>
        <td colspan= <?php echo ($model->is_service == 1) ? '14' : '13'; ?> >
            <table>
                <tr>
                    <th colspan="8" style="border-right: 1px solid; text-align: center">Material Awal</th>
                    <th colspan="9" style="border-left: 1px solid; text-align: center">REQUEST CUSTOMER</th>
                </tr>
                <tr style="background-color: greenyellow">
                    <th style="text-align: center; width: 5%">Kategori</th>
                    <th style="text-align: center; width: 5%">GRADE</th>
                    <th style="text-align: center; width: 10%">Serial #</th>
                    <th style="text-align: center; width: 5%">Tbl/Dmtr</th>
                    <th style="text-align: center; width: 5%">Lbr</th>
                    <th style="text-align: center; width: 5%">Pjg</th>
                    <th style="text-align: center; width: 5%">Berat</th>
                    <th style="text-align: center; width: 10%; border-right: 1px solid">Location</th>
                    <th style="text-align: center; width: 10%; border-left: 1px solid">Serial #</th>
                    <th style="text-align: center; width: 5%">Tbl/Dmtr</th>
                    <th style="text-align: center; width: 5%">Lbr</th>
                    <th style="text-align: center; width: 5%">Pjg</th>
                    <th style="text-align: center; width: 5%">Berat</th>
                    <th style="text-align: center; width: 5%">Toleransi</th>
                    <th style="text-align: center; width: 10%">Location</th>
                    <th style="text-align: center; width: 5%">Qty</th>
                    <th style="text-align: center; width: 5%">Tipe</th>
                </tr>
            </table>
        </td>
    </tr>
    
    <?php foreach ($model->workOrderReplacementDetails as $replacementDetail): ?>
        <tr style="background-color: yellow">
            <td style="border-top: 1px solid">
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'job_number')); ?>
            </td>
            
            <td style="border-top: 1px solid">
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'product_name')); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid"><!--height-->
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'height_quote')); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid">
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'width_quote')); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid"><!--length awal-->
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'length_quote')); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid"><!--length awal-->
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'quantity')); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid"><!--weight-->
                <?php echo CHtml::encode(CHtml::value($replacementDetail, 'weight')); ?>
            </td>

            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::encode(CHtml::value($replacementDetail, 'is_miling')) == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::encode(CHtml::value($replacementDetail, 'is_sidemiling')) == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::value($replacementDetail, "is_grinding") == 1) ? "Yes" : ""; ?>
            </td>

            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::value($replacementDetail, "is_hardness") == 1) ? "Yes" : ""; ?>
            </td>
            <td style="text-align: center; border-top: 1px solid">
                <?php echo (CHtml::value($replacementDetail, "is_annelying") == 1) ? "Yes" : ""; ?>
            </td>
            <?php if ($model->is_service == 1): ?>
                <td style="text-align: center; border-top: 1px solid">
                    <?php echo (CHtml::value($replacementDetail, "is_cut") == 1) ? "Yes" : ""; ?>
                </td>
            <?php endif; ?>
            <td>
                <?php echo CHtml::link("Update", array("update", "workOrderReplacementDetailId" => $replacementDetail->id)); ?>
            </td>
        </tr>
        <tr>
            <td colspan=<?php echo ($model->is_service == 1) ? '17' : '16'; ?>>
                <table>
                    <?php foreach ($replacementDetail->workOrderCuttingDetailMaterials as $detail): ?>
                        <tr>
                            <?php $detailMaterial = ($detail->receive_detail_id === NULL) ? $detail->workOrderCuttingDetailMaterial : $detail->receiveDetail; ?>
                            <td style="width: 5%">
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'productCategory.name')); ?>
                            </td>

                            <td style="width: 5%"><!--name-->
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'product_name')); ?>
                            </td>

                            <td style="width: 10%">
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'serialConstant')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--height-->
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'height')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--width order-->
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'width')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--length awal-->
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'length')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--weight-->
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'weight')); ?>
                            </td>

                            <td style="text-align: center; border-right: 1px solid; width: 10%"><!--location-->
                                <?php echo CHtml::encode(CHtml::value($detailMaterial, 'location.name')); ?>
                            </td>
                            <td style="border-left: 1px solid; width: 10%">
                                <?php echo CHtml::encode(CHtml::value($detail, 'serialConstant')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--height-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'height')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--width order-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'width')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--length awal-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'length')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--weight-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--toleransi-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'weight_tolerance')); ?>
                            </td>

                            <td style="text-align: center; width: 10%"><!--location-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'location.name')); ?>
                            </td>

                            <td style="text-align: center; width: 5%"><!--qty order-->
                                <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                            </td>

                            <td style="text-align: center; width: 5%">
                                <?php echo CHtml::encode(CHtml::value($detail, 'materialTypeValue')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br />
    
<div id="link">
    <?php echo CHtml::link('Create', array('qualityControlList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php //if ($flagCutting == 1): ?>
        <?php echo CHtml::link('Print SPK Replacement', array('memo', 'id' => $model->id), array('target' => '_blank')); ?>
    <?php //endif; ?>
    <?php if ($flagMachining == 1) :
        echo CHtml::link('Print SPK Miling', array('memoMiling', 'id' => $model->id), array('target' => '_blank'));
    endif; ?>
</div>
