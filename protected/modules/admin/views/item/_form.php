<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'item-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'code'); ?>
            <?php echo $form->textField($model, 'code', array('size' => 60, 'maxlength' => 60)); ?>
            <?php echo $form->error($model, 'code'); ?>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Biaya'); ?>
            <?php echo $form->dropDownList($model, 'account_id_expense', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Biaya --')); ?>
            <?php echo $form->error($model, 'account_id_expense'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 60)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Goods in Transit'); ?>
            <?php echo $form->dropDownList($model, 'account_id_goods_in_transit', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Goods in Transit --')); ?>
            <?php echo $form->error($model, 'account_id_goods_in_transit'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 100)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA COGS'); ?>
            <?php echo $form->dropDownList($model, 'account_id_cost_of_goods_sold', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA COGS --')); ?>
            <?php echo $form->error($model, 'account_id_cost_of_goods_sold'); ?>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group">
            <?php echo $form->labelEx($model, 'item_category_id'); ?>
            <?php echo $form->dropDownList($model, 'item_category_id', CHtml::listData(ItemCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Category --')); ?>
            <?php echo $form->error($model, 'item_category_id'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Inventory'); ?>
            <?php echo $form->dropDownList($model, 'account_id_inventory', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Inventory --')); ?>
            <?php echo $form->error($model, 'account_id_inventory'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'type'); ?>
            <?php echo $form->dropDownList($model, 'type', array(
                'INV' => 'INV',
                'NON' => 'NON',
                'SVC' => 'SVC',
            ), array('empty' => '-- Pilih Item Type --')); ?>
            <?php echo $form->error($model, 'type'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Unbilled Goods'); ?>
            <?php echo $form->dropDownList($model, 'account_id_unbilled_goods', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Unbilled Goods --')); ?>
            <?php echo $form->error($model, 'account_id_unbilled_goods'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'satuan'); ?>
            <?php echo $form->dropDownList($model, 'unit_id', CHtml::listData(Unit::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih Satuan --')); ?>
            <?php echo $form->error($model, 'unit_id'); ?>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Penjualan'); ?>
            <?php echo $form->dropDownList($model, 'account_id_sale_transaction', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Penjualan --')); ?>
            <?php echo $form->error($model, 'account_id_sale_transaction'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'tax_category'); ?>
            <?php echo $form->dropDownList($model, 'tax_category', array(
                'PPn' => 'PPn',
                'PPh' => 'PPh', 
                'Non' => 'Non',
            ), array('empty' => '-- Pilih Category Pajak --')); ?>
            <?php echo $form->error($model, 'tax_category'); ?>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Retur Penjualan'); ?>
            <?php echo $form->dropDownList($model, 'account_id_sale_return', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Retur Penjualan --')); ?>
            <?php echo $form->error($model, 'account_id_sale_return'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'tax_percentage'); ?>
            <?php echo $form->textField($model, 'tax_percentage', array('size' => 10, 'maxlength' => 10)); ?>
            <?php echo $form->error($model, 'tax_percentage'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Diskon Penjualan'); ?>
            <?php echo $form->dropDownList($model, 'account_id_sale_discount', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Diskon Penjualan --')); ?>
            <?php echo $form->error($model, 'account_id_sale_discount'); ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'is_inactive', array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL,
            )); ?>
            <?php echo $form->error($model, 'is_inactive'); ?>
        </div>
        
        <div class="form-group">
            <?php echo $form->labelEx($model, 'COA Retur Pembelian'); ?>
            <?php echo $form->dropDownList($model, 'account_id_purchase_return', CHtml::listData(Account::model()->findAll(), 'id', 'name'), array('empty' => '-- Pilih COA Retur Pembelian --')); ?>
            <?php echo $form->error($model, 'account_id_purchase_return'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->