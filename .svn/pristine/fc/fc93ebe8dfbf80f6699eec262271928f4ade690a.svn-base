<?php

class QuotationHeader extends QuotationHeaderBase {

    const CN_CONSTANT = 'QTN';
    const CN_CONSTANT_SERVICE = 'QOTS';
    const CN_CONSTANT_PRODUCT = 'QOTP';
    const PENDING = 0;
    const CONFIRMED = 1;
    const PENDING_LITERAL = 'Pending';
    const CONFIRMED_LITERAL = 'Confirmed';
    const SERVICE = 1;
    const PRODUCT = 0;
    const SERVICE_LITERAL = 'Service';
    const PRODUCT_LITERAL = 'Product';
    const IS_TAX = 1;
    const IS_NON_TAX = 0;
    const IS_TAX_LITERAL = 'Sudah';
    const IS_NON_TAX_LITERAL = 'Belum';
    const COD = 0;
    const DAYS_15 = 1;
    const DAYS_30 = 2;
    const DAYS_60 = 3;
    const DAYS_90 = 4;
    const COD_LITERAL = 'COD';
    const DAYS_15_LITERAL = '15 hari';
    const DAYS_30_LITERAL = '30 hari';
    const DAYS_60_LITERAL = '60 hari';
    const DAYS_90_LITERAL = '90 hari';
    const CANCEL_GRADE = 1;
    const CANCEL_STOCK = 2;
    const CANCEL_PRICE = 3;
    const CANCEL_DELIVERY = 4;
    const CANCEL_SUPPORT = 5;
    const CANCEL_GRADE_LITERAL = 'Grade';
    const CANCEL_STOCK_LITERAL = 'Stock';
    const CANCEL_PRICE_LITERAL = 'Price';
    const CANCEL_DELIVERY_LITERAL = 'Delivery';
    const CANCEL_SUPPORT_LITERAL = 'Support';
    const CURRENT = 0;
    const REPLACEMENT = 1;
    const CURRENT_LITERAL = 'New';
    const REPLACEMENT_LITERAL = 'Replacement';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCnConstant() {
        if ($this->is_service === null || $this->is_service === '')
            return '';
        else
            return ($this->is_service) ? self::CN_CONSTANT_SERVICE : self::CN_CONSTANT_PRODUCT;
    }

    public function getConfirmationStatus() {
        return ($this->is_confirmed) ? self::CONFIRMED_LITERAL : self::PENDING_LITERAL;
    }

    public function getIsTaxStatus() {
        return ($this->is_tax) ? self::IS_TAX_LITERAL : self::IS_NON_TAX_LITERAL;
    }

    public function getTransactionType() {
        return ($this->is_service) ? self::SERVICE_LITERAL : self::PRODUCT_LITERAL;
    }

    public function getPaymentStatus() {
        $status = '';

        if ($this->payment_period == 0)
            $status = self::COD_LITERAL;
        else if ($this->payment_period == 1)
            $status = self::DAYS_15_LITERAL;
        else if ($this->payment_period == 2)
            $status = self::DAYS_30_LITERAL;
        else if ($this->payment_period == 3)
            $status = self::DAYS_60_LITERAL;
        else if ($this->payment_period == 4)
            $status = self::DAYS_90_LITERAL;

        return $status;
    }

    public function getCancellationRemarkLiteral() {
        $literal = '';

        if ($this->cancellation_remark == 1)
            $literal = self::CANCEL_GRADE_LITERAL;
        elseif ($this->cancellation_remark == 2)
            $literal = self::CANCEL_STOCK_LITERAL;
        elseif ($this->cancellation_remark == 3)
            $literal = self::CANCEL_PRICE_LITERAL;
        elseif ($this->cancellation_remark == 4)
            $literal = self::CANCEL_DELIVERY_LITERAL;
        elseif ($this->cancellation_remark == 5)
            $literal = self::CANCEL_SUPPORT_LITERAL;

        return $literal;
    }

    public function getTransactionStatus() {
        return ((int) $this->is_replacement === 0) ? self::CURRENT_LITERAL : self::REPLACEMENT_LITERAL;
    }

    public function getTotalQuantityQuoteProduct() {
        $total = 0.00;

        foreach ($this->quotationDetailProducts as $quotationDetailProduct)
            $total += $quotationDetailProduct->quantity_quote;

        return $total;
    }

