<?php

/**
 * @property integer $id
 * @property string $grade_name
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $weight
 * @property integer $quantity
 * @property integer $manual_delivery_header_id
 * @property integer $work_order_cutting_detail_id
 * @property integer $product_category_id
 * @property integer $is_miling
 * @property integer $is_sidemiling
 * @property integer $is_grinding
 * @property integer $is_hardness
 * @property integer $is_annelying
 * @property integer $is_inactive
 *
 * @property WorkOrderCuttingDetail $workOrderCuttingDetail
 * @property ManualDeliveryHeader $manualDeliveryHeader
 * @property ProductCategory $productCategory
 */
class ManualDeliveryDetailBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_manual_delivery_detail';
    }

    public function rules() {
        return array(
            array('manual_delivery_header_id, work_order_cutting_detail_id, product_category_id', 'required'),
            array('quantity, manual_delivery_header_id, work_order_cutting_detail_id, product_category_id, is_miling, is_sidemiling, is_grinding, is_hardness, is_annelying, is_inactive', 'numerical', 'integerOnly' => true),
            array('grade_name', 'length', 'max' => 100),
            array('length, width, height, weight', 'length', 'max' => 10),
            // The following rule is used by search().
            array('id, grade_name, length, width, height, weight, quantity, manual_delivery_header_id, work_order_cutting_detail_id, product_category_id, is_miling, is_sidemiling, is_grinding, is_hardness, is_annelying, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'workOrderCuttingDetail' => array(self::BELONGS_TO, 'WorkOrderCuttingDetail', 'work_order_cutting_detail_id'),
            'manualDeliveryHeader' => array(self::BELONGS_TO, 'ManualDeliveryHeader', 'manual_delivery_header_id'),
            'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'grade_name' => 'Grade Name',
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'weight' => 'Weight',
            'quantity' => 'Quantity',
            'manual_delivery_header_id' => 'Manual Delivery Header',
            'work_order_cutting_detail_id' => 'Work Order Cutting Detail',
            'product_category_id' => 'Product Category',
            'is_miling' => 'Is Miling',
            'is_sidemiling' => 'Is Sidemiling',
            'is_grinding' => 'Is Grinding',
            'is_hardness' => 'Is Hardness',
            'is_annelying' => 'Is Annelying',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.grade_name', $this->grade_name, true);
        $criteria->compare('t.length', $this->length, true);
        $criteria->compare('t.width', $this->width, true);
        $criteria->compare('t.height', $this->height, true);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.manual_delivery_header_id', $this->manual_delivery_header_id);
        $criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.is_miling', $this->is_miling);
        $criteria->compare('t.is_sidemiling', $this->is_sidemiling);
        $criteria->compare('t.is_grinding', $this->is_grinding);
        $criteria->compare('t.is_hardness', $this->is_hardness);
        $criteria->compare('t.is_annelying', $this->is_annelying);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
