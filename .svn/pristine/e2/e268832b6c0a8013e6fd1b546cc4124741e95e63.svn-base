<?php

class ReceiveItemHeader extends ReceiveItemHeaderBase {

    const CN_CONSTANT = 'RCVI';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->receiveItemDetails as $detail) {
            $total += $detail->total;
        }

        return $total;
    }

    public function getTotalBeforeTax() {
        return $this->subTotal - $this->purchaseItemHeader->discount;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->receiveItemDetails as $detail) {
            $total += $detail->quantity;
        }

        return $total;
    }

    public function getCalculatedTax() {
        return ((int) $this->purchaseItemHeader->is_tax == 1) ? $this->totalBeforeTax * .1 : 0.00;
    }

    public function getCalculatedTaxIncome() {
        return ((int) $this->purchaseItemHeader->is_tax_income == 1) ? $this->totalBeforeTax * .02 : 0.00;
    }

    public function getGrandTotal() {
        return $this->totalBeforeTax + $this->getCalculatedTax() - $this->getCalculatedTaxIncome();
    }

    public function searchForPurchaseInvoice() {
        $criteria = new CDbCriteria;

        $criteria->addCondition("t.id NOT IN (
            SELECT receive_item_header_id
            FROM " . PurchaseInvoice::model()->tableName() . "
            WHERE receive_item_header_id IS NOT NULL
        ) AND t.is_inactive = 0 AND t.date > '2021-12-31'");

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.purchase_item_header_id', $this->purchase_item_header_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 50
            ),
        ));
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.purchase_item_header_id', $this->purchase_item_header_id);
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
