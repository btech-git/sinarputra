<?php

class PurchaseItemHeader extends PurchaseItemHeaderBase {

    const CN_CONSTANT = 'PRCI';
    const COD = 0;
    const DAYS_15 = 1;
    const DAYS_30 = 2;
    const DAYS_60 = 3;
    const DAYS_90 = 4;
    const DAYS_45 = 5;
    const COD_LITERAL = 'COD';
    const DAYS_15_LITERAL = '15 hari';
    const DAYS_30_LITERAL = '30 hari';
    const DAYS_60_LITERAL = '60 hari';
    const DAYS_90_LITERAL = '90 hari';
    const DAYS_45_LITERAL = '45 hari';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPaymentStatus() {
        $status = '';

        if ($this->payment_period == 0)
            $status = self::COD_LITERAL;
        else if ($this->payment_period == 1)
            $status = self::DAYS_15_LITERAL;
        else if ($this->payment_period == 2)
            $status = self::DAYS_30_LITERAL;
        else if ($this->payment_period == 3)
            $status = self::DAYS_60_LITERAL;
        else if ($this->payment_period == 4)
            $status = self::DAYS_90_LITERAL;
        else if ($this->payment_period == self::DAYS_45)
            $status = self::DAYS_45_LITERAL;

        return $status;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->purchaseItemDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->total;
            }
        }

        return $total;
    }

    public function getSubTotalQuantity() {
        $total = 0.00;

        foreach ($this->purchaseItemDetails as $detail) {
            if ((int)$detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }

    public function getTotalBeforeTax() {
        return $this->subTotal - $this->discount;
    }

    public function getCalculatedTax() {
        return ((int) $this->is_tax === 1) ? $this->getTotalBeforeTax() * $this->tax_percentage / 100 : 0.00;
    }

    public function getCalculatedTaxIncome() {
        return ((int) $this->is_tax_income === 1) ? $this->getTotalBeforeTax() * .02 : 0.00;
    }

    public function getGrandTotal() {
        return $this->getTotalBeforeTax() + $this->getCalculatedTax() - $this->getCalculatedTaxIncome();
    }

    public function searchByReceiveItem() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            " . SqlViewGenerator::purchaseItemQuantityRemaining() . "
            WHERE t.id = p.purchase_item_header_id
            HAVING quantity_purchased > 0
        ) AND t.date > '2021-12-31'";

        $criteria->compare('cn_ordinal', $this->cn_ordinal);
        $criteria->compare('cn_month', $this->cn_month);
        $criteria->compare('cn_year', $this->cn_year);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('note', $this->note);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.is_tax', $this->is_tax);
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

    public function getStatusOpenClose() {
        $totalQuantityReceive = 0;

        foreach ($this->receiveItemHeaders as $receiveHeader) {
            if ($receiveHeader->is_inactive == 0) {
                foreach ($receiveHeader->receiveItemDetails as $receiveDetail) {
                    if ($receiveDetail->is_inactive == 0) {
                        $totalQuantityReceive += $receiveDetail->quantity;
                    }
                }
            }
        }

        $remaining = $this->subTotalQuantity - $totalQuantityReceive;

        return ($remaining > 0) ? 'Open' : 'Close';
    }
}
