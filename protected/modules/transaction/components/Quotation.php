<?php

class Quotation extends CComponent {

    public $header;
    public $quotationDetailProducts;
    public $quotationDetailServices;

    public function __construct($header, array $quotationDetailProducts, array $quotationDetailServices) {
        $this->header = $header;
        $this->quotationDetailProducts = $quotationDetailProducts;
        $this->quotationDetailServices = $quotationDetailServices;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $quotationHeader = QuotationHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($quotationHeader !== null)
            $this->header->setCodeNumber($quotationHeader->cn_ordinal, $quotationHeader->cn_month, $quotationHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addQuotationDetailProduct($id) {
        $productSize = ProductSize::model()->findByPk($id);

        if ($productSize !== null) {
            $detail = new QuotationDetailProduct();
            $detail->product_id = $productSize->product_id;
            $detail->height_quote = $productSize->height;
            $detail->width_quote = $productSize->width;
            $this->quotationDetailProducts[] = $detail;
        }
    }

    public function removeQuotationDetailProductAt($index) {
        array_splice($this->quotationDetailProducts, $index, 1);
    }

    public function removeQuotationDetailServiceAt($index) {
        array_splice($this->quotationDetailServices, $index, 1);
    }

    public function validateDetailsCount() {
        $valid = true;
        
        if ((int)$this->header->is_service === 0) {
            if (count($this->quotationDetailProducts) === 0) {
                $valid = false;
                $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
            }
        } else {
            if (count($this->quotationDetailServices) === 0) {
                $valid = false;
                $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
            }
        }

        return $valid;
    }

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->quotationDetailProducts);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->quotationDetailProducts[$i]->product_id === $this->quotationDetailProducts[$j]->product_id) {
                    $valid = false;
                    $this->header->addError('error', 'Produk tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

//    public function validateCreditLimit() {
//        $valid = true;
//
//        if ($this->header->customer !== null) {
//            if ($this->header->customer->remainingCreditLimit <= 0.00) {
//                $valid = false;
//                $this->header->addError('error', 'Customer Credit is over Limit');
//            }
//        }
//        else
//            $valid = false;
//
//        return $valid;
//    }

    public function validate() {
        $valid = $this->header->validate();        
        if (!$valid)
            $this->header->addError('error', 'Header error');

        $valid = $this->validateDetailsCount() && $valid;
        if (!$valid)
            $this->header->addError('error', 'Details Count error');

//        if ($this->header->isNewRecord)
//            $valid = $this->validateCreditLimit() && $valid;

        if ($this->header->is_service == 0) {
            if (count($this->quotationDetailProducts) > 0) {
                foreach ($this->quotationDetailProducts as $detail) {
                    $fields = array(
						'product_name',
                        'length_request',
                        'length_quote',
                        'width_request',
                        'width_quote',
                        'height_request',
                        'height_quote',
                        'weight',
                        'unit_price',
                        'product_category_id');
                    $valid = $detail->validate($fields) && $valid;
                }
            }
            else
                $valid = false;
        } else {
            if (count($this->quotationDetailServices) > 0) {
                foreach ($this->quotationDetailServices as $detail) {
                    $fields = array(
						'product_name',
                        'length_request',
                        'length_quote',
                        'width_request',
                        'width_quote',
                        'height_request',
                        'height_quote',
                        'weight',
                        'unit_price');
                    $valid = $detail->validate($fields) && $valid;
                }
            }
            else
                $valid = false;
        }
        return $valid;
    }

    public function flush() {
        
        $valid = $this->header->save(false);

        //cannot add product AND service. Must choose one
        if ($this->header->is_service == 0) {
            foreach ($this->quotationDetailProducts as $quotationDetailProduct) {
                if ($quotationDetailProduct->isNewRecord)
                    $quotationDetailProduct->quotation_header_id = $this->header->id;
                else {
                    if (!empty($quotationDetailProduct->saleDetails[0]->workOrderCuttingDetails[0])) {
                        $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByAttributes(array('sale_detail_id' => $quotationDetailProduct->saleDetails[0]->id));
                        $workOrderCuttingDetail->product_name = $quotationDetailProduct->product_name_quote;
                        $workOrderCuttingDetail->job_number = $quotationDetailProduct->job_number;
                        $workOrderCuttingDetail->length_request = $quotationDetailProduct->length_request;
                        $workOrderCuttingDetail->width_request = $quotationDetailProduct->width_request;
                        $workOrderCuttingDetail->height_request = $quotationDetailProduct->height_request;
                        $workOrderCuttingDetail->length_quote = $quotationDetailProduct->length_quote;
                        $workOrderCuttingDetail->width_quote = $quotationDetailProduct->width_quote;
                        $workOrderCuttingDetail->height_quote = $quotationDetailProduct->height_quote;
                        $workOrderCuttingDetail->quantity = $quotationDetailProduct->quantity_request;
                        $workOrderCuttingDetail->weight = $quotationDetailProduct->weight;
                        $workOrderCuttingDetail->product_category_id = $quotationDetailProduct->product_category_id;
                        $workOrderCuttingDetail->is_miling = $quotationDetailProduct->is_miling;
                        $workOrderCuttingDetail->is_grinding = $quotationDetailProduct->is_grinding;
                        $workOrderCuttingDetail->is_hardness = $quotationDetailProduct->is_hardness;
                        $workOrderCuttingDetail->is_annelying = $quotationDetailProduct->is_annelying;
                        $workOrderCuttingDetail->is_sidemiling = $quotationDetailProduct->is_sidemiling;
                        $workOrderCuttingDetail->is_inactive = $quotationDetailProduct->is_inactive;
                        $workOrderCuttingDetail->update(array(
                            'product_name', 
                            'job_number', 
                            'length_request', 
                            'width_request', 
                            'height_request', 
                            'length_quote', 
                            'width_quote', 
                            'height_quote', 
                            'quantity',
                            'weight',
                            'product_category_id',
                            'is_miling',
                            'is_grinding',
                            'is_hardness',
                            'is_annelying',
                            'is_sidemiling',
                            'is_inactive',
                        ));
                        
                        if ($quotationDetailProduct->is_miling == 1 || $quotationDetailProduct->is_grinding == 1 || $quotationDetailProduct->is_hardness == 1 || $quotationDetailProduct->is_annelying == 1 || $quotationDetailProduct->is_sidemiling == 1) {
                            $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('id' => $workOrderCuttingDetail->work_order_cutting_header_id));
                            $workOrderCuttingHeader->is_miling_additional = 1;
                            $workOrderCuttingHeader->update(array('is_miling_additional'));
                        }
                    }
                    
                    $saleDetail = SaleDetail::model()->findByAttributes(array('quotation_detail_product_id' => $quotationDetailProduct->id));
                    if (!empty($saleDetail)) {
                        $saleDetail->saleHeader->customer_id = $this->header->customer_id;
                        $saleDetail->saleHeader->update(array('customer_id'));
                    }
                }

                $quotationDetailProduct->weight = $quotationDetailProduct->weightRequest;
                
                $valid = $quotationDetailProduct->save(false) && $valid;
            }
        } else {
            foreach ($this->quotationDetailServices as $quotationDetailService) {
                if ($quotationDetailService->isNewRecord)
                    $quotationDetailService->quotation_header_id = $this->header->id;
                else {
                    if (!empty($quotationDetailService->saleDetails[0]->workOrderCuttingDetails[0])) {
                        $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByAttributes(array('sale_detail_id' => $quotationDetailService->saleDetails[0]->id));
                        $workOrderCuttingDetail->product_name = $quotationDetailService->product_name;
                        $workOrderCuttingDetail->job_number = $quotationDetailService->job_number;
                        $workOrderCuttingDetail->length_request = $quotationDetailService->length_request;
                        $workOrderCuttingDetail->width_request = $quotationDetailService->width_request;
                        $workOrderCuttingDetail->height_request = $quotationDetailService->height_request;
                        $workOrderCuttingDetail->length_quote = $quotationDetailService->length_quote;
                        $workOrderCuttingDetail->width_quote = $quotationDetailService->width_quote;
                        $workOrderCuttingDetail->height_quote = $quotationDetailService->height_quote;
                        $workOrderCuttingDetail->quantity = $quotationDetailService->quantity_request;
                        $workOrderCuttingDetail->weight = $quotationDetailService->weight;
                        $workOrderCuttingDetail->product_category_id = $quotationDetailService->product_category_id;
                        $workOrderCuttingDetail->is_miling = $quotationDetailService->is_miling;
                        $workOrderCuttingDetail->is_grinding = $quotationDetailService->is_grinding;
                        $workOrderCuttingDetail->is_hardness = $quotationDetailService->is_hardness;
                        $workOrderCuttingDetail->is_annelying = $quotationDetailService->is_annelying;
                        $workOrderCuttingDetail->is_sidemiling = $quotationDetailService->is_sidemiling;
                        $workOrderCuttingDetail->is_inactive = $quotationDetailService->is_inactive;
                        $workOrderCuttingDetail->update(array(
                            'product_name', 
                            'job_number', 
                            'length_request', 
                            'width_request', 
                            'height_request', 
                            'length_quote', 
                            'width_quote', 
                            'height_quote', 
                            'quantity',
                            'weight',
                            'product_category_id',
                            'is_miling',
                            'is_grinding',
                            'is_hardness',
                            'is_annelying',
                            'is_sidemiling',
                            'is_inactive',
                        ));
                        
                        if ($quotationDetailService->is_miling == 1 || $quotationDetailService->is_grinding == 1 || $quotationDetailService->is_hardness == 1 || $quotationDetailService->is_annelying == 1 || $quotationDetailService->is_sidemiling == 1) {
                            $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('id' => $workOrderCuttingDetail->work_order_cutting_header_id));
                            $workOrderCuttingHeader->is_miling_additional = 1;
                            $workOrderCuttingHeader->update(array('is_miling_additional'));
                        }
                    }
                    
                    $saleDetail = SaleDetail::model()->findByAttributes(array('quotation_detail_service_id' => $quotationDetailService->id));
                    if (!empty($saleDetail)) {
                        $saleDetail->saleHeader->customer_id = $this->header->customer_id;
                        $saleDetail->saleHeader->update(array('customer_id'));
                    }
                }

                $valid = $quotationDetailService->save(false) && $valid;
            }
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $valid = false;
            $this->header->addError('error', $e->getMessage());
            $dbTransaction->rollback();
        }

        return $valid;
    }

