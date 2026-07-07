<?php
$this->breadcrumbs = array(
    'Penerimaan Kas Bank' => array('create'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('release-grid', {
				data: $(this).serialize()
			});
			return false;
		});
	");
?>
<h1>Kelola Penerimaan Kas / Bank</h1>

<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>
<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <?php
    $pageSize = Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']);
    $pageSizeDropDown = CHtml::dropDownList(
        'pageSize', $pageSize, array(10 => 10, 25 => 25, 50 => 50, 100 => 100), array(
            'class' => 'change-pagesize',
            'onchange' => "$.fn.yiiGridView.update('deposit-header-grid',{data:{pageSize:$(this).val()}});",
        )
    );
    ?>

    <div class="page-size-wrap">
        <span>Display by:</span><?php echo $pageSizeDropDown; ?>
    </div>
</center>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'deposit-header-grid',
    'dataProvider' => $deposit->search(),
    'filter' => $deposit,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Pemasukan #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($deposit, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . DepositHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($deposit, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($deposit, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(DepositHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 300px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::encode(CHtml::value($data, "date")))'
        ),
        array(
            'header' => 'Account',
            'name' => 'account_id',
            'filter' => CHtml::listData(Account::model()->findAll('account_category_id IN (1, 2)'), 'id', 'name'),
            'value' => 'CHtml::encode(CHtml::value($data, "account.name"))'
        ),
        array(
            'header' => 'Total',
            'value' => 'CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($data, "grandTotal")))',
            'htmlOptions' => array('style' => 'text-align: right'),
        ),
        array(
            'name' => 'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'),
            'value' => 'CHtml::encode(CHtml::value($data, "status"))',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}{delete}',
        ),
    ),
)); ?>
<?php echo CHtml::endForm(); ?>
