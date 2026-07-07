<?php

class MaterialInvoiceHeader extends MaterialInvoiceHeaderBase {

    const CN_CONSTANT = 'MTI';
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->materialInvoiceDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->total;
            }
        }

        return $total;
    }

    public function getSubTotalQuantity() {
        $total = 0.00;

        foreach ($this->materialInvoiceDetails as $detail) {
            if ((int)$detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }

    public function getTotalBeforeTax() {
        return $this->subTotal - $this->discount;
    }

    public function getCalculatedTax() {
        return ((int) $this->is_tax == 1) ? $this->getTotalBeforeTax() * $this->tax_percentage / 100 : 0.00;
    }

    public function getCalculatedTaxIncome() {
        return ((int) $this->is_tax_income == 1) ? $this->getTotalBeforeTax() * .02 : 0.00;
    }

    public function getGrandTotal() {
        return $this->getTotalBeforeTax() + $this->getCalculatedTax() - $this->getCalculatedTaxIncome();
    }

    public function getPayment() {
        $total = '0.00';
            
        if (!empty($this->materialPaymentDetails)) {
            foreach ($this->materialPaymentDetails as $detail) {
                if ($detail->is_inactive == 0) { 
                    $total += $detail->amount + $detail->additional_payment_1 + $detail->additional_payment_2;
                }
            }
        }

        return $total;
    }
    
    public function getRemainingPayment() {
        return $this->grand_total - $this->total_payment;
    }

    public function searchForMaterialReceipt() {
        $dataProvider = $this->search();

        $dataProvider->criteria->addCondition("
            t.id NOT IN (
                SELECT material_invoice_header_id
                FROM " . MaterialReceiptDetail::model()->tableName() . " 
                WHERE is_inactive = 0
            ) AND t.date > '2021-12-31'
        ");

        return $dataProvider;
    }

    public function searchForMaterialPayment() {
        $criteria = new CDbCriteria;

        $criteria->condition = "(grand_total - total_payment) > 0 AND t.is_inactive = 0";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.reference_number', $this->reference_number, true);
        $criteria->compare('t.tax_number', $this->tax_number, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.due_date', $this->due_date, true);
        $criteria->compare('t.datetime_created', $this->datetime_created, true);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.rounding_nominal', $this->rounding_nominal, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.total_payment', $this->total_payment, true);
        $criteria->compare('t.remaining_payment', $this->remaining_payment, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.employee_id_salesman', $this->employee_id_salesman);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_tax_income', $this->is_tax_income);
        $criteria->compare('t.is_inactive', $this->is_inactive);
        $criteria->compare('t.admin_id', $this->admin_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }
}
