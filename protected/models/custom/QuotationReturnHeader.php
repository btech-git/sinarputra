<?php

class QuotationReturnHeader extends QuotationReturnHeaderBase {
    const CN_CONSTANT = 'QRET';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->quotationReturnDetails as $quotationReturnDetail) {
            $total += $quotationReturnDetail->total;
        }

        return $total;
    }

    public function getGrandTotal() { //copy of above function for different name
        $total = 0.00;

        foreach ($this->quotationReturnDetails as $quotationReturnDetail) {
            $total += $quotationReturnDetail->total;
        }

        return $total;
    }

    public function getTotalByProduct($productId) {
        $total = 0.00;

        foreach ($this->quotationReturnDetails(array('with' => 'product', 'condition' => 'product.id = :product_id', 'params' => array(':product_id' => $productId))) as $quotationReturnDetail) {
            $total += $quotationReturnDetail->total;
        }

        return $total;
    }

    public function getTotalQuantityByProduct($productId) {
        $totalQuantity = 0.00;

        foreach ($this->quotationReturnDetails(array('with' => 'product', 'condition' => 'product.id = :product_id', 'params' => array(':product_id' => $productId))) as $quotationReturnDetail) {
            $totalQuantity += $quotationReturnDetail->quantity;
        }

        return $totalQuantity;
    }

    public function getQuotationReturnQuantityTotal($quotationReturn) {
        $total = 0;
        foreach ($quotationReturn->quotationReturnDetails as $quotationReturnDetail) {
            $total = $total + $quotationReturnDetail->quantity;
        }

        return $total;
    }

    public function getPackingMethod($quotationReturn) {
        $total = self::getQuotationReturnQuantityTotal($quotationReturn);

        $dus = 0;
        while ($total >= 12) {
            $total -= 12;
            $dus += 1;
        }

        return $dus . ' dus, ' . $total . ' pasang.';
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

}