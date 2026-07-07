<?php
$this->breadcrumbs = array(
    'Employees' => array('admin'),
    $model->header->name => array('view', 'id' => $model->header->id),
    'Update',
);

$this->menu = array(
    array('label' => 'Create Employee', 'url' => array('create')),
    array('label' => 'View Employee', 'url' => array('view', 'id' => $model->header->id)),
    array('label' => 'Manage Employee', 'url' => array('admin')),
);
?>

<h1>Update Employee <?php echo $model->header->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
