<?php
$this->breadcrumbs = array(
	'Products'=>array('admin'),
	$model->header->name=>array('view', 'id'=>$model->header->id),
	'Update',
);

$this->menu = array(
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'View Product', 'url'=>array('view', 'id'=>$model->header->id)),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>

<h1>Update Product <?php echo $model->header->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>