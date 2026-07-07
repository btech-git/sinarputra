<?php
$this->breadcrumbs = array(
	'Account Categories',
);

$this->menu = array(
	array('label'=>'Create AccountCategory', 'url'=>array('create')),
	array('label'=>'Manage AccountCategory', 'url'=>array('admin')),
);
?>

<h1>Account Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
