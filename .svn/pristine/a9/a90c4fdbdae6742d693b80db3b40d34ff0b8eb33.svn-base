<?php
$this->breadcrumbs = array(
    'Employees' => array('admin'),
    $model->name,
);

$this->menu = array(
    array('label' => 'Create Employee', 'url' => array('create')),
    array('label' => 'Update Employee', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Manage Employee', 'url' => array('admin')),
);
?>

<style>
    table {
        border-top: 1px solid;
        border-left: 1px solid;
    }
    th, td {
        border-right: 1px solid;
        border-bottom: 1px solid;
    }
</style>

<h1>View Employee #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'code',
        'name',
        array(
            'label' => 'Tanggal Mulai Kerja',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->start_date),
        ),
        array(
            'label' => 'Tanggal Mulai Status Permanen Kerja',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->permanent_start_date),
        ),
        'company',
        'cost_center',
        array(
            'label' => 'Tanggal Lahir',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->birth_date),
        ),
        array(
            'label' => 'Tempat Lahir',
            'value' => $model->birth_place,
        ),
        'height',
        'weight',
        array(
            'label' => 'Alamat Tinggal',
            'value' => $model->residential_address,
        ),
        array(
            'label' => 'Alamat Asal',
            'value' => $model->original_address,
        ),
        'phone',
        'email',
        array(
            'label' => 'Nama Keluarga',
            'value' => $model->family_name,
        ),
//        array(
//            'label' => 'Status',
//            'value' => $model->getFamilyStatus($model->family_status),
//        ),
        array(
            'label' => 'No. Kartu Keluarga',
            'value' => CHtml::encode(CHtml::value($model, 'family_registration_number'))
        ),
//        array(
//            'label' => 'NIK Keluarga',
//            'value' => CHtml::encode(CHtml::value($model, 'nik_number'))
//        ),
        array(
            'label' => 'KTP',
            'value' => $model->identity_number,
        ),
        array(
            'label' => 'KTP expired',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->identity_expired),
        ),
        array(
            'label' => 'SIM',
            'value' => $model->driver_license_number,
        ),
        array(
            'label' => 'SIM expired',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->driver_license_expired),
        ),
        array(
            'label' => 'BPJS Kesehatan',
            'value' => $model->health_insurance_number,
        ),
        array(
            'label' => 'BPJS Ketenagakerjaan',
            'value' => $model->employment_insurance_number,
        ),
        array(
            'label' => 'NPWP',
            'value' => $model->personal_tax_number,
        ),
        'bank_name',
        'bank_account_number',
        array(
            'label' => 'Category',
            'value' => CHtml::encode(CHtml::value($model, 'employeeCategory.name'))
        ),
        array(
            'label' => 'Employment Type',
            'value' => CHtml::encode(CHtml::value($model, 'employmentType.name'))
        ),
        array(
            'label' => 'Department',
            'value' => CHtml::encode(CHtml::value($model, 'department.name'))
        ),
        array(
            'label' => 'Ethnic Group',
            'value' => CHtml::encode(CHtml::value($model, 'ethnicGroup.name'))
        ),
        array(
            'label' => ' Religion',
            'value' => CHtml::encode(CHtml::value($model, 'religion.name'))
        ),
        array(
            'label' => 'Blood Type',
            'value' => CHtml::encode(CHtml::value($model, 'bloodType.name'))
        ),
        array(
            'label' => 'Gender',
            'value' => $model->is_female ? Employee::FEMALE_LITERAL : Employee::MALE_LITERAL,
        ),
        array(
            'label' => 'Marital Status',
            'value' => $model->getMaritalStatus($model->marital_status),
        ),
         array(
            'label' => 'PTKP',
            'value' => $model->getTaxStatus($model->tax_status),
        ),
        array(
            'label' => 'Effective Date Resign',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->resignation_date),
        ),
        'status',
    ),
));
?>

<?php if ($model->file_extension !== null): ?>
    <div style="text-align: center">
        <h2>Uploaded Image</h2>
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/employee/' . $model->file_extension, "image", array("width" => "30%")); ?>  
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/signature/' . $model->file_extension_signature, "signature", array("width" => "30%")); ?>  
    </div>
<?php else: ?>
    <div style="text-align: center">
        <h2>Uploaded Image</h2>
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/employee/default.png', "image", array("width" => "30%")); ?>  
    </div>

<?php endif; ?>

<h2>Family Relationship</h2>
<table>
    <tr>
        <th>NIK Keluarga</th>
        <th>Relationship</th>
        <th>Phone</th>
        <th>Address</th>
    </tr>

    <?php foreach ($model->employeeFamilyRelationships as $detail): ?>
        <tr>
            <td><?php echo CHtml::value($detail, 'name'); ?></td>
            <td><?php echo CHtml::value($detail, 'relationship'); ?></td>
            <td><?php echo CHtml::value($detail, 'phone'); ?></td>
            <td><?php echo CHtml::value($detail, 'address'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br/>
<h2>Formal Education</h2>
<table>
    <tr>
        <th>Educational Background</th>
        <th>Major</th>
        <th>Description</th>
    </tr>

    <?php foreach ($model->employeeFormalEducations as $detail): ?>
        <tr>
            <td><?php echo CHtml::value($detail, 'educational_background'); ?></td>
            <td><?php echo CHtml::value($detail, 'major'); ?></td>
            <td><?php echo CHtml::value($detail, 'description'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br/>
<h2>Job Experience</h2>
<table>
    <tr>
        <th>Company Name</th>
        <th>Position</th>
        <th>Period</th>
    </tr>

    <?php foreach ($model->employeeJobExperiences as $detail): ?>
        <tr>
            <td><?php echo CHtml::value($detail, 'company_name'); ?></td>
            <td><?php echo CHtml::value($detail, 'position'); ?></td>
            <td><?php echo CHtml::value($detail, 'period'); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
