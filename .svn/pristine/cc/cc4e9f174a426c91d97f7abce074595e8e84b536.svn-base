<h1>Jurnal Penyesuaian</h1>

<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <div class="container">
        <div class="span-12">
            <?php if (!$journalVoucher->header->isNewRecord): ?>
            <div class="row">
                <?php echo CHtml::label('Penyesuaian #', false); ?>
                <?php echo CHtml::encode($journalVoucher->header->getCodeNumber(JournalVoucherHeader::CN_CONSTANT)); ?>
            </div>
            <?php endif; ?>

            <div class="row">
                <?php echo CHtml::label('Tanggal', ''); ?>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $journalVoucher->header,
                    'attribute' => 'date',
                    // additional javascript options for the date picker plugin
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                    ),
                ));
                ?>
                <?php echo CHtml::error($journalVoucher->header, 'date'); ?>
            </div>
        </div>

        <div class="span-12 last">
            <div class="row">
                <?php echo CHtml::label('Catatan', ''); ?>
                <?php echo CHtml::activeTextArea($journalVoucher->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                <?php echo CHtml::error($journalVoucher->header, 'note'); ?>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Cari Akun', array('id' => 'SearchButton', 'name' => 'Search', 'onclick' => '$("#account-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#account-dialog").dialog("open"); return false; }')); ?>
        <?php echo CHtml::hiddenField('AccountId'); ?>
    </div>

    <div class="row">
        <?php echo CHtml::error($journalVoucher->header, 'error'); ?>
    </div>

    <div id="detail_div">
        <?php $this->renderPartial('_detail', array('journalVoucher' => $journalVoucher)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
            
    <?php echo IdempotentManager::generate(); ?>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->

<div>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'account-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Account',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'accountt-grid',
        'dataProvider' => $dataProvider,
        'filter' => $account,
        'selectionChanged' => 'js:function(id) {
				$("#AccountId").val($.fn.yiiGridView.getSelection(id));
				$("#account-dialog").dialog("close");
				$.ajax({
					type: "POST",
					url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $journalVoucher->header->id)) . '",
					data: $("form").serialize(),
					success: function(html) {
						$("#detail_div").html(html);
					},
				});
			}',
        'columns' => array(
            'code',
            'name',
			array(
				'header' => 'Category',
				'filter' => CHtml::activeDropDownList($account, 'account_category_id', CHtml::listData(AccountCategory::model()->findAll(), 'id', 'name'), array(
					'empty' => ''
				)),
				'value' => 'CHtml::encode(CHtml::value($data, "accountCategory.name"))'
			),
        ),
    ));
    ?>

    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>

