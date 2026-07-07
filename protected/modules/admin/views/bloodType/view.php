<?php
$this->breadcrumbs = array(
    'Blood Types' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'Create BloodType', 'url' => array('create')),
    array('label' => 'Update BloodType', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Manage BloodType', 'url' => array('admin')),
);
?>

<h1>View BloodType #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'status',
    ),
));
?>
