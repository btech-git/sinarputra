<?php
$this->breadcrumbs = array(
	'Religions',
);

$this->menu = array(
	array('label'=>'Create Religion', 'url'=>array('create')),
	array('label'=>'Manage Religion', 'url'=>array('admin')),
);
?>

<h1>Religions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
