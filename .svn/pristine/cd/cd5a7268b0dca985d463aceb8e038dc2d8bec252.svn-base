<?php
?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model->header, 'error'); ?>

    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$model->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd'
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                        'placeHolder' => '-Pilihan-'
                    ),
                )); ?>
                <?php echo CHtml::error($model->header, 'date'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('SPK #', ''); ?>
                <?php echo CHtml::encode(($model->header->workOrderCuttingHeader === null) ? $workOrderReplacement->getCodeNumber(workOrderReplacementHeader::CN_CONSTANT) : $workOrderCutting->getCodeNumber(workOrderCuttingHeader::CN_CONSTANT)); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo (($model->header->workOrderCuttingHeader === null) ? CHtml::encode(CHtml::value($workOrderReplacement, 'workOrderCuttingHeader.saleHeader.customer.company')) : CHtml::encode(CHtml::value($workOrderCutting, 'saleHeader.customer.company'))); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Catatan PPC', ''); ?>
                <?php echo CHtml::activeTextArea($model->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($model->header, 'note'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'model' => $model
        )); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
