<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $note
 * @property integer $purchase_receipt_header_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property PurchasePaymentDetail[] $purchasePaymentDetails
 * @property PurchaseReceiptHeader $purchaseReceiptHeader
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 */
class PurchasePaymentHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_purchase_payment_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, purchase_receipt_header_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, purchase_receipt_header_id, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, note, purchase_receipt_header_id, admin_id, is_inactive, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchasePaymentDetails' => array(self::HAS_MANY, 'PurchasePaymentDetail', 'purchase_payment_header_id'),
            'purchaseReceiptHeader' => array(self::BELONGS_TO, 'PurchaseReceiptHeader', 'purchase_receipt_header_id'),
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
            'note' => 'Note',
            'purchase_receipt_header_id' => 'Purchase Receipt Header',
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
        $criteria->compare('t.purchase_receipt_header_id', $this->purchase_receipt_header_id);
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
