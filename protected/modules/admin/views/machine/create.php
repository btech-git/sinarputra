<?php
$this->breadcrumbs = array(
	'Machines'=>array('index'),
	'Create',
);

$this->menu = array(
	array('label'=>'List Machine', 'url'=>array('index')),
	array('label'=>'Manage Machine', 'url'=>array('admin')),
);
?>

<h1>Create Machine</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>