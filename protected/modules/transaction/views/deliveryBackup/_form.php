<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($deliveryBackup->header); ?>
    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$deliveryBackup->header,
                    'attribute'=>'transaction_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'transaction_date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Gudang', '', array('required' => true)); ?>
                <?php echo CHtml::activeDropDownList($deliveryBackup->header, 'warehouse_id', CHtml::listData(Warehouse::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- Pilih Gudang --')); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'warehouse_id'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Sopir', ''); ?>
                <?php echo CHtml::activeDropDownList($deliveryBackup->header, 'employee_id_driver', CHtml::listData(Employee::model()->findAllByAttributes(array('employee_category_id' => 13), array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- Pilih Driver --')); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'employee_id_driver'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('PO #', ''); ?>
                <?php echo CHtml::activeTextField($deliveryBackup->header, 'purchase_order_number'); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'purchase_order_number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($deliveryBackup->header, 'note', array(
                    'rows' => 5, 
                    'cols' => 30, 
                    'class' => 'TabOnEnter',
                    'tabindex' => '1')); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'note'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::activeTextField($deliveryBackup->header, 'customer_id', array(
                    'readonly' => true,
                    'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                    'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'customer_id'); ?>

                <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id' => 'customer-dialog',
                    // additional javascript options for the dialog plugin
                    'options' => array(
                        'title' => 'Customer',
                        'autoOpen' => false,
                        'width' => 'auto',
                        'modal' => true,
                    ),
                )); ?>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'customer-grid',
                    'dataProvider' => $customerDataProvider,
                    'filter' => $customer,
                    'selectionChanged' => 'js:function(id) {
                        $("#' . CHtml::activeId($deliveryBackup->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#customer-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#customer_name").html("");
                            $("#customer_company").html("");
                            $("#' . CHtml::activeId($deliveryBackup->header, 'customer_address') . '").val("");

                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $deliveryBackup->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#customer_name").html(data.customer_name);
                                    $("#customer_company").html(data.customer_company);
                                    $("#' . CHtml::activeId($deliveryBackup->header, 'customer_address') . '").val(data.customer_address_secondary);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        'code',
                        'name',
                        'company',
                        'address_secondary: Alamat Kirim',
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($deliveryBackup->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($deliveryBackup->header, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Kota Tujuan', ''); ?>
                <?php echo CHtml::activeDropDownList($deliveryBackup->header, 'customer_city', array(
                    'Bekasi' => 'Bekasi', 
                    'Bogor' => 'Bogor', 
                    'Tangerang' => 'Tangerang', 
                    'Cikarang' => 'Cikarang',
                    'Jababeka-Karawang' => 'Jababeka-Karawang', 
                    'Bandung' => 'Bandung', 
                    'Cengkareng' => 'Cengkareng', 
                ), array('empty' => '-- Pilih Kota --')); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'customer_city'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('SPK #', ''); ?>
                <?php echo CHtml::activeTextField($deliveryBackup->header, 'work_order_number'); ?>
                <?php echo CHtml::error($deliveryBackup->header, 'work_order_number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Alamat Kirim', ''); ?>
                <?php echo CHtml::activeTextArea($deliveryBackup->header, 'customer_address', array('rows' => 5, 'cols' => 30)); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Barang', array(
            'id' => 'btn_product',
            'onclick' => '$.ajax({
                type: "POST",
                data: $("form").serialize(),
                url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $deliveryBackup->header->id)) . '",
                success: function(html){
                    $("#detail_div").html(html);
                }
            })'
        )); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('deliveryBackup' => $deliveryBackup)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
