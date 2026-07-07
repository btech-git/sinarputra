<?php

class PurchaseHeader extends PurchaseHeaderBase {
    const CN_CONSTANT = 'PRC';

    const PENDING = 0;
    const CONFIRMED = 1;

    const PENDING_LITERAL = 'Waiting for Confirmation';
    const CONFIRMED_LITERAL = 'Confirmed';

    const PRODUCT = 0;
    const SERVICE = 1;

    const PRODUCT_LITERAL = 'Barang';
    const SERVICE_LITERAL = 'Jasa';

    const EXCLUDE_TAX = 0;
    const INCLUDE_TAX = 1;

    const EXCLUDE_TAX_LITERAL = 'Belum Termasuk PPn';
    const INCLUDE_TAX_LITERAL = 'Termasuk PPn';

    const LOCAL = 0;
    const IMPORT = 1;

    const LOCAL_LITERAL = 'Lokal';
    const IMPORT_LITERAL = 'Impor';

    const COD = 0;
    const DAYS_15 = 1;
    const DAYS_30 = 2;
    const DAYS_60 = 3;
    const DAYS_90 = 4;
    const DAYS_45 = 5;

    const COD_LITERAL = 'COD';
    const DAYS_15_LITERAL = '15 hari';
    const DAYS_30_LITERAL = '30 hari';
    const DAYS_60_LITERAL = '60 hari';
    const DAYS_90_LITERAL = '90 hari';
    const DAYS_45_LITERAL = '45 hari';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductServiceStatus() {
        return ($this->is_service) ? self::SERVICE_LITERAL : self::PRODUCT_LITERAL;
    }

    public function getTaxStatus() {
        return ($this->is_tax) ? self::INCLUDE_TAX_LITERAL : self::EXCLUDE_TAX_LITERAL;
    }

    public function getConfirmationStatus() {
        return ($this->is_confirmed) ? self::CONFIRMED_LITERAL : self::PENDING_LITERAL;
    }

    public function getImportStatus() {
        return ($this->is_import) ? self::IMPORT_LITERAL : self::LOCAL_LITERAL;
    }

    public function getPaymentStatus() {
        $status = '';

        if ($this->payment_period == 0)
            $status = self::COD_LITERAL;
        else if ($this->payment_period == self::DAYS_15)
            $status = self::DAYS_15_LITERAL;
        else if ($this->payment_period == self::DAYS_30)
            $status = self::DAYS_30_LITERAL;
        else if ($this->payment_period == self::DAYS_60)
            $status = self::DAYS_60_LITERAL;
        else if ($this->payment_period == self::DAYS_90)
            $status = self::DAYS_90_LITERAL;
        else if ($this->payment_period == self::DAYS_45)
            $status = self::DAYS_45_LITERAL;

        return $status;
    }

    public function getSubTotal() {
        $total = 0.00;
        if ($this->purchaseDetails) {
            foreach ($this->purchaseDetails as $detail) {
                if ((int)$detail->is_inactive == 0) {
                    $total += $detail->total;
                }
            }
        } else {
            foreach ($this->purchaseDetailServices as $detail) {
                if ((int)$detail->is_inactive == 0) {
                    $total += $detail->totalService;
                }
            }
        }

        return $total;
    }

    public function getSubTotalQuantity() {
        $total = 0.00;

        if ($this->purchaseDetails) {
            foreach ($this->purchaseDetails as $detail) {
                if ((int)$detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        } else {
            foreach ($this->purchaseDetailServices as $detail) {
                if ((int)$detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }
        
        return $total;
    }

//    public function getDiscountAmount() {
//        return $this->discount / 100 * $this->getSubTotal();
//    }

    public function getTotalBeforeTax() {
        return $this->subTotal - $this->discount;
    }
    
    public function getCalculatedTax() {
        return $this->getTotalBeforeTax() * $this->tax_percentage / 100;
    }

    public function getCalculatedTaxIncome() {
        return ((int)$this->is_tax_income === 1) ? $this->getTotalBeforeTax() * .003 : 0.00;
    }

    public function getGrandTotal() {
        return $this->getTotalBeforeTax() + $this->getCalculatedTax() + $this->getCalculatedTaxIncome();
    }

    public function searchByReceive() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            " . SqlViewGenerator::purchaseQuantityRemaining() . "
            WHERE t.id = p.purchase_header_id AND t.is_confirmed = 1
            HAVING quantity_purchased > 0
        ) AND t.date > '2021-12-31'";

        $criteria->compare('cn_ordinal', $this->cn_ordinal);
        $criteria->compare('cn_month', $this->cn_month);
        $criteria->compare('cn_year', $this->cn_year);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('note', $this->note);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 50
            ),
        ));
    }

    public function searchByItemReceived($isNonTax = null) {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT p.quantity - SUM(COALESCE(r.quantity, 0)) AS quantity_purchased
            FROM " . PurchaseDetail::model()->tableName() . " p
            LEFT OUTER JOIN " . ReceiveDetail::model()->tableName() . " r
            ON p.id = r.purchase_detail_id
            WHERE t.id = p.purchase_header_id AND p.is_inactive = 0
            GROUP BY p.id
            HAVING quantity_purchased > 0
        ) AND t.date > '2021-12-31'";

        if ($isNonTax !== null) {
            $criteria->addCondition('t.is_non_tax = :is_non_tax');
            $criteria->params[':is_non_tax'] = intval($isNonTax);
        }

        $criteria->compare('cn_ordinal', $this->cn_ordinal, true);
        $criteria->compare('cn_month', $this->cn_month, true);
        $criteria->compare('cn_year', $this->cn_year, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('supplier_id', $this->supplier_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.downpayment', $this->downpayment, true);
        $criteria->compare('t.exchange_rate', $this->exchange_rate, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.delivery_period', $this->delivery_period);
        $criteria->compare('t.payment_period', $this->payment_period);
        $criteria->compare('t.valid_period', $this->valid_period);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.currency_id', $this->currency_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_import', $this->is_import);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_tax_income', $this->is_tax_income);
        $criteria->compare('t.is_confirmed', $this->is_confirmed);
        $criteria->compare('t.is_service', $this->is_service);
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

    public function getStatusOpenClose() {
        $totalQuantityReceive = 0;
        
        foreach ($this->receiveHeaders as $receiveHeader) {
            if ($receiveHeader->is_inactive == 0) {
                foreach ($receiveHeader->receiveDetails as $receiveDetail) {
                    if ($receiveDetail->is_inactive == 0)
                        $totalQuantityReceive += 1;
                }
            }
        }
        
        $remaining = $this->subTotalQuantity - $totalQuantityReceive;
        
        return ($remaining > 0) ? 'Open' : 'Close';
    }
//    public function getServiceSubTotal() {
//        $total = 0.00;
//
//        foreach ($this->purchaseDetailServices as $service)
//            $total += $service->totalService;
//
//        return $total;
//    }
//
//    public function getServiceSubTotalQuantity() {
//        $total = 0.00;
//
//        foreach ($this->purchaseDetailServices as $service)
//            $total += $service->quantity;
//
//        return $total;
//    }

//    public function getTaxPercentage() {
//        if ((int)$this->is_service === 1)
//            $taxPercentage = ((int)$this->is_tax === 1) ? 2 : 0;
//        else
//            $taxPercentage = ((int)$this->is_tax === 1) ? 10 : 0;
//        
//        return $taxPercentage;
//    }
}