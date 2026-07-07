<?php

class PurchaseInvoice extends PurchaseInvoiceBase {

    const CN_CONSTANT = 'PIN';
    const CN_CONSTANT_TAX = 'SPMPIN';
    const CN_CONSTANT_NON_TAX = 'SMPIN';
    const MATERIAL = 0;
    const ITEM = 1;
    const MATERIAL_LITERAL = 'Material';
    const ITEM_LITERAL = 'Barang Penunjang';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPurchasingStatus() {
        return ($this->is_item) ? self::ITEM_LITERAL : self::MATERIAL_LITERAL;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $purchaseInvoice = PurchaseInvoice::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($purchaseInvoice !== null)
            $this->setCodeNumber($purchaseInvoice->cn_ordinal, $purchaseInvoice->cn_month, $purchaseInvoice->cn_year);

        $this->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function searchForPurchaseReceipt() {
        $criteria = new CDbCriteria;

        $criteria->addCondition("t.id NOT IN (
            SELECT purchase_invoice_id
            FROM " . PurchaseReceiptDetail::model()->tableName() . "
        ) AND t.date > '2021-12-31'");

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.rounding_nominal', $this->rounding_nominal, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.total_payment', $this->total_payment, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.receive_header_id', $this->receive_header_id);
        $criteria->compare('t.receive_item_header_id', $this->receive_item_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_item', $this->is_item);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getSubTotal() {
        $subTotal = 0.00;

        if (empty($this->receive_header_id)) {
            $subTotal = $this->receiveItemHeader->subTotal;
        } else {
            $subTotal = $this->receiveHeader->purchaseHeader->subTotal;
        }

        return $subTotal;
    }

    public function getTotalBeforeTax() {
        return $this->subTotal - $this->discount_amount;
    }

    public function getCalculatedTax() {

        $taxPercentage = empty($this->receive_header_id) ? $this->receiveItemHeader->purchaseItemHeader->tax_percentage : $this->receiveHeader->purchaseHeader->tax_percentage;
        $taxAmount = $this->getTotalBeforeTax() * $taxPercentage / 100;

        return $taxAmount;
    }

    public function getCalculatedTaxIncome() {

        $purchaseHeader = empty($this->receive_header_id) ? $this->receiveItemHeader->purchaseItemHeader : $this->receiveHeader->purchaseHeader;
        $taxAmount = ((int) $purchaseHeader->is_tax_income === 1) ? $this->getTotalBeforeTax() * .02 : 0.00;

        return $taxAmount;
    }

    public function getGrandTotal() {
        return $this->getTotalBeforeTax() + $this->getCalculatedTax() + $this->getCalculatedTaxIncome();
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.rounding_nominal', $this->rounding_nominal, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.total_payment', $this->total_payment, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.receive_header_id', $this->receive_header_id);
        $criteria->compare('t.receive_item_header_id', $this->receive_item_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_item', $this->is_item);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }
}
