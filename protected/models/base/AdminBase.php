<?php

/**
 * @property integer $id
 * @property string $updated_time
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property string $address
 * @property string $phone
 * @property string $cell_phone
 * @property string $email
 * @property string $file_extension_signature
 * @property integer $employee_id
 * @property integer $is_inactive
 *
 * @property AdjustmentHeader[] $adjustmentHeaders
 * @property Employee $employee
 * @property DeliveryHeader[] $deliveryHeaders
 * @property DepositHeader[] $depositHeaders
 * @property ExpenseHeader[] $expenseHeaders
 * @property Inventory[] $inventories
 * @property JournalAccounting[] $journalAccountings
 * @property JournalVoucherHeader[] $journalVoucherHeaders
 * @property ProductionCuttingHeader[] $productionCuttingHeaders
 * @property ProductionMilingHeader[] $productionMilingHeaders
 * @property ProductionPlanningCuttingHeader[] $productionPlanningCuttingHeaders
 * @property ProductionPlanningMilingHeader[] $productionPlanningMilingHeaders
 * @property PurchaseHeader[] $purchaseHeaders
 * @property PurchaseInvoice[] $purchaseInvoices
 * @property PurchaseItemHeader[] $purchaseItemHeaders
 * @property PurchasePaymentHeader[] $purchasePaymentHeaders
 * @property PurchaseReceiptHeader[] $purchaseReceiptHeaders
 * @property PurchaseReturnHeader[] $purchaseReturnHeaders
 * @property QualityControlCuttingHeader[] $qualityControlCuttingHeaders
 * @property QualityControlMilingHeader[] $qualityControlMilingHeaders
 * @property QuotationHeader[] $quotationHeaders
 * @property QuotationHeader[] $quotationHeaders1
 * @property QuotationReturnHeader[] $quotationReturnHeaders
 * @property ReceiveHeader[] $receiveHeaders
 * @property ReceiveItemHeader[] $receiveItemHeaders
 * @property SaleHeader[] $saleHeaders
 * @property SaleHeader[] $saleHeaders1
 * @property SaleInvoiceHeader[] $saleInvoiceHeaders
 * @property SalePaymentHeader[] $salePaymentHeaders
 * @property SaleReceiptHeader[] $saleReceiptHeaders
 * @property WorkOrderCuttingHeader[] $workOrderCuttingHeaders
 * @property WorkOrderReplacementHeader[] $workOrderReplacementHeaders
 * @property WorkOrderReplacementHeader[] $workOrderReplacementHeaders1
 */
class AdminBase extends ActiveRecord
{
	public $current_password = '';
	public $new_password = '';
	public $confirm_password = '';
	public $roles = array();
    
	public function tableName()
	{
		return 'tblsp_admin';
	}

