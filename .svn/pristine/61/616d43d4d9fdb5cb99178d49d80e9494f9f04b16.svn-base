<h1>Kelola Data Penyesuaian Stok Barang</h1>
<div id="link">
    <?php echo CHtml::link('Create', array('create'), array('target' => '_blank')); ?>
</div>

<center>
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        Tanggal Mulai
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'StartDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>

        Sampai
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'EndDate',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
            ),
        ));
        ?>
    </div>
    <div class="row">
        <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
    </div>

    <div class="row button">
        <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'name' => 'Submit')); ?>
        <?php echo CHtml::resetButton('Clear'); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</center>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'adjustment-stock-grid',
    'dataProvider' => $dataProvider,
    'filter' => $adjustment,
    'columns' => array(
        array(
            'name' => 'cn_ordinal',
            'header' => 'Penyesuaian #',
            'filter' => '<div style="display: inline-block">' . CHtml::activeTextField($adjustment, 'cn_ordinal', array('maxLength' => 4, 'size' => 2)) . '</div>' .
            '<div style="display: inline-block"> &nbsp; /' . AdjustmentHeader::CN_CONSTANT . '/ &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeDropDownList($adjustment, 'cn_month', array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'), array('empty' => '')) . '</div>' .
            '<div style="display: inline-block"> &nbsp; / &nbsp; </div>' .
            '<div style="display: inline-block">' . CHtml::activeTextField($adjustment, 'cn_year', array('maxLength' => 2, 'size' => 2)) . '</div>',
            'value' => '$data->getCodeNumber(AdjustmentHeader::CN_CONSTANT)',
            'htmlOptions' => array('style' => 'width: 200px'),
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)'
        ),
        array(
            'name' => 'warehouse_id',
            'filter' => CHtml::listData(Warehouse::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'),
            'value' => 'CHtml::value($data, "warehouse.name")',
        ),
        'note',
        array(
            'name' => 'is_inactive',
            'filter' => array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive'),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
        ),
    ),
));
?>
