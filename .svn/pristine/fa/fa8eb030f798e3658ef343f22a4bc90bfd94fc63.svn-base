<?php

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $start_date
 * @property string $permanent_start_date
 * @property string $company
 * @property string $cost_center
 * @property string $birth_date
 * @property string $birth_place
 * @property string $height
 * @property string $weight
 * @property string $residential_address
 * @property string $original_address
 * @property string $phone
 * @property string $email
 * @property integer $family_status
 * @property string $family_name
 * @property string $family_registration_number
 * @property string $nik_number
 * @property string $identity_number
 * @property string $identity_expired
 * @property string $driver_license_number
 * @property string $driver_license_expired
 * @property string $health_insurance_number
 * @property string $employment_insurance_number
 * @property string $personal_tax_number
 * @property string $bank_name
 * @property string $bank_account_number
 * @property string $file_extension
 * @property string $file_extension_signature
 * @property integer $marital_status
 * @property integer $tax_status
 * @property string $resignation_date
 * @property string $job_group
 * @property integer $department_id
 * @property integer $division_id
 * @property integer $employee_category_id
 * @property integer $employment_type_id
 * @property integer $ethnic_group_id
 * @property integer $religion_id
 * @property integer $blood_type_id
 * @property integer $is_female
 * @property integer $is_inactive
 *
 * @property Admin[] $admins
 * @property Customer[] $customers
 * @property EmploymentType $employmentType
 * @property EthnicGroup $ethnicGroup
 * @property EmployeeCategory $employeeCategory
 * @property Religion $religion
 * @property BloodType $bloodType
 * @property Department $department
 * @property Division $division
 * @property EmployeeFamilyRelationship[] $employeeFamilyRelationships
 * @property EmployeeFormalEducation[] $employeeFormalEducations
 * @property EmployeeJobExperience[] $employeeJobExperiences
 * @property EmployeeTimesheet[] $employeeTimesheets
 * @property ManualSaleInvoiceHeader[] $manualSaleInvoiceHeaders
 * @property ProductionCuttingDetail[] $productionCuttingDetails
 * @property ProductionMilingDetail[] $productionMilingDetails
 * @property ProductionMilingDetail[] $productionMilingDetails1
 * @property ProductionMilingDetail[] $productionMilingDetails2
 * @property QualityControlCuttingDetail[] $qualityControlCuttingDetails
 * @property QualityControlMilingDetail[] $qualityControlMilingDetails
 * @property QuotationHeader[] $quotationHeaders
 * @property SaleHeader[] $saleHeaders
 * @property SaleInvoiceHeader[] $saleInvoiceHeaders
 * @property WorkOrderCuttingDetail[] $workOrderCuttingDetails
 */
class EmployeeBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_employee';
    }

    public function rules() {
        return array(
            array('code, name, start_date, birth_date, department_id, division_id, employment_type_id, ethnic_group_id, religion_id', 'required'),
            array('email', 'email'),
            array('family_status, marital_status, tax_status, department_id, division_id, employee_category_id, employment_type_id, ethnic_group_id, religion_id, blood_type_id, is_female, is_inactive', 'numerical', 'integerOnly' => true),
            array('code, job_group', 'length', 'max' => 20),
            array('name, company, cost_center, birth_place, phone, email, family_name, bank_name', 'length', 'max' => 60),
            array('height, weight', 'length', 'max' => 10),
            array('family_registration_number, nik_number, identity_number, driver_license_number, health_insurance_number, employment_insurance_number, personal_tax_number, bank_account_number', 'length', 'max' => 30),
            array('file_extension, file_extension_signature', 'length', 'max' => 200),
            array('permanent_start_date, residential_address, original_address, identity_expired, driver_license_expired, resignation_date', 'safe'),
            // The following rule is used by search().
            array('id, code, name, start_date, permanent_start_date, company, cost_center, birth_date, birth_place, height, weight, residential_address, original_address, phone, email, family_status, family_name, family_registration_number, nik_number, identity_number, identity_expired, driver_license_number, driver_license_expired, health_insurance_number, employment_insurance_number, personal_tax_number, bank_name, bank_account_number, file_extension, file_extension_signature, marital_status, tax_status, resignation_date, job_group, department_id, division_id, employee_category_id, employment_type_id, ethnic_group_id, religion_id, blood_type_id, is_female, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'admins' => array(self::HAS_MANY, 'Admin', 'employee_id'),
            'customers' => array(self::HAS_MANY, 'Customer', 'employee_id'),
            'employmentType' => array(self::BELONGS_TO, 'EmploymentType', 'employment_type_id'),
            'ethnicGroup' => array(self::BELONGS_TO, 'EthnicGroup', 'ethnic_group_id'),
            'employeeCategory' => array(self::BELONGS_TO, 'EmployeeCategory', 'employee_category_id'),
            'religion' => array(self::BELONGS_TO, 'Religion', 'religion_id'),
            'bloodType' => array(self::BELONGS_TO, 'BloodType', 'blood_type_id'),
            'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
            'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
            'employeeFamilyRelationships' => array(self::HAS_MANY, 'EmployeeFamilyRelationship', 'employee_id'),
            'employeeFormalEducations' => array(self::HAS_MANY, 'EmployeeFormalEducation', 'employee_id'),
            'employeeJobExperiences' => array(self::HAS_MANY, 'EmployeeJobExperience', 'employee_id'),
            'employeeTimesheets' => array(self::HAS_MANY, 'EmployeeTimesheet', 'employee_id'),
            'manualSaleInvoiceHeaders' => array(self::HAS_MANY, 'ManualSaleInvoiceHeader', 'employee_id_salesman'),
            'productionCuttingDetails' => array(self::HAS_MANY, 'ProductionCuttingDetail', 'employee_id'),
            'productionMilingDetails' => array(self::HAS_MANY, 'ProductionMilingDetail', 'employee_id_facemil'),
            'productionMilingDetails1' => array(self::HAS_MANY, 'ProductionMilingDetail', 'employee_id_sidemil'),
            'productionMilingDetails2' => array(self::HAS_MANY, 'ProductionMilingDetail', 'employee_id_grinding'),
            'qualityControlCuttingDetails' => array(self::HAS_MANY, 'QualityControlCuttingDetail', 'employee_id'),
            'qualityControlMilingDetails' => array(self::HAS_MANY, 'QualityControlMilingDetail', 'employee_id'),
            'quotationHeaders' => array(self::HAS_MANY, 'QuotationHeader', 'employee_id_sales'),
            'saleHeaders' => array(self::HAS_MANY, 'SaleHeader', 'employee_id_salesman'),
            'saleInvoiceHeaders' => array(self::HAS_MANY, 'SaleInvoiceHeader', 'employee_id_salesman'),
            'workOrderCuttingDetails' => array(self::HAS_MANY, 'WorkOrderCuttingDetail', 'employee_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'start_date' => 'Start Date',
            'permanent_start_date' => 'Permanent Start Date',
            'company' => 'Company',
            'cost_center' => 'Cost Center',
            'birth_date' => 'Birth Date',
            'birth_place' => 'Birth Place',
            'height' => 'Height',
            'weight' => 'Weight',
            'residential_address' => 'Residential Address',
            'original_address' => 'Original Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'family_status' => 'Family Status',
            'family_name' => 'Family Name',
            'family_registration_number' => 'Family Registration Number',
            'nik_number' => 'Nik Number',
            'identity_number' => 'Identity Number',
            'identity_expired' => 'Identity Expired',
            'driver_license_number' => 'Driver License Number',
            'driver_license_expired' => 'Driver License Expired',
            'health_insurance_number' => 'Health Insurance Number',
            'employment_insurance_number' => 'Employment Insurance Number',
            'personal_tax_number' => 'Personal Tax Number',
            'bank_name' => 'Bank Name',
            'bank_account_number' => 'Bank Account Number',
            'file_extension' => 'File Extension',
            'file_extension_signature' => 'File Extension Signature',
            'marital_status' => 'Marital Status',
            'tax_status' => 'Tax Status',
            'resignation_date' => 'Resignation Date',
            'job_group' => 'Job Group',
            'department_id' => 'Department',
            'division_id' => 'Division',
            'employee_category_id' => 'Employee Category',
            'employment_type_id' => 'Employment Type',
            'ethnic_group_id' => 'Ethnic Group',
            'religion_id' => 'Religion',
            'blood_type_id' => 'Blood Type',
            'is_female' => 'Is Female',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.start_date', $this->start_date, true);
        $criteria->compare('t.permanent_start_date', $this->permanent_start_date, true);
        $criteria->compare('t.company', $this->company, true);
        $criteria->compare('t.cost_center', $this->cost_center, true);
        $criteria->compare('t.birth_date', $this->birth_date, true);
        $criteria->compare('t.birth_place', $this->birth_place, true);
        $criteria->compare('t.height', $this->height, true);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.residential_address', $this->residential_address, true);
        $criteria->compare('t.original_address', $this->original_address, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.family_status', $this->family_status);
        $criteria->compare('t.family_name', $this->family_name, true);
        $criteria->compare('t.family_registration_number', $this->family_registration_number, true);
        $criteria->compare('t.nik_number', $this->nik_number, true);
        $criteria->compare('t.identity_number', $this->identity_number, true);
        $criteria->compare('t.identity_expired', $this->identity_expired, true);
        $criteria->compare('t.driver_license_number', $this->driver_license_number, true);
        $criteria->compare('t.driver_license_expired', $this->driver_license_expired, true);
        $criteria->compare('t.health_insurance_number', $this->health_insurance_number, true);
        $criteria->compare('t.employment_insurance_number', $this->employment_insurance_number, true);
        $criteria->compare('t.personal_tax_number', $this->personal_tax_number, true);
        $criteria->compare('t.bank_name', $this->bank_name, true);
        $criteria->compare('t.bank_account_number', $this->bank_account_number, true);
        $criteria->compare('t.file_extension', $this->file_extension, true);
        $criteria->compare('t.file_extension_signature', $this->file_extension_signature, true);
        $criteria->compare('t.marital_status', $this->marital_status);
        $criteria->compare('t.tax_status', $this->tax_status);
        $criteria->compare('t.resignation_date', $this->resignation_date, true);
        $criteria->compare('t.job_group', $this->job_group, true);
        $criteria->compare('t.department_id', $this->department_id);
        $criteria->compare('t.division_id', $this->division_id);
        $criteria->compare('t.employee_category_id', $this->employee_category_id);
        $criteria->compare('t.employment_type_id', $this->employment_type_id);
        $criteria->compare('t.ethnic_group_id', $this->ethnic_group_id);
        $criteria->compare('t.religion_id', $this->religion_id);
        $criteria->compare('t.blood_type_id', $this->blood_type_id);
        $criteria->compare('t.is_female', $this->is_female);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
