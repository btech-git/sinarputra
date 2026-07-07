<?php

class ManualSaleInvoiceHeader extends ManualSaleInvoiceHeaderBase {

    const CN_CONSTANT = 'SIM';
    const ST_PRODUCT = 0;
    const ST_MILING = 1;
    const ST_CUTTING = 2;
    const ST_HARDENING = 3;
    const ST_SAMPLE = 4;
    const ST_GRINDING = 5;
    const ST_MILING_GRINDING = 6;
    const ST_PRODUCT_LITERAL = 'Product';
    const ST_MILING_LITERAL = 'Jasa Miling';
    const ST_GRINDING_LITERAL = 'Jasa Grinding';
    const ST_MILING_GRINDING_LITERAL = 'Jasa Miling dan Grinding';
    const ST_CUTTING_LITERAL = 'Jasa Potong';
    const ST_HARDENING_LITERAL = 'Jasa Harden';
    const ST_SAMPLE_LITERAL = 'Sample';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getServiceType($type) {
        switch ($type) {
            case self::ST_PRODUCT: return self::ST_PRODUCT_LITERAL;
            case self::ST_MILING: return self::ST_MILING_LITERAL;
            case self::ST_GRINDING: return self::ST_GRINDING_LITERAL;
            case self::ST_MILING_GRINDING: return self::ST_MILING_GRINDING_LITERAL;
            case self::ST_CUTTING: return self::ST_CUTTING_LITERAL;
            case self::ST_HARDENING: return self::ST_HARDENING_LITERAL;
            case self::ST_SAMPLE: return self::ST_SAMPLE_LITERAL;
            default: return '';
        }
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->manualSaleInvoiceDetails as $detail) {
            if ($detail->is_inactive == 0)
                $total += $detail->quantity;
        }

        return $total;
    }

    public function getTotalWeight() {
        $total = 0.00;

        foreach ($this->manualSaleInvoiceDetails as $detail) {
            if ($detail->is_inactive == 0)
                $total += $detail->weight;
        }

        return $total;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->manualSaleInvoiceDetails as $detail) {
            if ($detail->is_inactive == 0)
                $total += $detail->total;
        }

        return $total;
    }

    public function getSubTotalBeforeTax() {
        return $this->getSubTotal() - $this->discount + $this->rounding_nominal;
    }

    public function getCalculatedTax() {
        return round($this->getSubTotalBeforeTax() * $this->tax_percentage / 100);
    }

    public function getCalculatedTaxIncome() {
        $taxIncomePercentage = (int) $this->is_tax_income === 0 ? 0 : 2;

        return round($this->getSubTotalBeforeTax() * $taxIncomePercentage / 100);
    }

    public function getGrandTotal() {
        return $this->getSubTotalBeforeTax() + $this->getCalculatedTax() - $this->getCalculatedTaxIncome();
    }

    public function getPayment() {
        if ($this->manualSalePaymentDetails == null) {
            return 0.00;
        } else {
            $total = 0.00;

            foreach ($this->manualSalePaymentDetails as $detail) {
                $total += $detail->amount + $detail->additional_payment_1 + $detail->additional_payment_2;
            }

            return $total;
        }
    }

    public function getRemaining() {
        return $this->grand_total - $this->total_payment - $this->total_return;
    }

    public function searchForSaleReceipt() {
        $dataProvider = $this->search();

        $dataProvider->criteria->addCondition("
            t.id NOT IN (
                SELECT saleReceiptDetail.manual_sale_invoice_header_id
                FROM " . ManualSaleReceiptDetail::model()->tableName() . " saleReceiptDetail
                WHERE saleReceiptDetail.is_inactive = 0
            ) AND t.date > '2021-12-31'
        ");

        return $dataProvider;
    }

    public function searchForSalePayment() {
        $criteria = new CDbCriteria;

        $criteria->condition = "(grand_total - total_return - total_payment) > 0 AND t.is_inactive = 0";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.due_date', $this->due_date, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }
}
