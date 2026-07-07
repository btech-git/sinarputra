<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $date_created
 * @property string $additional_payment_1
 * @property string $additional_payment_2
 * @property string $note
 * @property integer $customer_id
 * @property integer $account_id_additional_payment_1
 * @property integer $account_id_additional_payment_2
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $time_created
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property SalePaymentDetail[] $salePaymentDetails
 * @property Customer $customer
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property Account $accountIdAdditionalPayment1
 * @property Account $accountIdAdditionalPayment2
 */
class SalePaymentHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_sale_payment_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, date_created, customer_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, customer_id, account_id_additional_payment_1, account_id_additional_payment_2, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('additional_payment_1, additional_payment_2', 'length', 'max' => 18),
            array('note, time_created, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, date_created, additional_payment_1, additional_payment_2, note, customer_id, account_id_additional_payment_1, account_id_additional_payment_2, admin_id, is_inactive, admin_id_updated, time_created, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'salePaymentDetails' => array(self::HAS_MANY, 'SalePaymentDetail', 'sale_payment_header_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'accountIdAdditionalPayment1' => array(self::BELONGS_TO, 'Account', 'account_id_additional_payment_1'),
            'accountIdAdditionalPayment2' => array(self::BELONGS_TO, 'Account', 'account_id_additional_payment_2'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'date_created' => 'Date Created',
            'additional_payment_1' => 'Additional Payment 1',
            'additional_payment_2' => 'Additional Payment 2',
            'note' => 'Note',
            'customer_id' => 'Customer',
            'account_id_additional_payment_1' => 'Account Id Additional Payment 1',
            'account_id_additional_payment_2' => 'Account Id Additional Payment 2',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.date_created', $this->date_created, true);
        $criteria->compare('t.additional_payment_1', $this->additional_payment_1, true);
        $criteria->compare('t.additional_payment_2', $this->additional_payment_2, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.account_id_additional_payment_1', $this->account_id_additional_payment_1);
        $criteria->compare('t.account_id_additional_payment_2', $this->account_id_additional_payment_2);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
