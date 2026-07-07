<?php

class Purchase extends CComponent {

    public $header;
    public $details;
    public $purchaseDetailServices;

    public function __construct($header, array $details, array $purchaseDetailServices) {
        $this->header = $header;
        $this->details = $details;
        $this->purchaseDetailServices = $purchaseDetailServices;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $purchaseHeader = PurchaseHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($purchaseHeader !== null)
            $this->header->setCodeNumber($purchaseHeader->cn_ordinal, $purchaseHeader->cn_month, $purchaseHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetail($id) {
        $productSize = ProductSize::model()->findByPk($id);

        if ($productSize !== null) {
            $detail = new PurchaseDetail();
            $detail->product_id = $productSize->product_id;
            $detail->width = $productSize->width;
            $detail->height = $productSize->height;
            $this->details[] = $detail;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function addService() {
        $this->purchaseDetailServices[] = new PurchaseDetailService();
    }

    public function removeServiceAt($index) {
        array_splice($this->purchaseDetailServices, $index, 1);
    }

    public function addExternalOrder($id) {
        $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByPk($id);

        if ($workOrderCuttingDetail !== null) {
            $exist = false;
            foreach ($this->details as $detail) {
                if ($detail->work_order_cutting_detail_id == $id) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $detail = new PurchaseDetail();
                $detail->work_order_cutting_detail_id = $id;
                $detail->width = $workOrderCuttingDetail->width_quote;
                $detail->height = $workOrderCuttingDetail->height_quote;
                $detail->length = $workOrderCuttingDetail->length_quote;
                $detail->quantity = $workOrderCuttingDetail->quantity;
                $detail->weight = $workOrderCuttingDetail->weight;
                $detail->product_category_id = $workOrderCuttingDetail->product_category_id;
                $detail->product_name = $workOrderCuttingDetail->product_name;
                $this->details[] = $detail;
            }
        }
    }

    public function removeExternalOrderAt($index) {
        array_splice($this->details, $index, 1);
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
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');
        else {
            $valid = $this->validateDetailsCount() && $valid;
            if (!$valid)
                $this->header->addError('error', 'Validate Details Count Error');
            else {
//				$valid = $this->validateDetailsUnique() && $valid;
                if (!$valid)
                    $this->header->addError('error', 'Validate Unique Error');

//				$valid = $this->validateCreditLimit() && $valid;
            }
        }

        if ($this->header->is_service == 0) {
            //validate details
            if (count($this->details) > 0) {
                foreach ($this->details as $detail) {
                    $fields = array('length', 'width', 'height', 'unit_price');
                    $valid = $detail->validate($fields) && $valid;
                }
            }
            else
                $valid = false;
        }
        else {
            //validate services
            if (count($this->purchaseDetailServices) > 0) {
                foreach ($this->purchaseDetailServices as $purchaseDetailService) {
                    $fields = array('name', 'amount');
                    $valid = $valid && $purchaseDetailService->validate($fields);
                }
            }
            else
                $valid = false;
        }
        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;

        if ($this->header->is_service == 0) {
            if (count($this->details) === 0) {
                $valid = false;
                $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
            }
        } else {
            if (count($this->purchaseDetailServices) === 0) {
                $valid = false;
                $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
            }
        }
        return $valid;
    }

    public function flush() {
        //save header
//        $this->header->tax_percentage = ((int) $this->header->is_tax === 0) ? 0 : 10;
        $valid = $this->header->save(false);
        
        if ($this->header->is_service == 0) {
            //save details
            foreach ($this->details as $detail) {

                if ($detail->isNewRecord)
                    $detail->purchase_header_id = $this->header->id;

                $valid = $detail->save(false) && $valid;
            }
        }
        else {
            //save services
            foreach ($this->purchaseDetailServices as $service) {
                if ($service->isNewRecord)
                    $service->purchase_header_id = $this->header->id;

                $valid = $valid && $service->save(false);
            }
        }
        return $valid;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            if ((int) $detail->is_inactive == 0) {
                $total += $detail->total;
            }
        }

        return $total;
    }

    public function getTotalBeforeTax() {
        return $this->getSubTotal() - $this->header->discount;
    }

    public function getTaxPercentage() {
        if ((int)$this->header->is_service === 1)
            $taxPercentage = ((int)$this->header->supplier->is_tax === 1) ? 2 : 0;
        else
            $taxPercentage = ((int)$this->header->supplier->is_tax === 1) ? 10 : 0;
        
        return $taxPercentage;
    }

    public function getCalculatedTax() {
//        return ((int)$this->header->is_tax == 1) ? $this->getTotalBeforeTax() * $this->header->tax_percentage / 100 : 0.00;
        return $this->getTotalBeforeTax() * $this->header->tax_percentage / 100;
    }

    public function getCalculatedTaxIncome() {
        return ((int)$this->header->is_tax_income === 1) ? $this->getTotalBeforeTax() * .003 : 0.00;
    }

    public function getGrandTotal() {
        return $this->getTotalBeforeTax() + $this->getCalculatedTax() + $this->getCalculatedTaxIncome();
    }
}
