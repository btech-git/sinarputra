<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $note
 * @property integer $receive_header_id
 * @property integer $admin_id
 * @property integer $is_inactive
 *
 * @property PurchaseReturnDetail[] $purchaseReturnDetails
 * @property Admin $admin
 * @property ReceiveHeader $receiveHeader
 */
class PurchaseReturnHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_purchase_return_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, receive_header_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, receive_header_id, admin_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('note', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, note, receive_header_id, admin_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'purchaseReturnDetails' => array(self::HAS_MANY, 'PurchaseReturnDetail', 'purchase_return_header_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
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
            'receive_header_id' => 'Receive Header',
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
        $criteria->compare('t.receive_header_id', $this->receive_header_id);
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
