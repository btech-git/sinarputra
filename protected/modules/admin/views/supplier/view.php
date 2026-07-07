<?php
$this->breadcrumbs = array(
	'Suppliers'=>array('admin'),
	$model->name,
);

$this->menu = array(
	array('label'=>'Create Supplier', 'url'=>array('create')),
	array('label'=>'Update Supplier', 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>'Manage Supplier', 'url'=>array('admin')),
);
?>

<h1>View Supplier #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                'code',
		'name',
		'company',
		'address_main',
		'city',
		'province',
		'phone',
		'fax',
		'email',
		'bank_account',
		'invoice_due_days',
		'note',
		'available_credit',
		'credit_limit',
		'term_of_payment',
		'is_tax',
		'tax_registration_number',
		'status',
		array(
			'label'=>'Akun Hutang',
			'value'=>$model->accountIdPayable->name,
		),
	),
)); ?>
