<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date_transaction
 * @property string $datetime_created
 * @property string $note
 * @property integer $customer_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $date_payment
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property MaterialPaymentDetail[] $materialPaymentDetails
 * @property Customer $customer
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 */
class MaterialPaymentHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_material_payment_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date_transaction, datetime_created, customer_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, customer_id, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('note, date_payment, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date_transaction, datetime_created, note, customer_id, admin_id, is_inactive, date_payment, admin_id_updated, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'materialPaymentDetails' => array(self::HAS_MANY, 'MaterialPaymentDetail', 'material_payment_header_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date_transaction' => 'Date Transaction',
            'datetime_created' => 'Datetime Created',
            'note' => 'Note',
            'customer_id' => 'Customer',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
            'date_payment' => 'Date Payment',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date_transaction', $this->date_transaction, true);
        $criteria->compare('t.datetime_created', $this->datetime_created, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.date_payment', $this->date_payment, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
