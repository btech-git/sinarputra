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
                <?php echo CHtml::label('Catatan PPC', ''); ?>
                <?php echo CHtml::activeTextArea($model->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($model->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('SPK Replacement #', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'work_order_replacement_number')); ?>
                <?php if (isset($model->header->workOrderReplacementHeader)): ?>
                    <?php echo CHtml::encode($model->header->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)); ?>
                <?php endif; ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Date', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'work_order_replacement_date')); ?>
                <?php echo CHtml::encode(CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($model->header, 'workOrderReplacementHeader.date')))); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'work_order_replacement_customer')); ?>
                <?php echo CHtml::encode(CHtml::value($model->header, 'workOrderReplacementHeader.workOrderCuttingHeader.saleHeader.customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
        <?php if (count($model->details) > 0): ?>
            <?php $this->renderPartial('_detail', array(
                'model' => $model
            )); ?>
        <?php endif; ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