    public function getTotalQuantity($flag) {
        $total = 0.00;

        switch ($flag) {
            case 1:
                foreach ($this->quotationDetailProducts as $quotationDetailProduct)
                    $total += $quotationDetailProduct->quantity_quote;

                break;

            case 2:
                foreach ($this->quotationDetailServices as $quotationDetailService)
                    $total += $quotationDetailService->quantity_quote;

                break;
        }

        return $total;
    }

    public function getTotalDetailProduct() {
        $total = 0.00;

        foreach ($this->quotationDetailProducts as $i => $quotationDetailProduct)
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

//    public function getTotalDetailProduct() {
//        $total = 0.00;
//
//        foreach ($this->quotationDetailProducts as $i => $quotationDetailProduct)
//            $total += $this->getDetailProductTotal($i);
//
//        return $total;
//    }

//    public function getDetailProductTotal($index) {
//        $detail = $this->quotationDetailProducts[$index];
//        $optionMultiplication = ((int)$detail->is_using_weight == 0) ? $detail->quantity_quote : $detail->weight;
//        
//        return $optionMultiplication * $detail->unit_price;
//    }
//    
//    public function getDetailServiceTotal($index) {
//        $detail = $this->quotationDetailServices[$index];
//        $header = ($detail->quotationHeader === null) ? $this->header : $detail->quotationHeader;
//        $optionMultiplication = ($detail->is_using_weight == 0) ? $detail->quantity_quote : $detail->weight;
//        
//        return $optionMultiplication * $detail->unit_price;
//    }
}
