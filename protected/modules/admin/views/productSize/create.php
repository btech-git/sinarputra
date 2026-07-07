<?php
$this->breadcrumbs = array(
	'Product Sizes'=>array('admin'),
	'Create',
);

$this->menu = array(
	array('label'=>'Manage ProductSize', 'url'=>array('admin')),
);
?>

<h1>Create ProductSize</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>