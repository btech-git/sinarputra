<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $supplier_document_number
 * @property string $supplier_invoice_tax_number
 * @property string $note
 * @property string $rounding_nominal
 * @property string $grand_total
 * @property string $total_payment
 * @property string $discount_amount
 * @property integer $supplier_id
 * @property integer $receive_header_id
 * @property integer $receive_item_header_id
 * @property integer $admin_id
 * @property integer $is_item
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property ReceiveHeader $receiveHeader
 * @property ReceiveItemHeader $receiveItemHeader
 * @property Supplier $supplier
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property PurchaseReceiptDetail[] $purchaseReceiptDetails
 */
class PurchaseInvoiceBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_purchase_invoice';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, supplier_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, supplier_id, receive_header_id, receive_item_header_id, admin_id, is_item, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('supplier_document_number, supplier_invoice_tax_number', 'length', 'max' => 60),
            array('rounding_nominal, grand_total, total_payment, discount_amount', 'length', 'max' => 18),
            array('cn_ordinal', 'uniqueValidator', 'attributeName' => array('cn_ordinal', 'cn_month', 'cn_year'), 'on' => 'insert'),
            array('note, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, supplier_document_number, supplier_invoice_tax_number, note, rounding_nominal, grand_total, total_payment, supplier_id, receive_header_id, receive_item_header_id, admin_id, is_item, is_inactive, discount_amount, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'receiveHeader' => array(self::BELONGS_TO, 'ReceiveHeader', 'receive_header_id'),
            'receiveItemHeader' => array(self::BELONGS_TO, 'ReceiveItemHeader', 'receive_item_header_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'purchaseReceiptDetails' => array(self::HAS_MANY, 'PurchaseReceiptDetail', 'purchase_invoice_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'supplier_document_number' => 'Supplier Document Number',
            'supplier_invoice_tax_number' => 'Supplier Invoice Tax Number',
            'note' => 'Note',
            'rounding_nominal' => 'Rounding Nominal',
            'grand_total' => 'Grand Total',
            'total_payment' => 'Total Payment',
            'supplier_id' => 'Supplier',
            'receive_header_id' => 'Receive Header',
            'receive_item_header_id' => 'Receive Item Header',
            'admin_id' => 'Admin',
            'is_item' => 'Is Item',
            'is_inactive' => 'Is Inactive',
            'discount_amount' => ' Discount',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.supplier_document_number', $this->supplier_document_number, true);
        $criteria->compare('t.supplier_invoice_tax_number', $this->supplier_invoice_tax_number, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.rounding_nominal', $this->rounding_nominal, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.total_payment', $this->total_payment, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.receive_header_id', $this->receive_header_id);
        $criteria->compare('t.receive_item_header_id', $this->receive_item_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_item', $this->is_item);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.discount_amount', $this->discount_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
