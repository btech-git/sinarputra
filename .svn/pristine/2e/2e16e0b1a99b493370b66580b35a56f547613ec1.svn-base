<?php
//$model as WorkorderCuttingComponent component model
?>

<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model->header); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('SPK #', false); ?>
                <span id="sale_header_number_span_cn">
                    <?php echo isset($model->header->saleHeader) ? CHtml::encode($model->header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : ''; ?>
                </span>
            </div>

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
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($model->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($model->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <strong>SO #: </strong>
                <?php echo isset($model->header->saleHeader) ? CHtml::encode($model->header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : ''; ?>
            </div>

            <div class="row">
                <strong>Tanggal SO: </strong>
                <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($model->header, 'saleHeader.date'))); ?>
            </div>

            <div class="row">
                <strong>Customer: </strong>
                <?php echo CHtml::encode(CHtml::value($model->header, 'saleHeader.customer.company')); ?>
            </div>
            
            <div class="row">
                <strong>PO Customer #: </strong>
                <?php echo CHtml::encode(CHtml::value($model->header, 'saleHeader.customer_order_number')); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Pending ? ', ''); ?>
                <?php echo CHtml::activeCheckBox($model->header, 'is_pending'); ?>
            </div>
            <div class="row">
                <strong>Sales Order Note: </strong>
                <span id="sale_header_note">
                    <?php echo CHtml::encode(CHtml::value($model->header, 'saleHeader.note')); ?>
                </span>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_product_div">
        <?php if (count($model->details) > 0) : ?>
            <?php $this->renderPartial('_detailProduct', array(
                'model' => $model
            )); ?>
        <?php endif; ?>
    </div>

    <br />

    <div class="row buttons">
        <?php echo CHtml::submitButton('Next', array('name' => 'Next', 'confirm' => 'Are you sure you want to next?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
