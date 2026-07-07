<?php

class Sale extends CComponent {

    public $header;
    public $saleDetails;

    public function __construct($header, array $saleDetails) {
        $this->header = $header;
        $this->saleDetails = $saleDetails;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $saleHeader = SaleHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($saleHeader !== null)
            $this->header->setCodeNumber($saleHeader->cn_ordinal, $saleHeader->cn_month, $saleHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addProduct($quotationDetailProductId) {

        $exist = FALSE;
        $quotationDetailProduct = QuotationDetailProduct::model()->findByPk($quotationDetailProductId);

        if ($quotationDetailProduct != null) {
            foreach ($this->saleDetails as $detailProduct) {
                if ($detailProduct->quotation_detail_product_id == $quotationDetailProduct->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new SaleDetail;
                $detail->quotation_detail_product_id = $quotationDetailProduct->id;
                $detail->quotation_detail_service_id = null;
                $this->saleDetails[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Quotation detail product tidak ada di sale detail product');
    }

    public function addService($quotationDetailServiceId) {
        $exist = FALSE;
        $quotationDetailService = QuotationDetailService::model()->findByPk($quotationDetailServiceId);

        if ($quotationDetailService != null) {
            foreach ($this->saleDetails as $detailService) {
                if ($detailService->quotation_detail_service_id == $quotationDetailService->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new SaleDetail;
                $detail->quotation_detail_service_id = $quotationDetailService->id;
                $detail->quotation_detail_product_id = null;
                $this->saleDetails[] = $detail;
            }
        } else {
            $this->header->addError('error', 'Quotation detail service tidak ada di sale detail service');
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->saleDetails, $index, 1);
    }

    public function resetDetails() {
        $this->saleDetails = array();
    }

    public function validateDetailsCount() {
        $valid = true;
        
        if (count($this->saleDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail product untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid) {
            $this->header->addError('error', 'Header error');
        }

        $valid = $valid && $this->validateDetailsCount();
        if (!$valid) {
            $this->header->addError('error', 'Details Count error');
        }

        if ($this->header->isNewRecord) {
            $valid = $this->validateCreditLimit() && $valid;
        }

        foreach ($this->saleDetails as $detail) {
            $fields = array('quotation_detail_product_id, quotation_detail_service_id');
            $valid = $valid && $detail->validate($fields);
        }

        return $valid;
    }

    public function validateCreditLimit() {
        $valid = true;

        if ($this->header->customer !== null) {
            if ($this->totalCreditRemaining <= 0.00) {
                $valid = false;
                $this->header->addError('error', 'Customer Credit is over Limit');
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function flush() {
//        $this->header->note = empty($this->saleDetails[0]->quotationDetailProduct) ? $this->saleDetails[0]->quotationDetailService->quotationHeader->note : $this->saleDetails[0]->quotationDetailProduct->quotationHeader->note;
        $valid = $this->header->save(false);

        foreach ($this->saleDetails as $saleDetail) {
            if ($saleDetail->isNewRecord) {
                $saleDetail->sale_header_id = $this->header->id;
            }
            
            $valid = $valid && $saleDetail->save(false);
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $valid = false;
            $this->header->addError('error', $e->getMessage());
            $dbTransaction->rollback();
        }

        return $valid;
    }

    public function getTotalQuantityRequest() {
        $total = 0.00;

        foreach ($this->saleDetails as $saleDetail) {
            $detailProductService = ($saleDetail->quotation_detail_product_id === null) ? $saleDetail->quotationDetailService : $saleDetail->quotationDetailProduct;
            $total += CHtml::value($detailProductService, 'quantity_request');
        }

        return $total;
    }

    public function getTotalQuantityQuote() {
        $total = 0.00;

        foreach ($this->saleDetails as $saleDetail){
            $detailProductService = ($saleDetail->quotation_detail_product_id === null) ? $saleDetail->quotationDetailService : $saleDetail->quotationDetailProduct;
            $total += CHtml::value($detailProductService, 'quantity_quote');
        }

        return $total;
    }

    public function getGrandTotal() {
        $total = 0.00;

        foreach ($this->saleDetails as $saleDetail) {
            $total += $saleDetail->getTotal();
        }

        return $total;
    }
    
    public function getTotalCreditRemaining() {
        
        return $this->header->customer->remainingCreditLimit - $this->grandTotal;
    }
}
