<?php

/**
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $note
 * @property string $memo
 * @property string $debit
 * @property string $credit
 * @property string $posting_datetime
 * @property integer $admin_id
 * @property integer $supplier_id
 *
 * @property Admin $admin
 * @property Supplier $supplier
 */
class PayableLedgerBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_payable_ledger';
    }

    public function rules() {
        return array(
            array('transaction_number, transaction_date, posting_datetime, admin_id, supplier_id', 'required'),
            array('admin_id, supplier_id', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('debit, credit', 'length', 'max' => 18),
            array('note, memo', 'safe'),
            // The following rule is used by search().
            array('id, transaction_number, transaction_date, note, memo, debit, credit, posting_datetime, admin_id, supplier_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'note' => 'Note',
            'memo' => 'Memo',
            'debit' => 'Debit',
            'credit' => 'Credit',
            'posting_datetime' => 'Posting Datetime',
            'admin_id' => 'Admin',
            'supplier_id' => 'Supplier',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.memo', $this->memo, true);
        $criteria->compare('t.debit', $this->debit, true);
        $criteria->compare('t.credit', $this->credit, true);
        $criteria->compare('t.posting_datetime', $this->posting_datetime, true);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.supplier_id', $this->supplier_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
