<?php

class PurchaseItemDetail extends PurchaseItemDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal() {
        return $this->quantity * $this->unit_price;
    }

    public function getTotalReceived() {
        $total = 0;

        foreach ($this->receiveItemDetails as $detail) {
            if ((int) $detail->is_inactive === 0)
                $total += $detail->quantity;
        }

        return $total;
    }

    public function getRemainingQuantity() {
        return $this->quantity - $this->totalReceived;
    }

    public function getReportDiscountItem() {
        return ($this->purchaseItemHeader->discount > 0) ? $this->unit_price * $this->purchaseItemHeader->discount / 100 : 0.00;
    }

    public function getReportTotalAfterDiscountItem() {
        return ($this->quantity * $this->unit_price) - $this->reportDiscountItem;
    }

    public function getReportTaxItem() {
        return ((int) $this->purchaseItemHeader->is_tax == 1) ? $this->reportTotalAfterDiscountItem * 10 / 100 : 0.00;
    }

    public function getReportTotalAfterTaxItem() {
        return $this->reportTotalAfterDiscountItem + $this->reportTaxItem;
    }

}
