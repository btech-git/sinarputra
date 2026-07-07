<?php
$this->breadcrumbs = array(
	'Product Sizes',
);

$this->menu = array(
	array('label'=>'Create ProductSize', 'url'=>array('create')),
	array('label'=>'Manage ProductSize', 'url'=>array('admin')),
);
?>

<h1>Product Sizes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
