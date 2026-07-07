<?php 
    Yii::app()->clientScript->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css');
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
                <?php echo CHtml::label('Catatan Produksi', ''); ?>
                <?php echo CHtml::activeTextArea($model->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($model->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('PPC #', ''); ?>
                <?php if (isset($model->header->productionPlanningCuttingHeader)): ?>
                    <?php echo CHtml::encode($model->header->productionPlanningCuttingHeader->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)); ?>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Date', ''); ?>
                <?php echo CHtml::encode(CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($model->header, 'productionPlanningCuttingHeader.date')))); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('SPK #', ''); ?>
                <?php if (isset($model->header->productionPlanningCuttingHeader->workOrderCuttingHeader)): ?>
                    <?php echo CHtml::encode($model->header->productionPlanningCuttingHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?>
                <?php endif; ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::encode(CHtml::value($model->header, 'productionPlanningCuttingHeader.workOrderCuttingHeader.saleHeader.customer.company')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Note SPK', ''); ?>
                <?php echo CHtml::encode(CHtml::value($model->header, 'productionPlanningCuttingHeader.workOrderCuttingHeader.note')); ?>
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

<?php 
    Yii::app()->clientScript->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScriptFile('https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-sliderAccess.js', CClientScript::POS_END);
    Yii::app()->clientScript->registerScript('timepicker', "
        $('.time_start').timepicker({
            timeFormat: 'HH:mm:ss'
        });
        $('.time_end').timepicker({
            timeFormat: 'HH:mm:ss'
        });
    ");
?>