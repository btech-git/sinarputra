<?php

class MaterialPaymentHeader extends MaterialPaymentHeaderBase {

    const CN_CONSTANT = 'MPY';
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalReceivable() {
        $total = 0.00;

        foreach ($this->materialPaymentDetails as $detail) {
            $total += $detail->materialInvoiceHeader->remaining_payment;
        }

        return $total;
    }

    public function getTotalPayment() {
        $total = 0.00;

        foreach ($this->materialPaymentDetails as $detail) {
            $total += $detail->amount;
        }

        return $total;
    }
}
