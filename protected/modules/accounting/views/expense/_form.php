<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <div>
                <?php echo CHtml::errorSummary($expense->header, 'error'); ?>
            </div>

            <?php if (!$expense->header->isNewRecord): ?>
                <div class="row">
                    <?php echo CHtml::label('Pengeluaran #', false); ?>
                    <?php echo CHtml::encode($expense->header->getCodeNumber(ExpenseHeader::CN_CONSTANT)); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', ''); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $expense->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                )); ?>
                <?php echo CHtml::error($expense->header, 'date'); ?>
            </div>

            <div class="row">
                <?php echo CHtml::label('Account', false); ?>
                <?php echo CHtml::activeDropDownList($expense->header, 'account_id', CHtml::listData(Account::model()->findAll(array('condition' => 'account_category_id IN (1, 2)', 'order' => 't.name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Account-'
                )); ?>
                <?php echo CHtml::error($expense->header, 'account_id'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($expense->header, 'note'); ?>
                <?php echo CHtml::error($expense->header, 'note'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Tambah Akun', array(
            'onclick' => '$("#account-dialog").dialog("open"); return false;',
            'onkeypress' => 'if (event.keyCode == 13) { $("#account-dialog").dialog("open"); return false; }'
        )); ?>
        <?php echo CHtml::hiddenField('AccountId'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('expense' => $expense)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'account-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Accounts',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'account-grid',
    'dataProvider' => $accountDataProvider,
    'filter' => $account,
    'selectionChanged' => 'js:function(id) {
        $("#AccountId").val($.fn.yiiGridView.getSelection(id));
        $("#account-dialog").dialog("close");
        $.ajax({
            type: "POST",
            url: "' . CController::createUrl('AjaxHtmlAddDetail', array('id' => $expense->header->id)) . '",
            data: $("form").serialize(),
            success: function(html) { $("#detail_div").html(html); },
        });
    }',
    'columns' => array(
        'code: Kode',
        'name:nama Akun',
        array(
            'header' => 'Category',
            'filter' => CHtml::activeDropDownList($account, 'account_category_id', CHtml::listData(AccountCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => ''
            )),
            'value' => 'CHtml::encode(CHtml::value($data, "accountCategory.name"))'
        ),
    ),
)); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>