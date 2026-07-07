<?php

/**
 * @property integer $id
 * @property string $total_invoice
 * @property string $memo
 * @property integer $material_receipt_header_id
 * @property integer $material_invoice_header_id
 * @property integer $is_inactive
 *
 * @property MaterialReceiptHeader $materialReceiptHeader
 * @property MaterialInvoiceHeader $materialInvoiceHeader
 */
class MaterialReceiptDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_material_receipt_detail';
    }

    public function rules() {
        return array(
            array('material_receipt_header_id, material_invoice_header_id', 'required'),
            array('material_receipt_header_id, material_invoice_header_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('total_invoice', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            array('id, total_invoice, memo, material_receipt_header_id, material_invoice_header_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'materialReceiptHeader' => array(self::BELONGS_TO, 'MaterialReceiptHeader', 'material_receipt_header_id'),
            'materialInvoiceHeader' => array(self::BELONGS_TO, 'MaterialInvoiceHeader', 'material_invoice_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total_invoice' => 'Total Invoice',
            'memo' => 'Memo',
            'material_receipt_header_id' => 'Material Receipt Header',
            'material_invoice_header_id' => 'Material Invoice Header',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.total_invoice', $this->total_invoice, true);
        $criteria->compare('t.memo', $this->memo, true);
        $criteria->compare('t.material_receipt_header_id', $this->material_receipt_header_id);
        $criteria->compare('t.material_invoice_header_id', $this->material_invoice_header_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
