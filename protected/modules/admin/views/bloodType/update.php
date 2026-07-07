<?php
$this->breadcrumbs = array(
    'Blood Types' => array('admin'),
    $model->name => array('view', 'id' => $model->id),
    'Update',
);

$this->menu = array(
    array('label' => 'Create BloodType', 'url' => array('create')),
    array('label' => 'View BloodType', 'url' => array('view', 'id' => $model->id)),
    array('label' => 'Manage BloodType', 'url' => array('admin')),
);
?>

<h1>Update BloodType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>