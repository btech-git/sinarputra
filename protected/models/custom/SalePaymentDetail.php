<?php

class SalePaymentDetail extends SalePaymentDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getAmountAfterIncomeTax() {
        return ((int)$this->saleInvoiceHeader->is_tax_income == 0) ? 0.00 : $this->amount * $this->income_tax / 100;
    }
    
    
    public function getReceivableAfterIncomeTax() {
        return ((int)$this->saleInvoiceHeader->is_tax_income == 0) ? $this->saleInvoiceHeader->remaining : $this->saleInvoiceHeader->remaining * (1 - $this->income_tax / 100);
    }
    
    public function getPaymentAfterIncomeTax() {
        return ((int)$this->saleInvoiceHeader->is_tax_income == 0) ? 0.00 : $this->amount * (1 - $this->income_tax / 100);
    }
    
    public function getSaleReceiptDetailId() {
        $saleReceiptDetail = SaleReceiptDetail::model()->findByAttributes(array('sale_invoice_header_id' => $this->sale_invoice_header_id));
        
        return empty($saleReceiptDetail) ? "" : $saleReceiptDetail;
    }
}