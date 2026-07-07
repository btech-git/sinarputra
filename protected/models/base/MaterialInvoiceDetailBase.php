<?php

/**
 * @property integer $id
 * @property integer $quantity
 * @property string $weight
 * @property string $unit_price
 * @property string $memo
 * @property integer $material_invoice_header_id
 * @property integer $unit_id
 * @property integer $is_inactive
 * @property string $material_name
 * @property integer $is_using_weight
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $rounding_amount
 *
 * @property MaterialInvoiceHeader $materialInvoiceHeader
 * @property Unit $unit
 */
class MaterialInvoiceDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_material_invoice_detail';
    }

    public function rules() {
        return array(
            array('material_invoice_header_id, unit_id, material_name', 'required'),
            array('quantity, material_invoice_header_id, unit_id, is_inactive, is_using_weight', 'numerical', 'integerOnly' => true),
            array('weight, length, width, height', 'length', 'max' => 10),
            array('unit_price, rounding_amount', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 100),
            array('material_name', 'length', 'max' => 200),
            // The following rule is used by search().
            array('id, quantity, weight, unit_price, memo, material_invoice_header_id, unit_id, is_inactive, material_name, is_using_weight, rounding_amount, length, width, height', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'materialInvoiceHeader' => array(self::BELONGS_TO, 'MaterialInvoiceHeader', 'material_invoice_header_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'weight' => 'Berat',
            'unit_price' => 'Unit Price',
            'memo' => 'Memo',
            'material_invoice_header_id' => 'Material Invoice Header',
            'unit_id' => 'Unit',
            'is_inactive' => 'Is Inactive',
            'material_name' => 'Material Name',
            'is_using_weight' => 'Is Using Weight',
            'length' => 'Panjang',
            'width' => 'Lebar',
            'height' => 'Tebal',
            'rounding_amount' => 'Pembulatan',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.unit_price', $this->unit_price, true);
        $criteria->compare('t.memo', $this->memo, true);
        $criteria->compare('t.material_invoice_header_id', $this->material_invoice_header_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.material_name', $this->material_name, true);
        $criteria->compare('t.is_using_weight', $this->is_using_weight);
        $criteria->compare('t.length', $this->length);
        $criteria->compare('t.width', $this->width);
        $criteria->compare('t.height', $this->height);
        $criteria->compare('t.rounding_amount', $this->rounding_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
