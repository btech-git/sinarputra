<?php

/**
 * @property integer $id
 * @property string $amount
 * @property string $income_tax
 * @property string $memo
 * @property integer $material_payment_header_id
 * @property integer $material_invoice_header_id
 * @property integer $is_inactive
 * @property string $additional_payment_1
 * @property string $additional_payment_2
 * @property integer $account_id_additional_payment_1
 * @property integer $account_id_additional_payment_2
 * @property integer $account_id
 * @property integer $payment_type_id
 *
 * @property MaterialPaymentHeader $materialPaymentHeader
 * @property MaterialInvoiceHeader $materialInvoiceHeader
 * @property Account $accountIdAdditionalPayment1
 * @property Account $accountIdAdditionalPayment2
 * @property Account $account
 * @property PaymentType $paymentType
 */
class MaterialPaymentDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_material_payment_detail';
    }

    public function rules() {
        return array(
            array('material_payment_header_id, material_invoice_header_id, payment_type_id', 'required'),
            array('material_payment_header_id, material_invoice_header_id, is_inactive, account_id_additional_payment_1, account_id_additional_payment_2, account_id, payment_type_id', 'numerical', 'integerOnly' => true),
            array('amount, additional_payment_1, additional_payment_2', 'length', 'max' => 18),
            array('income_tax', 'length', 'max' => 10),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            array('id, amount, income_tax, memo, material_payment_header_id, material_invoice_header_id, is_inactive, additional_payment_1, additional_payment_2, account_id_additional_payment_1, account_id_additional_payment_2, account_id, payment_type_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'materialPaymentHeader' => array(self::BELONGS_TO, 'MaterialPaymentHeader', 'material_payment_header_id'),
            'materialInvoiceHeader' => array(self::BELONGS_TO, 'MaterialInvoiceHeader', 'material_invoice_header_id'),
            'accountIdAdditionalPayment1' => array(self::BELONGS_TO, 'Account', 'account_id_additional_payment_1'),
            'accountIdAdditionalPayment2' => array(self::BELONGS_TO, 'Account', 'account_id_additional_payment_2'),
            'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'amount' => 'Amount',
            'income_tax' => 'Income Tax',
            'memo' => 'Memo',
            'material_payment_header_id' => 'Material Payment Header',
            'material_invoice_header_id' => 'Material Invoice Header',
            'is_inactive' => 'Is Inactive',
            'additional_payment_1' => 'Additional Payment 1',
            'additional_payment_2' => 'Additional Payment 2',
            'account_id_additional_payment_1' => 'Account Id Additional Payment 1',
            'account_id_additional_payment_2' => 'Account Id Additional Payment 2',
            'account_id' => 'Account',
            'payment_type_id' => 'Payment Type',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.amount', $this->amount, true);
        $criteria->compare('t.income_tax', $this->income_tax, true);
        $criteria->compare('t.memo', $this->memo, true);
        $criteria->compare('t.material_payment_header_id', $this->material_payment_header_id);
        $criteria->compare('t.material_invoice_header_id', $this->material_invoice_header_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.additional_payment_1', $this->additional_payment_1, true);
        $criteria->compare('t.additional_payment_2', $this->additional_payment_2, true);
        $criteria->compare('t.account_id_additional_payment_1', $this->account_id_additional_payment_1);
        $criteria->compare('t.account_id_additional_payment_2', $this->account_id_additional_payment_2);
        $criteria->compare('t.account_id', $this->account_id);
        $criteria->compare('t.payment_type_id', $this->payment_type_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