	public function rules()
	{
		return array(
			array('updated_time, name, username, password, salt', 'required'),
			array('email', 'email'),
			array('employee_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('name, username, phone, cell_phone, email', 'length', 'max'=>60),
			array('password', 'length', 'max'=>40),
			array('salt', 'length', 'max'=>32),
            
			//rules for password
			array('current_password, new_password, confirm_password', 'length', 'max' => 40),
			array('new_password, confirm_password', 'required', 'on' => 'insert, changePassword'),
			array('confirm_password', 'compare', 'compareAttribute' => 'new_password', 'on' => 'insert, changePassword'),
//			array('current_password', 'required', 'on' => 'changePassword'),
//			array('current_password', 'authenticatePassword', 'on' => 'changePassword'),

			array('file_extension_signature', 'length', 'max'=>200),
			array('address, roles', 'safe'),
			// The following rule is used by search().
			array('id, updated_time, name, username, password, salt, address, phone, cell_phone, email, file_extension_signature, is_inactive', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'adjustmentHeaders' => array(self::HAS_MANY, 'AdjustmentHeader', 'admin_id'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
			'deliveryHeaders' => array(self::HAS_MANY, 'DeliveryHeader', 'admin_id'),
			'depositHeaders' => array(self::HAS_MANY, 'DepositHeader', 'admin_id'),
			'expenseHeaders' => array(self::HAS_MANY, 'ExpenseHeader', 'admin_id'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'admin_id'),
			'journalAccountings' => array(self::HAS_MANY, 'JournalAccounting', 'admin_id'),
			'journalVoucherHeaders' => array(self::HAS_MANY, 'JournalVoucherHeader', 'admin_id'),
			'productionCuttingHeaders' => array(self::HAS_MANY, 'ProductionCuttingHeader', 'admin_id'),
			'productionMilingHeaders' => array(self::HAS_MANY, 'ProductionMilingHeader', 'admin_id'),
			'productionPlanningCuttingHeaders' => array(self::HAS_MANY, 'ProductionPlanningCuttingHeader', 'admin_id'),
			'productionPlanningMilingHeaders' => array(self::HAS_MANY, 'ProductionPlanningMilingHeader', 'admin_id'),
			'purchaseHeaders' => array(self::HAS_MANY, 'PurchaseHeader', 'admin_id'),
			'purchaseInvoices' => array(self::HAS_MANY, 'PurchaseInvoice', 'admin_id'),
			'purchaseItemHeaders' => array(self::HAS_MANY, 'PurchaseItemHeader', 'admin_id'),
			'purchasePaymentHeaders' => array(self::HAS_MANY, 'PurchasePaymentHeader', 'admin_id'),
			'purchaseReceiptHeaders' => array(self::HAS_MANY, 'PurchaseReceiptHeader', 'admin_id'),
			'purchaseReturnHeaders' => array(self::HAS_MANY, 'PurchaseReturnHeader', 'admin_id'),
			'qualityControlCuttingHeaders' => array(self::HAS_MANY, 'QualityControlCuttingHeader', 'admin_id'),
			'qualityControlMilingHeaders' => array(self::HAS_MANY, 'QualityControlMilingHeader', 'admin_id'),
			'quotationHeaders' => array(self::HAS_MANY, 'QuotationHeader', 'admin_id'),
			'quotationHeaders1' => array(self::HAS_MANY, 'QuotationHeader', 'admin_id_edit'),
			'quotationReturnHeaders' => array(self::HAS_MANY, 'QuotationReturnHeader', 'admin_id'),
			'receiveHeaders' => array(self::HAS_MANY, 'ReceiveHeader', 'admin_id'),
			'receiveItemHeaders' => array(self::HAS_MANY, 'ReceiveItemHeader', 'admin_id'),
			'saleHeaders' => array(self::HAS_MANY, 'SaleHeader', 'admin_id'),
			'saleHeaders1' => array(self::HAS_MANY, 'SaleHeader', 'admin_id_edit'),
			'saleInvoiceHeaders' => array(self::HAS_MANY, 'SaleInvoiceHeader', 'admin_id'),
			'salePaymentHeaders' => array(self::HAS_MANY, 'SalePaymentHeader', 'admin_id'),
			'saleReceiptHeaders' => array(self::HAS_MANY, 'SaleReceiptHeader', 'admin_id'),
			'workOrderCuttingHeaders' => array(self::HAS_MANY, 'WorkOrderCuttingHeader', 'admin_id'),
			'workOrderReplacementHeaders' => array(self::HAS_MANY, 'WorkOrderReplacementHeader', 'admin_id'),
			'workOrderReplacementHeaders1' => array(self::HAS_MANY, 'WorkOrderReplacementHeader', 'admin_id_approval'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'updated_time' => 'Updated Time',
			'name' => 'Name',
			'username' => 'Username',
			'password' => 'Password',
			'salt' => 'Salt',
			'address' => 'Address',
			'phone' => 'Phone',
			'cell_phone' => 'Cell Phone',
			'email' => 'Email',
			'file_extension_signature' => 'File Extension Signature',
			'employee_id' => 'Employee',
			'is_inactive' => 'Is Inactive',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.updated_time', $this->updated_time, true);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.username', $this->username, true);
		$criteria->compare('t.password', $this->password, true);
		$criteria->compare('t.salt', $this->salt, true);
		$criteria->compare('t.address', $this->address, true);
		$criteria->compare('t.phone', $this->phone, true);
		$criteria->compare('t.cell_phone', $this->cell_phone, true);
		$criteria->compare('t.email', $this->email, true);
		$criteria->compare('t.file_extension_signature', $this->file_extension_signature, true);
		$criteria->compare('t.employee_id', $this->employee_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
