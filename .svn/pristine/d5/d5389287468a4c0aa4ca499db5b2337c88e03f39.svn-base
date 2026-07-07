<?php
$this->breadcrumbs = array(
    'Customers' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'Create Customer', 'url' => array('create')),
    array('label' => 'Update Customer', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Manage Customer', 'url' => array('admin')),
);
?>

<h1>View Customer #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'code',
        array(
            'label' => 'Date Created',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date_created),
        ),
        'name',
        'company',
        array(
            'label' => 'Alamat Pusat',
            'value' => $model->address_main,
        ),
        array(
            'label' => 'Alamat Kirim',
            'value' => $model->address_secondary,
        ),
        'city',
        'province',
        'customerArea.name',
        'phone',
        'fax',
        'email',
        'note',
        'invoice_due_days',
        'available_credit',
        array(
            'label' => 'Credit Limit',
            'value' => Yii::app()->numberFormatter->format('#,##0.00', $model->credit_limit),
        ),
        array(
            'label' => 'Sisa Limit',
            'value' => Yii::app()->numberFormatter->format('#,##0.00', $model->remainingCreditLimit),
        ),
        'discount_default',
        'employee.name',
        array(
            'label' => 'PPn/Non',
            'value' => $model->taxStatus,
        ),
        array(
            'label' => 'NPWP',
            'value' => $model->tax_registration_number,
        ),
        'tax_name',
        array(
            'label' => 'Alamat NPWP',
            'value' => $model->tax_address_main,
        ),
        array(
            'label' => 'Alamat NPWP 2',
            'value' => $model->tax_address_secondary,
        ),
        'type',
        'status',
        array(
            'label' => 'Akun Piutang',
            'value' => $model->accountIdReceivable->name,
        ),
        array(
            'label' => 'User Updated',
            'value' => empty($model->admin_id_updated) ? '' : $model->adminIdUpdated->name,
        ),
        array(
            'label' => 'Date Updated',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy H:MM:s", $model->date_updated),
        ),
    ),
)); ?>
