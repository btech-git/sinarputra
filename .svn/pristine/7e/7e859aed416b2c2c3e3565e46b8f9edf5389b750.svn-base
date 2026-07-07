<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $due_date
 * @property string $grand_total
 * @property string $payment_total
 * @property string $return_total
 * @property string $note
 * @property integer $supplier_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property PurchasePaymentHeader[] $purchasePaymentHeaders
 * @property PurchaseReceiptDetail[] $purchaseReceiptDetails
 * @property Supplier $supplier
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 */
class PurchaseReceiptHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_purchase_receipt_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, due_date, supplier_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, supplier_id, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('grand_total, payment_total, return_total', 'length', 'max' => 18),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, due_date, grand_total, payment_total, return_total, note, supplier_id, admin_id, is_inactive, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchasePaymentHeaders' => array(self::HAS_MANY, 'PurchasePaymentHeader', 'purchase_receipt_header_id'),
            'purchaseReceiptDetails' => array(self::HAS_MANY, 'PurchaseReceiptDetail', 'purchase_receipt_header_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
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
            'due_date' => 'Due Date',
            'grand_total' => 'Grand Total',
            'payment_total' => 'Payment Total',
            'return_total' => 'Return Total',
            'note' => 'Note',
            'supplier_id' => 'Supplier',
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
        $criteria->compare('t.due_date', $this->due_date, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.payment_total', $this->payment_total, true);
        $criteria->compare('t.return_total', $this->return_total, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
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
