<?php

class SaleDetail extends SaleDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getQuantity() {
        return ((int)$this->quotation_detail_product_id == null) ? $this->quotationDetailService->quantity_quote : $this->quotationDetailProduct->quantity_quote;
    }
    
    public function getUnitPrice() {
        $unitPrice = 0.00;
        
        if ((int)$this->quotation_detail_product_id == null) {
            $unitPrice = ((int)$this->quotationDetailService->quotationHeader->is_tax == 0) ? $this->quotationDetailService->unit_price : $this->quotationDetailService->unit_price / 1.1;
        }
        else {
            $unitPrice = ((int)$this->quotationDetailProduct->quotationHeader->is_tax == 0) ? $this->quotationDetailProduct->unit_price : $this->quotationDetailProduct->unit_price / 1.1;
        }
        return $unitPrice;
    }
    
    public function getTotal() {
        return ((int)$this->quotation_detail_product_id == null) ? $this->quotationDetailService->total : $this->quotationDetailProduct->total;
    }
}