    public function getTotalQuantityRequestProduct() {
        $total = 0.00;

        foreach ($this->quotationDetailProducts as $quotationDetailProduct)
            $total += $quotationDetailProduct->quantity_request;

        return $total;
    }

    public function getTotalQuantityQuoteService() {
        $total = 0.00;

        foreach ($this->quotationDetailServices as $quotationDetailService)
            $total += $quotationDetailService->quantity_quote;

        return $total;
    }

    public function getTotalQuantityRequestService() {
        $total = 0.00;

        foreach ($this->quotationDetailServices as $quotationDetailService)
            $total += $quotationDetailService->quantity_request;

        return $total;
    }

    public function getTotalDetailProduct() {
        $total = 0.00;

        foreach ($this->quotationDetailProducts as $quotationDetailProduct)
            $total += $quotationDetailProduct->getTotal();

        return $total;
    }

    public function getTotalDetailService() {
        $total = 0.00;

        foreach ($this->quotationDetailServices as $quotationDetailService)
            $total += $quotationDetailService->getTotal();

        return $total;
    }

    public function getGrandTotal() {
        return $this->getTotalDetailProduct() + $this->getTotalDetailService();
    }

    public function getTotalByProduct($productId) {
        $total = 0.00;

        foreach ($this->quotationDetails(array('with' => 'product', 'condition' => 'product.id = :product_id', 'params' => array(':product_id' => $productId))) as $quotationDetail)
            $total += $quotationDetail->total;

        return $total;
    }

    public function getTotalQuantityByProduct($productId) {
        $totalQuantity = 0.00;

        foreach ($this->quotationDetails(array('with' => 'product', 'condition' => 'product.id = :product_id', 'params' => array(':product_id' => $productId))) as $quotationDetail)
            $totalQuantity += $quotationDetail->quantity;

        return $totalQuantity;
    }

    public function getQuotationWeightTotal($quotation, $flag) {
        $total = 0;

        switch ($flag) {
            case 1:
                foreach ($quotation->quotationDetailProducts as $quotationDetailProduct)
                    $total = $total + $quotationDetailProduct->weight;

                break;

            case 2:
                foreach ($quotation->quotationDetailServices as $quotationDetailProduct)
                    $total = $total + $quotationDetailProduct->weight;

                break;
        }

        return $total;
    }

    public function getPackingMethod($quotation) {
        $total = self::getQuotationQuantityTotal($quotation);

        $dus = 0;
        while ($total >= 12) {
            $total -= 12;
            $dus += 1;
        }

        return $dus . ' dus, ' . $total . ' pasang.';
    }

    public function getTotalSaleOrder() {
        $total = 0.00;

        if ($this->is_service == 0) {
            foreach ($this->quotationDetailProducts as $detailProduct) {
                foreach ($detailProduct->saleDetails as $saleDetail)
                    $total += $saleDetail->total;
            }
        } else {
            foreach ($this->quotationDetailServices as $detailService) {
                foreach ($detailService->saleDetails as $saleDetail)
                    $total += $saleDetail->total;
            }
        }

        return $total;
    }

    public function getTotalQuantitySaleOrder() {
        $total = 0.00;

        if ($this->is_service == 0) {
            foreach ($this->quotationDetailProducts as $detailProduct) {
                foreach ($detailProduct->saleDetails as $saleDetail)
                    $total += $saleDetail->quantity;
            }
        } else {
            foreach ($this->quotationDetailServices as $detailService) {
                foreach ($detailService->saleDetails as $saleDetail)
                    $total += $saleDetail->quantity;
            }
        }

        return $total;
    }

    public function getSaleOrderNumber() {
        if ($this->is_service == 0)
            return $this->quotationDetailProducts[0]->saleDetails[0]->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT);
        else
            return $this->quotationDetailServices[0]->saleDetails[0]->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT);
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.time_created', $this->time_created, true);
        $criteria->compare('t.delivery_period', $this->delivery_period);
        $criteria->compare('t.payment_period', $this->payment_period);
        $criteria->compare('t.valid_period', $this->valid_period);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.employee_id_sales', $this->employee_id_sales);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_tax', $this->is_tax);
        $criteria->compare('t.is_logo_printed', $this->is_logo_printed);
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
}
