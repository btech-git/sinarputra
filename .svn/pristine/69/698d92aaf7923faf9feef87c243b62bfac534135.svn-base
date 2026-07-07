
<div class="form">

    <?php echo CHtml::beginForm(); ?>
    
    <div class="span-12">
        <div class="row">
            <?php echo CHtml::label('SPK Replacement#', false); ?>
            <?php echo CHtml::encode($workOrderReplacementDetail->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)); ?>
        </div>

        <div class="row">
            <?php echo CHtml::label('Tanggal', false); ?>
            <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $workOrderReplacementDetail->workOrderReplacementHeader->date)); ?>
        </div>
    </div>
    
    <div class="span-12 last">
        <div class="row">
            <?php echo CHtml::label('Customer', ''); ?>
            <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'workOrderReplacementHeader.workOrderCuttingHeader.saleHeader.customer.company')); ?>
        </div>
        
        <div class="row">
            <?php echo CHtml::label('Catatan', ''); ?>
            <?php echo CHtml::encode($workOrderReplacementDetail->workOrderReplacementHeader->note); ?>
        </div>
    </div>
    
    <hr />

    <table style="border: 1px solid">
        <tr style="background-color: skyblue">
            <th style="text-align: center;">Kategori</th>
            <th style="text-align: center;">GRADE</th>
            <th style="text-align: center;">Tbl/Dmtr</th>
            <th style="text-align: center;">Lbr</th>
            <th style="text-align: center;">Pjg</th>
            <th style="text-align: center;">Jumlah</th>
            <th style="text-align: center;">Berat</th>
            <th style="text-align: center;">Kirim</th>
            <th style="text-align: center;">Urgent</th>
        </tr>
        <tr>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'productCategory.name')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'product_name')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'height_request')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'width_request')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'length_request')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'quantity')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'weight')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'deliveryStatus')); ?>
            </td>
            <td style="text-align: center;">
                <?php echo CHtml::encode(CHtml::value($workOrderReplacementDetail, 'urgentStatus')); ?>
            </td>
        </tr>
    </table>

    <br/>

    <div id="detail_div">
        <?php $this->renderPartial('_detailMaterialUpdate', array(
            'workOrderReplacementDetail' => $workOrderReplacementDetail,
            'workOrderReplacementDetailComponent' => $workOrderReplacementDetailComponent,
        )); ?>
    </div> 

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton('Update', array('name' => 'Submit', 'confirm' => 'Are you sure you want to Update?')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
