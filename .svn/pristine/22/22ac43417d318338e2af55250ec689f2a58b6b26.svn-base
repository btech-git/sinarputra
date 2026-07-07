<?php

class Customer extends CustomerBase {
    const TRADER_VALUE = 0;
    const USER_VALUE = 1;
    const TRADER_LITERAL = 'Trader';
    const USER_LITERAL = 'User';
    
    const NON_TAX_VALUE = 0;
    const TAX_VALUE = 1;
    const NON_TAX_LITERAL = 'Tanpa PPn';
    const TAX_LITERAL = 'Dengan PPn';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTaxStatus() {
        return ($this->is_tax) ? self::TAX_LITERAL : self::NON_TAX_LITERAL;
    }

    public function getCustomerType() {
        return ($this->customer_type) ? self::USER_LITERAL : self::TRADER_LITERAL;
    }

    public function getCompleteTaxAddress() {
        return $this->tax_address_main . '. ' . $this->tax_address_secondary;
    }
    
    public function getOutstandingCredit() {
        $totalOutstanding = 0.00;

        foreach ($this->saleInvoiceHeaders as $saleInvoiceHeader) {
            if ((int)$saleInvoiceHeader->is_inactive == 0) {
                $totalOutstanding += $saleInvoiceHeader->remaining;
            }
        }

        foreach ($this->manualSaleInvoiceHeaders as $saleInvoiceHeader) {
            if ((int)$saleInvoiceHeader->is_inactive == 0) {
                $totalOutstanding += $saleInvoiceHeader->remaining;
            }
        }

        return $totalOutstanding;
    }

    public function getRemainingCreditLimit() {
        
        return $this->credit_limit - $this->outstandingCredit;
    }

    public function getTotalInvoiceSamplePerMonth($month, $year) {
        $total = 0;

        foreach ($this->saleHeaders as $saleHeader) {
            foreach ($saleHeader->workOrderCuttingHeaders as $workOrderCuttingHeader) {
                foreach ($workOrderCuttingHeader->deliveryHeaders as $deliveryHeader) {
                    foreach ($deliveryHeader->saleInvoices as $saleInvoice) {
                        $yearInvoice = CHtml::encode(Yii::app()->dateFormatter->format('yyyy', $saleInvoice->date));
                        $monthInvoice = CHtml::encode(Yii::app()->dateFormatter->format('MM', $saleInvoice->date));
                        if ($yearInvoice == $year && $monthInvoice == $month && $saleInvoice->deliveryHeader->is_sample == 1)
                            $total += $saleInvoice->grandTotal;
                    }
                }
            }
        }
                        
        return $total;
    }

    public function validateCreditLimit() {
        $valid = true;
        if ($this->credit_limit > 5000000000) {
            $valid = false;
            $this->addError('error', 'Credit Limit tidak bisa melebihi 5 Milyar');
        }

        return $valid;
    }
    
    public function getBeginningBalanceReceivable($startDate) {
        $sql = "
            SELECT COALESCE(SUM(debit - credit), 0) AS beginning_balance 
            FROM " . ReceivableLedger::model()->tableName() . "
            WHERE customer_id = :customer_id AND transaction_date < :start_date
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getReceivableLedgerReport($startDate, $endDate) {
        $params = array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT customer_id, transaction_number AS transaction_number, transaction_date AS transaction_date, note AS note, 
                    memo AS memo, debit AS debit, credit AS credit
                FROM " . ReceivableLedger::model()->tableName() . " 
                WHERE customer_id = :customer_id AND transaction_date BETWEEN :start_date AND :end_date
                ORDER BY transaction_date ASC, id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}