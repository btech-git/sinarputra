<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($delivery->header); ?>
    <div class="container">
        <div class="span-12">
            <?php if (!$delivery->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Pengiriman #', false); ?>
                    <?php echo CHtml::encode($delivery->header->getCodeNumber(ManualDeliveryHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$delivery->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($delivery->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Gudang', '', array('required' => true)); ?>
                <?php echo CHtml::activeDropDownList($delivery->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- Pilih Gudang --')); ?>
                <?php echo CHtml::error($delivery->header, 'warehouse_id'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($delivery->header, 'note', array(
                    'rows' => 5, 
                    'cols' => 30, 
                    'class' => 'TabOnEnter',
                    'tabindex' => '1'
                )); ?>
                <?php echo CHtml::error($delivery->header, 'note'); ?>
            </div>
            
            <?php if (!$delivery->header->isNewRecord) : ?>
                <div class="row">
                    <?php echo CHtml::label('Tanggal Kirim Invoice', false); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model'=>$delivery->header,
                        'attribute'=>'date_invoice_sent',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                            'dateFormat'=>'yy-mm-dd',
                        ),
                        'htmlOptions'=>array(
                            'readonly'=>true,
                        ),
                    )); ?>
                    <?php echo CHtml::error($delivery->header, 'date_invoice_sent'); ?>
                </div>

                <div class="row">
                    <?php echo CHtml::label('Status SJ', ''); ?>
                    <?php echo CHtml::activeDropDownList($delivery->header, 'delivery_status', array(
                        'BTB' => 'BTB', 
                        'Surat Jalan' => 'Surat Jalan', 
                        'Kirim Partial' => 'Kirim Partial', 
                        'Batal Kirim' => 'Batal Kirim',
                        'PO Susulan' => 'PO Susulan', 
                    ), array('empty' => '-- Pilih Status --')); ?>
                    <?php echo CHtml::error($delivery->header, 'delivery_status'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('SPK #', ''); ?>
                <?php echo CHtml::encode($delivery->header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::encode(CHtml::value($delivery->header, 'workOrderCuttingHeader.saleHeader.customer.company')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Pusat', ''); ?>
                <?php echo CHtml::encode(CHtml::value($delivery->header, 'workOrderCuttingHeader.saleHeader.customer.address_main')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Kirim', ''); ?>
                <?php echo CHtml::encode(CHtml::value($delivery->header, 'workOrderCuttingHeader.saleHeader.customer.address_secondary')); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Kota Tujuan', ''); ?>
                <?php echo CHtml::activeDropDownList($delivery->header, 'customer_city', array(
                    'Bekasi' => 'Bekasi', 
                    'Bogor' => 'Bogor', 
                    'Tangerang' => 'Tangerang', 
                    'Cikarang' => 'Cikarang',
                    'Jababeka-Karawang' => 'Jababeka-Karawang', 
                    'Bandung' => 'Bandung', 
                    'Cengkareng' => 'Cengkareng', 
                ), array('empty' => '-- Pilih Kota --')); ?>
                <?php echo CHtml::error($delivery->header, 'customer_city'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Sopir', ''); ?>
                <?php echo CHtml::activeDropDownList($delivery->header, 'driver', CHtml::listData(Employee::model()->findAllByAttributes(array('employee_category_id' => 13), array('order' => 't.name ASC')), 'name', 'name'), array('empty' => '-- Pilih Driver --')); ?>
                <?php echo CHtml::error($delivery->header, 'driver'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('delivery' => $delivery)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
