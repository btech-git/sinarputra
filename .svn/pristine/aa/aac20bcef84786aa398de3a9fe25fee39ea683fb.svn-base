<?php

class DeliveryDetail extends DeliveryDetailBase {

    public $workOrderQuantity;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSaleQuantityRemaining() {
        $sql = SqlViewGenerator::saleQuantityRemaining() . "
				WHERE s.id = :sale_detail_id";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':sale_detail_id' => $this->sale_detail_id,
        ));

        return ($value === false) ? 0 : $value;
    }

    //used at sale invoice view
    public function getTotal() {
        $mass = CHtml::value($this, 'workOrderCuttingDetailProduct.saleDetailProduct.quotationDetailProduct.productCategory.mass');

        if ($mass < 1)
            $mass = 1;

        return $this->length * $this->width * $this->height * $mass * CHtml::value($this,
        'workOrderCuttingDetailProduct.saleDetailProduct.quotationDetailProduct.quantity_quote') * CHtml::value($this,
        'workOrderCuttingDetailProduct.saleDetailProduct.quotationDetailProduct.unit_price');
    }

    public function getWeightByQuantity() {

        return ($this->workOrderCuttingDetail->quantity == 0) ? 0 : $this->quantity * ($this->workOrderCuttingDetail->weight / $this->workOrderCuttingDetail->quantity);
    }

    public function searchForSaleInvoice() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array('deliveryHeader');
        $criteria->condition = "t.id NOT IN (
            SELECT delivery_detail_id
            FROM " . ManualSaleInvoiceDetail::model()->tableName() . "   
            WHERE t.id = delivery_detail_id 
        ) AND t.is_inactive = 0 AND deliveryHeader.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.grade_name', $this->grade_name, true);
        $criteria->compare('t.length', $this->length, true);
        $criteria->compare('t.width', $this->width, true);
        $criteria->compare('t.height', $this->height, true);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.quantity', $this->quantity);
        $criteria->compare('t.quality_control_cutting_detail_id', $this->quality_control_cutting_detail_id);
        $criteria->compare('t.quality_control_miling_detail_id', $this->quality_control_miling_detail_id);
        $criteria->compare('t.work_order_cutting_detail_id', $this->work_order_cutting_detail_id);
        $criteria->compare('t.delivery_header_id', $this->delivery_header_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }
}
