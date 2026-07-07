<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $note
 * @property integer $customer_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property QuotationReturnDetail[] $quotationReturnDetails
 * @property Customer $customer
 * @property Admin $admin
 */
class QuotationReturnHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_quotation_return_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, customer_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, customer_id, admin_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('note', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, note, customer_id, admin_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'quotationReturnDetails' => array(self::HAS_MANY, 'QuotationReturnDetail', 'quotation_return_header_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'note' => 'Note',
            'customer_id' => 'Customer',
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
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
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
