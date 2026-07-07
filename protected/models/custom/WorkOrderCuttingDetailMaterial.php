<?php

class WorkOrderCuttingDetailMaterial extends WorkOrderCuttingDetailMaterialBase {

    const PRIMARY_CONSTANT = 'LBR';
    const ROUND_CONSTANT = 'RND';
    const OFFCUT_CONSTANT = 'OC';
    const OTHER_CONSTANT = 'LN';
    const REMAINING = 0;
    const SLICE = 1;
    const REMAINING_LITERAL = 'Sipot';
    const SLICE_LITERAL = 'Belah';

    public $index;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSerialConstant() {

        $serialConstant = '';
        $detailTransaction = empty($this->receive_detail_id) ? $this->workOrderCuttingDetailMaterial : $this->receiveDetail;

        if ($this->product_category_id == 1)
            $serialConstant = self::PRIMARY_CONSTANT;
        else if ($this->product_category_id == 2)
            $serialConstant = self::ROUND_CONSTANT;
        else if ($this->product_category_id == 3)
            $serialConstant = self::OFFCUT_CONSTANT;
        else if ($this->product_category_id == 4)
            $serialConstant = self::OTHER_CONSTANT;

        return empty($detailTransaction) ? '' : sprintf($serialConstant . '%04d-%02d', $detailTransaction->serial_number, $this->serial_number);
    }

    public function getMaterialTypeValue() {
        $type = '';

        if ($this->material_type == 0)
            $type = self::REMAINING_LITERAL;
        else if ($this->material_type == 1)
            $type = self::SLICE_LITERAL;

        return $type;
    }

    public function getWeightCalculation() {
        $mass = CHtml::value($this, 'productCategory.mass');

//        $staticWeight = 1.00;

        if ($this->product_category_id != 2) {
            $weightRequest = $this->length * $this->width * $this->height * $mass;
        } else {
            $weightRequest = $this->length * $this->height * $this->height * $mass;
        }

        return $weightRequest;
    }

    public function searchForWorkOrder() {
        $criteria = new CDbCriteria;

        $criteria->addCondition('NOT EXISTS (
            SELECT work_order_cutting_detail_material_id 
            FROM ' . WorkOrderCuttingDetailMaterial::tableName() . ' wocdm
            WHERE work_order_cutting_detail_material_id IS NOT NULL 
            AND wocdm.work_order_cutting_detail_material_id = t.id
        )');

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name', $this->product_name, true);
        $criteria->compare('t.serial_number', $this->serial_number, true);
        $criteria->compare('t.length', $this->length, true);
        $criteria->compare('t.width', $this->width, true);
        $criteria->compare('t.height', $this->height, true);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.weight_tolerance', $this->weight_tolerance, true);
        $criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
        $criteria->compare('t.work_order_cutting_detail_material_id', $this->work_order_cutting_detail_material_id);
        $criteria->compare('t.receive_detail_id', $this->receive_detail_id);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.location_id', $this->location_id);
        $criteria->compare('t.material_type', $this->material_type);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.is_offcart', $this->is_offcart);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 50
            ),
        ));
    }

    public function searchProcessedStock() {
        $criteria = new CDbCriteria;

        $criteria->addCondition("t.id NOT IN (
            SELECT work_order_cutting_detail_material_id 
            FROM " . WorkOrderCuttingDetailMaterial::model()->tableName() . "  
            WHERE t.id = work_order_cutting_detail_material_id AND is_inactive = 0
        ) AND t.length > 0.00 AND t.location_id NOT IN (119) AND t.id > 643545 AND t.is_inactive = 0");

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.product_name', $this->product_name, true);
        $criteria->compare('t.serial_number', $this->serial_number, true);
        $criteria->compare('t.length', $this->length);
        $criteria->compare('t.width', $this->width);
        $criteria->compare('t.height', $this->height);
        $criteria->compare('t.weight', $this->weight, true);
//		$criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
        $criteria->compare('t.work_order_cutting_detail_material_id', $this->work_order_cutting_detail_material_id);
        $criteria->compare('t.receive_detail_id', $this->receive_detail_id);
        $criteria->compare('t.location_id', $this->location_id);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
}