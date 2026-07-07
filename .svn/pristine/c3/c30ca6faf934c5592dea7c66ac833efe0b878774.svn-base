<?php

?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($qualityControl->header, 'error'); ?>

    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php echo CHtml::activeHiddenField($qualityControl->header, 'date'); ?>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $qualityControl->header->date)); ?>
                <?php echo CHtml::error($qualityControl->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan QC', ''); ?>
                <?php echo CHtml::activeTextArea($qualityControl->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($qualityControl->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('SPK #', ''); ?>
                <?php echo CHtml::encode($qualityControl->header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal SPK', ''); ?>
                <?php echo CHtml::encode(CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($qualityControl->header, 'workOrderCuttingHeader.date')))); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Produksi #', ''); ?>
                <?php echo CHtml::encode($qualityControl->header->productionCuttingHeader->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Tanggal Produksi', ''); ?>
                <?php echo CHtml::encode(CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($qualityControl->header, 'productionCuttingHeader.date')))); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::encode(CHtml::value($qualityControl->header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('SPK Note', ''); ?>
                <?php echo CHtml::encode(CHtml::value($qualityControl->header, 'productionHeader.jobOrderHeader.workOrderCuttingHeader.note')); ?>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
        <?php if (count($qualityControl->details) > 0): ?>
            <?php $this->renderPartial('_detail', array(
                'qualityControl' => $qualityControl,
                false, true
            )); ?>
        <?php endif; ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
