<h1>Kelola Data Pembayaran Penjualan Barang</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target'=>'_blank')); ?>
</div>

<br />

<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        Tanggal Mulai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'value' => $startDate,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>

        Sampai
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'value' => $endDate,
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        )); ?>
    </div>
    
    <br />
    
    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</center>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'payment-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$salePayment,
    'columns'=>array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Pembayaran #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($salePayment, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
                        '<div style="display: inline-block"> &nbsp; /' . ManualSalePaymentHeader::CN_CONSTANT . '/ &nbsp; </div>' .
                        '<div style="display: inline-block">' . CHtml::activeDropDownList($salePayment, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
                        '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
                        '<div style="display: inline-block">' . CHtml::activeTextField($salePayment, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(ManualSalePaymentHeader    ::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date)'
        ),
        array(
            'header' => 'Customer',
            'filter' => CHtml::textField('CustomerCompany', $customerCompany),
            'value' => 'CHtml::value($data, "customer.company")',
        ),
        array(
            'header' => 'Status',
            'name'=>'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE=>'Active', ActiveRecord::INACTIVE=>'Inactive'),
            'value'=>'$data->status',
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{view}{update}{delete}',
            'afterDelete' => 'function(){ location.reload(); }'
        ),
    ),
)); ?>
<?php echo CHtml::endForm(); ?>
