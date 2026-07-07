<?php
$this->breadcrumbs = array(
    'Admins' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'Create Admin', 'url' => array('create')),
    array('label' => 'Update Admin', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Manage Admin', 'url' => array('admin')),
    array('label' => 'Change Password', 'url' => array('password', 'id' => $model->id)),
);
?>

<h1>View Admin #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'updated_time',
        'name',
        'username',
        array(
            'label' => 'Employee',
            'value' => empty($model->employee_id) ? 'N/A' : $model->employee->name,
        ),
        'address',
        'phone',
        'cell_phone',
        'email',
        'status',
    ),
));
?>
