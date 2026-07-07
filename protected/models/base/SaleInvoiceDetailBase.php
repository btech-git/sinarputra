<?php

/**
 * @property integer $id
 * @property string $grade_name
 * @property integer $quantity
 * @property string $weight
 * @property string $unit_price
 * @property integer $sale_invoice_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $is_using_weight
 * @property integer $is_inactive
 * @property string $rounding_amount
 *
 * @property SaleInvoiceHeader $saleInvoiceHeader
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 */
class SaleInvoiceDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_sale_invoice_detail';
    }

    public function rules() {
        return array(
            array('grade_name, sale_invoice_header_id, work_order_cutting_detail_id', 'required'),
            array('quantity, sale_invoice_header_id, work_order_cutting_detail_id, is_using_weight, is_inactive', 'numerical', 'integerOnly' => true),
            array('grade_name', 'length', 'max' => 100),
            array('weight', 'length', 'max' => 10),
            array('unit_price, rounding_amount', 'length', 'max' => 18),
            // The following rule is used by search().
            array('id, grade_name, quantity, weight, unit_price, sale_invoice_header_id, work_order_cutting_detail_id, is_using_weight, is_inactive, rounding_amount', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'saleInvoiceHeader' => array(self::BELONGS_TO, 'SaleInvoiceHeader', 'sale_invoice_header_id'),
            'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'grade_name' => 'Grade Name',
            'quantity' => 'Quantity',
            'weight' => 'Weight',
            'unit_price' => 'Unit Price',
            'sale_invoice_header_id' => 'Sale Invoice Header',
            'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
            'is_using_weight' => 'Is Using Weight',
            'is_inactive' => 'Is Inactive',
            'rounding_amount' => 'Rounding Amount',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.grade_name', $this->grade_name, true);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.unit_price', $this->unit_price, true);
        $criteria->compare('t.sale_invoice_header_id', $this->sale_invoice_header_id);
        $criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
        $criteria->compare('t.is_using_weight', $this->is_using_weight);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.rounding_amount', $this->rounding_amount, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
