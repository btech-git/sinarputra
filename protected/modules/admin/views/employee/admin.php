<?php
$this->breadcrumbs = array(
    'Employees' => array('create'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Create Employee', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('employee-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Employees</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::beginForm(array(''), 'get'); ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'employee-grid',
    'dataProvider' => $model->resetScope()->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        array(
            'header' => 'Image',
            'type' => 'raw',
            'value' => '$data->file_extension ? CHtml::image(Yii::app()->baseUrl."/images/employee/".$data->file_extension, "image", array(
					"width" => "90px"
				)) : 
				CHtml::image(Yii::app()->baseUrl."/images/employee/default.png", "image", array(
					"width" => "90px"
				))
',
            'htmlOptions' => array(
                'style' => 'text-align:center;'  //project rims, create employee, warehouse. Finish this slide manager
            )
        ),
        'phone',
        'email',
        array(
            'header' => 'Category',
            'filter' => CHtml::activeDropDownList($model, 'employee_category_id', CHtml::listData(EmployeeCategory::model()->findAll(), 'id', 'name'), array(
                'empty' => ''
            )),
            'value' => 'CHtml::encode(CHtml::value($data, "employeeCategory.name"))'
        ),
        array(
            'name' => 'marital_status',
            'value' => '$data->getMaritalStatus($data->marital_status)',
        ),
        array(
            'name' => 'is_inactive',
            'filter' => array(
                ActiveRecord::ACTIVE => ActiveRecord::ACTIVE_LITERAL,
                ActiveRecord::INACTIVE => ActiveRecord::INACTIVE_LITERAL),
            'value' => '$data->status',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}{update}',
        ),
    ),
));
?>


<?php echo CHtml::submitButton('Export To Excel', array('name' => 'Export', 'style' => 'float: right;', 'class' => 'grey-btn')); ?>

