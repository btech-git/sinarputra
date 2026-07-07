<?php

class PurchaseDetail extends PurchaseDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCalculatedWeight() {
        if ($this->productCategory == null) {
            return 0;
        } else {
            if ($this->product_category_id == 2) {
                $this->width = 1;
            }

            return round($this->height * $this->width * $this->length * $this->quantity * $this->productCategory->mass, 2);
        }
    }

    public function getUnitPrice() {
        return ((int)$this->purchaseHeader->is_tax === 0) ? $this->unit_price : $this->unit_price / 1.1;
    }

    public function getTotal() {
        return $this->weight * $this->unit_price;
    }

    public function getTotalReceived() {
        $total = 0;
        
        foreach ($this->receiveDetails as $detail) {
            $total += 1;
        }
        
        return $total;
    }
    
    public function getRemainingQuantity() {
        return $this->quantity - $this->totalReceived;
    }
    
    public function getReportDiscountItem() {
        return ($this->purchaseHeader->discount > 0) ? $this->unit_price * $this->purchaseHeader->discount / 100 : 0.00;
    }
    
    public function getReportTotalAfterDiscountItem() {
        return ($this->weight * $this->unit_price) - $this->reportDiscountItem;
    }
    
    public function getReportTaxItem() {
        return ((int)$this->purchaseHeader->is_tax == 1) ? $this->reportTotalAfterDiscountItem * 10 / 100 : 0.00;
    }
	
    public function getReportTotalAfterTaxItem() {
        return $this->reportTotalAfterDiscountItem + $this->reportTaxItem;
    }
}