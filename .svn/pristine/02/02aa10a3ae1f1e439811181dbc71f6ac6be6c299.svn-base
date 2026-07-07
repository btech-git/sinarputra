<?php

class SaleReceiptDetail extends SaleReceiptDetailBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
    
    public function getRemaining()
    {
        return $this->total_invoice - $this->total_payment;
    }
    
	public function getPayment()
	{
		$payment = 0.00;

        foreach($this->salePaymentDetails as $paymentDetail)
            $payment += $paymentDetail->amount;

		return $payment;
	}
}