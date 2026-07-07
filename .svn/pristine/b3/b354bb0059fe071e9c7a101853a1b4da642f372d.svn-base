<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $date_receipt
 * @property string $due_date
 * @property string $grand_total
 * @property string $courier_name
 * @property string $note
 * @property integer $customer_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property MaterialReceiptDetail[] $materialReceiptDetails
 * @property Customer $customer
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 */
class MaterialReceiptHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_material_receipt_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, date_receipt, due_date, customer_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, customer_id, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('grand_total', 'length', 'max' => 18),
            array('courier_name', 'length', 'max' => 100),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, date_receipt, due_date, grand_total, courier_name, note, customer_id, admin_id, is_inactive, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'materialReceiptDetails' => array(self::HAS_MANY, 'MaterialReceiptDetail', 'material_receipt_header_id'),
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
            'date' => 'Date',
            'date_receipt' => 'Date Receipt',
            'due_date' => 'Due Date',
            'grand_total' => 'Grand Total',
            'courier_name' => 'Courier Name',
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
        $criteria->compare('t.date_receipt', $this->date_receipt, true);
        $criteria->compare('t.due_date', $this->due_date, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.courier_name', $this->courier_name, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
