<div class="form">
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($model); ?>
    
    <div class="container">
        <div class="span-12">
            <?php if (!$model->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Pembelian Invoice #', false); ?>
                    <?php $isTax = empty($model->receive_header_id) ? $model->receiveItemHeader->purchaseItemHeader->is_tax : $model->receiveHeader->purchaseHeader->is_tax; ?>
                    <?php if ((int) $isTax == 0) : ?>        
                        <?php echo CHtml::encode($model->getCodeNumber(PurchaseInvoice::CN_CONSTANT_NON_TAX)); ?>
                    <?php else: ?>
                        <?php echo CHtml::encode($model->getCodeNumber(PurchaseInvoice::CN_CONSTANT_TAX)); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($model, 'date'); ?>
            </div>
            <?php if (empty($receiveItemHeader)): ?>
                <div class="row">
                    <?php echo CHtml::label('Penerimaan Material #', ''); ?>
                    <?php echo CHtml::encode($model->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)); ?>
                </div>
                <div class="row">
                    <?php echo CHtml::label('Date', ''); ?>
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $model->receiveHeader->date)); ?>
                </div>
                <div class="row">
                    <?php echo CHtml::label('Supplier', ''); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'supplier.company')); ?>
                </div>
                <div class="row">
                    <?php echo CHtml::label('Note', ''); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'receiveHeader.note')); ?>
                </div>
            <?php else: ?>            
                <div class="row">
                    <?php echo CHtml::label('Penerimaan Barang Penunjang #', ''); ?>
                    <?php echo CHtml::encode($model->receiveItemHeader->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)); ?>
                </div>
                <div class="row">
                    <?php echo CHtml::label('Date', ''); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'receiveItemHeader.date')); ?>
                </div>
                <div class="row">
                    <?php echo CHtml::label('Supplier', ''); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'supplier.company')); ?>
                </div>
                <div class="row">
                    <?php echo CHtml::label('Note', ''); ?>
                    <?php echo CHtml::encode(CHtml::value($model, 'receiveItemHeader.note')); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Material / Barang Penunjang', FALSE); ?>
                <?php echo CHtml::activeHiddenField($model, 'is_item'); ?>
                <?php echo CHtml::encode(CHtml::value($model, 'purchasingStatus')); ?>
                <?php echo CHtml::error($model, 'is_item'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('No. Dok', ''); ?>
                <?php echo CHtml::activeTextField($model, 'supplier_document_number'); ?>
                <?php echo CHtml::error($model, 'supplier_document_number'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Faktur Pajak', ''); ?>
                <?php echo CHtml::activeTextField($model, 'supplier_invoice_tax_number'); ?>
                <?php echo CHtml::error($model, 'supplier_invoice_tax_number'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($model, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($model, 'note'); ?>
            </div>
        </div>
    </div>

    <hr />

    <?php if (empty($receiveItemHeader)): ?>
        <div id="detail_div">
            <?php $this->renderPartial('_detail', array(
                'model' => $model,
                'receiveHeader' => $receiveHeader
            )); ?>
        </div>
    <?php else: ?>    
        <div id="detail_item_div">
            <?php $this->renderPartial('_detail_item', array(
                'model' => $model,
                'receiveItemHeader' => $receiveItemHeader,
            )); ?>
        </div>
    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

<?php echo CHtml::endForm(); ?>

</div><!-- form -->