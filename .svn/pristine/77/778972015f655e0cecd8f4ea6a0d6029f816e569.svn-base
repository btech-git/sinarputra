<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($materialInvoice->header); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$materialInvoice->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Invoice #', false); ?>
                    <?php echo CHtml::encode($materialInvoice->header->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$materialInvoice->header,
                    'attribute'=>'date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($materialInvoice->header, 'date'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Jatuh Tempo', false); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'=>$materialInvoice->header,
                    'attribute'=>'due_date',
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'dateFormat'=>'yy-mm-dd',
                    ),
                    'htmlOptions'=>array(
                        'readonly'=>true,
                    ),
                )); ?>
                <?php echo CHtml::error($materialInvoice->header, 'due_date'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Faktur Pajak #', ''); ?>
                <?php echo CHtml::activeTextField($materialInvoice->header, 'tax_number'); ?>
                <?php echo CHtml::error($materialInvoice->header, 'tax_number'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($materialInvoice->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($materialInvoice->header, 'note'); ?>
            </div>

        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Customer', ''); ?>
                <?php echo CHtml::activeTextField($materialInvoice->header, 'customer_id', array('readonly' => true, 'onclick' => '$("#customer-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }')); ?>
                <?php echo CHtml::error($materialInvoice->header, 'customer_id'); ?>

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
                        $("#' . CHtml::activeId($materialInvoice->header, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                        $("#customer-dialog").dialog("close");
                        if ($.fn.yiiGridView.getSelection(id) == "") {
                            $("#customer_name").html("");
                            $("#customer_company").html("");
                            $("#customer_tax_number").html("");
                            $("#customer_salesman").html("");

                        } else {
                            $.ajax({
                                type: "POST",
                                dataType: "JSON",
                                url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $materialInvoice->header->id)) . '",
                                data: $("form").serialize(),
                                success: function(data) {
                                    $("#' . CHtml::activeId($materialInvoice->header, 'employee_id_salesman') . '").val(data.salesman);
                                    $("#customer_name").html(data.customer_name);
                                    $("#customer_company").html(data.customer_company);
                                    $("#customer_tax_number").html(data.customer_tax_number);
                                    $("#customer_salesman").html(data.customer_salesman);
                                },
                            });
                        }
                    }',
                    'columns' => array(
                        'code',
                        'name',
                        'company',
                        'tax_registration_number',
                    ),
                )); ?>
                <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Nama', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                <?php echo CHtml::encode(CHtml::value($materialInvoice->header, 'customer.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Perusahaan', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_company')); ?>
                <?php echo CHtml::encode(CHtml::value($materialInvoice->header, 'customer.company')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('NPWP', ''); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_tax_number')); ?>
                <?php echo CHtml::encode(CHtml::value($materialInvoice->header, 'customer.tax_registration_number')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('Salesman', ''); ?>
                <?php echo CHtml::activeHiddenField($materialInvoice->header, 'employee_id_salesman'); ?>
                <?php echo CHtml::openTag('span', array('id' => 'customer_salesman')); ?>
                <?php echo CHtml::encode(CHtml::value($materialInvoice->header, 'employeeIdSalesman.name')); ?>
                <?php echo CHtml::closeTag('span'); ?>
            </div>
            
            <div class="row">
                <?php echo CHtml::label('PO #', ''); ?>
                <?php echo CHtml::activeTextField($materialInvoice->header, 'reference_number'); ?>
                <?php echo CHtml::error($materialInvoice->header, 'reference_number'); ?>
            </div>
        </div>
    </div>

    <hr />

    <?php echo CHtml::button('Tambah Material', array(
        'id' => 'btn_product',
        'onclick' => '$.ajax({
            type: "POST",
            data: $("form").serialize(),
            url: "' . CController::createUrl('ajaxHtmlAddMaterial', array('id' => $materialInvoice->header->id)) . '",
            success: function(html){
                $("#detail_div").html(html);
            }
        })'
    )); ?>
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('materialInvoice' => $materialInvoice)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>
    <?php echo CHtml::endForm(); ?>

</div><!-- form -->