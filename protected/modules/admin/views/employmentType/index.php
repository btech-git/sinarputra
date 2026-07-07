<?php
$this->breadcrumbs = array(
	'Employment Types',
);

$this->menu = array(
	array('label'=>'Create EmploymentType', 'url'=>array('create')),
	array('label'=>'Manage EmploymentType', 'url'=>array('admin')),
);
?>

<h1>Employment Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
