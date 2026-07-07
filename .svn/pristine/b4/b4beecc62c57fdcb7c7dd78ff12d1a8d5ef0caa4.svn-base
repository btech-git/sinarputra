<?php

class ManualSaleInvoiceDetail extends ManualSaleInvoiceDetailBase {

    const IS_USING_WEIGHT = 1;
    const IS_USING_QUANTITY = 2;
    const IS_USING_QUANTITY_LITERAL = 'Pcs';
    const IS_USING_WEIGHT_LITERAL = 'Berat';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getMultiplicationStatus() {
        return ($this->is_using_weight == 0) ? self::IS_USING_QUANTITY_LITERAL : self::IS_USING_WEIGHT_LITERAL;
    }

    public function getTotal() {

        $optionMultiplication = ((int) $this->is_using_weight == 0) ? $this->quantity : $this->weight;
        return $this->unit_price * $optionMultiplication + $this->rounding_amount;
    }

    public function getTotalWithTax() {

        return round($this->total * $this->manualSaleInvoiceHeader->tax_percentage / 100, 0);
    }

    public function getTotalWithCoretax() {

        return round($this->total * 11 / 12, 2);
    }

    public function getUnitPriceTax() {
        return $this->unit_price / (1 + ($this->manualSaleInvoiceHeader->tax_percentage / 100));
    }

    public function getUnitPriceForTaxForm() {
        return $this->total / $this->quantity;
    }
}
