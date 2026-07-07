<?php
$this->breadcrumbs = array(
	'Religions'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage Religion', 'url'=>array('admin')),
);
?>

<h1>Create Religion</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>