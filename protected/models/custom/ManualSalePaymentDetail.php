<?php

class ManualSalePaymentDetail extends ManualSalePaymentDetailBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSaleInvoiceGrandTotal() {
        return $this->manualSaleInvoiceHeader->grandTotal;
    }

    public function getSaleInvoiceRemaining() {
        return $this->manualSaleInvoiceHeader->remaining;
    }

    public function getAmountAfterIncomeTax() {
        return ((int) $this->manualSaleInvoiceHeader->is_tax_income == 0) ? 0.00 : $this->amount * $this->income_tax / 100;
    }

    public function getReceivableAfterIncomeTax() {
        return ((int) $this->manualSaleInvoiceHeader->is_tax_income == 0) ? $this->manualSaleInvoiceHeader->remaining : $this->manualSaleInvoiceHeader->remaining * (1 - $this->income_tax / 100);
    }

    public function getPaymentAfterIncomeTax() {
        return ((int) $this->manualSaleInvoiceHeader->is_tax_income == 0) ? 0.00 : $this->amount * (1 - $this->income_tax / 100);
    }

    public function getSaleReceiptDetailId() {
        $saleReceiptDetail = ManualSaleReceiptDetail::model()->findByAttributes(array('manual_sale_invoice_header_id' => $this->manual_sale_invoice_header_id));

        return empty($saleReceiptDetail) ? "" : $saleReceiptDetail;
    }

}
