<?php

class PurchaseDetailService extends PurchaseDetailServiceBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalService() {
        return $this->quantity * $this->weight * $this->amount;
    }

    public function getAmountTax() {
        return $this->amount / 1.1;
    }

    public function getTotalServiceTax() {
        return $this->weight * $this->getAmountTax() ;
    }

    public function getReportDiscountItem() {
        return ($this->purchaseHeader->discount > 0) ? $this->unit_price * $this->purchaseHeader->discount / 100 : 0.00;
    }
    
    public function getReportTotalAfterDiscountItem() {
        return $this->unit_price - $this->reportDiscountItem;
    }
    
    public function getReportTaxItem() {
        return ((int)$this->purchaseHeader->is_tax == 1) ? $this->reportTotalAfterDiscountItem * 10 / 100 : 0.00;
    }
	
    public function getReportTotalAfterTaxItem() {
        return $this->reportTotalAfterDiscountItem + $this->reportTaxItem;
    }
}