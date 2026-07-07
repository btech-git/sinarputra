<?php

class ReceiveDetail extends ReceiveDetailBase {

    //custom attributes for searching
//    public $productId;

    const PRIMARY_CONSTANT = 'LBR';
    const ROUND_CONSTANT = 'RND';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getWidth() {
        if ($this->product_category_id == 2) {
            return 0.00;
        } else {
            return $this->width;
        }
    }

    public function getWeightRequestForReceive() {
        $mass = CHtml::value($this, 'productCategory.mass');
        
        if ((int)$this->product_category_id === 2 || (int)$this->product_category_id === 5) {
            $weight = $this->height * $this->height * $this->length * $mass;
        } else {
            $weight = $this->length * $this->width * $this->height * $mass;
        }

        return round($weight, 2);
    }

    public function getCalculatedWeight() {
        return $this->length * $this->width * $this->height * $this->productCategory->mass;
    }

    public function getSerialConstant() {
        $serialConstant = '';
        $transactionDate = empty($this->receiveHeader) ? '' : Yii::app()->dateFormatter->format("MMyy", $this->receiveHeader->date);

        if ($this->product_category_id == 1 || $this->product_category_id == 3) {
            $serialConstant = self::PRIMARY_CONSTANT;
        } else if ($this->product_category_id == 2 || $this->product_category_id == 5) {
            $serialConstant = self::ROUND_CONSTANT;
        }

        return sprintf($serialConstant . $transactionDate . '/%04d', $this->serial_number);
    }

    public function searchForCutting() {
        $criteria = new CDbCriteria;

        $criteria->limit = 100;
        
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name', $this->product_name, true);
        $criteria->compare('t.length', $this->length, true);
        $criteria->compare('t.width', $this->width, true);
        $criteria->compare('t.height', $this->height, true);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.serial_number', $this->serial_number);
        $criteria->compare('t.product_category_id', $this->product_category_id);
//        $criteria->compare('t.receive_header_id', $this->receive_header_id);
//        $criteria->compare('t.purchase_detail_id', $this->purchase_detail_id);
        $criteria->compare('t.location_id', $this->location_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchNotSelectedInCuttingDetailMaterial() {
        $criteria = new CDbCriteria;

        $criteria->addCondition("t.id NOT IN (
                SELECT receive_detail_id 
                FROM " . WorkOrderCuttingDetailMaterial::model()->tableName() . "  
                WHERE t.id = receive_detail_id AND is_inactive = 0
        ) AND t.id > 333840 AND t.location_id NOT IN (119) AND t.length > 0.00 AND t.is_inactive = 0");

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name', $this->product_name, true);
        $criteria->compare('t.length', $this->length);
        $criteria->compare('t.width', $this->width);
        $criteria->compare('t.height', $this->height);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.serial_number', $this->serial_number, true);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.location_id', $this->location_id);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function getPurchaseQuantityRemaining() {
        $sql = SqlViewGenerator::purchaseQuantityRemaining() . "
                WHERE p.id = :purchase_detail_id";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':purchase_detail_id' => $this->purchase_detail_id,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotal() {
        return $this->purchaseDetail->weight * $this->purchaseDetail->unit_price;
    }

}
