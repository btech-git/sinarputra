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
        'category',
        'code',
        'name',
        'company',
        array(
            'label'=>'Alamat Utama',
            'value' => $model->address_main,
        ),
        array(
            'label'=>'Alamat Kirim',
            'value' => $model->address_secondary,
        ),
        array(
            'label'=>'Alamat Invoice',
            'value' => $model->address_billing,
        ),
        'city',
        'province',
        'mobile_phone',
        'phone',
        'fax',
        'website',
        'email',
        array(
            'label'=>'Nama Bank',
            'value' => $model->bank_account,
        ),
        array(
            'label'=>'Akun Bank #',
            'value' => $model->bank_account_number,
        ),
        array(
            'label'=>'Jatuh Tempo (hari)',
            'value' => $model->invoice_due_days,
        ),
        'available_credit',
        array(
            'label'=>'TOP (hari)',
            'value' => $model->term_of_payment,
        ),
        'credit_limit',
        array(
            'label'=>'PPh',
            'value' => $model->getTaxServiceType($model->tax_service_type),
        ),
        array(
            'label'=>'NPWP',
            'value' => CHtml::encode(CHtml::value($model, 'tax_registration_number')),
        ),
        array(
            'label'=>'PPn',
            'value' => $model->is_tax === 0 ? 'Non': 'PPn',
        ),
        array(
            'label'=>'Akun Hutang',
            'value' => CHtml::encode(CHtml::value($model, 'accountIdPayable.name')),
        ),
        'note',
        'status',
    ),
)); ?>
