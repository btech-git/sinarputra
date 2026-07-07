<?php

class ManualSaleInvoice extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $saleInvoice = ManualSaleInvoiceHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($saleInvoice !== null)
            $this->header->setCodeNumber($saleInvoice->cn_ordinal, $saleInvoice->cn_month, $saleInvoice->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDelivery($deliveryDetailId) {

        $exist = FALSE;
        $deliveryDetail = DeliveryDetail::model()->findByPk($deliveryDetailId);

        if ($deliveryDetail != null) {
            foreach ($this->details as $detail) {
                if ($detail->delivery_detail_id == $deliveryDetail->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new ManualSaleInvoiceDetail;
                $detail->delivery_detail_id = $deliveryDetailId;
                $detail->grade_name = $deliveryDetail->grade_name;
                $detail->quantity = $deliveryDetail->quantity;
                $detail->weight = $deliveryDetail->weight;
                $detail->unit_price = $deliveryDetail->workOrderCuttingDetail->saleDetail->unitPrice;
                $detail->is_using_weight = empty($deliveryDetail->workOrderCuttingDetail->saleDetail->quotationDetailProduct) ? $deliveryDetail->workOrderCuttingDetail->saleDetail->quotationDetailService->is_using_weight : $deliveryDetail->workOrderCuttingDetail->saleDetail->quotationDetailProduct->is_using_weight;
                $this->details[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Invoice tidak ada di dalam detail');
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function resetDetail() {
        $this->details = array();
    }

    public function validate() {
        $valid = $this->header->validate();
        $valid = $this->validateDetailsCount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('length', 'width', 'height', 'weight');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
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
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function flush() {
        
        ReceivableLedger::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT),
        ));
        
        $saleHeader = SaleHeader::model()->findByPk($this->details[0]->deliveryDetail->workOrderCuttingDetail->workOrderCuttingHeader->sale_header_id);
        $this->header->purchase_order_number = $saleHeader->customer_order_number;
        $this->header->grand_total = $this->grandTotal;
        $this->header->total_payment = 0.00;
        $this->header->work_order_cutting_header_id = null;
        $this->header->date_receipt = empty($this->header->date_receipt) ? null : $_POST['ManualSaleInvoiceHeader']['date_receipt'];

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $detail->manual_sale_invoice_header_id = $this->header->id;
            }
                
            $valid = $valid && $detail->save(false);
        }

        $receivableLedger = new ReceivableLedger();
        $receivableLedger->transaction_number = $this->header->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT);
        $receivableLedger->transaction_date = $this->header->date; 
        $receivableLedger->note = $this->header->note;
        $receivableLedger->memo = $this->header->tax_number;
        $receivableLedger->debit = $this->header->grand_total;
        $receivableLedger->credit = '0.00';
        $receivableLedger->customer_id = $this->header->customer_id;
        $receivableLedger->admin_id = $this->header->admin_id;
        $receivableLedger->posting_datetime = date('Y-m-d H:i:s');
        $valid = $receivableLedger->save(false) && $valid;

        return $valid;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->getTotal();

        return $total;
    }

    public function getSubTotalBeforeTax() {
        
        return $this->getSubTotal() - $this->header->discount + $this->header->rounding_nominal;
    }

    public function getCalculatedTax() {

        return round($this->getSubTotalBeforeTax() * $this->header->tax_percentage / 100);
    }

    public function getCalculatedTaxIncome() {

        return ((int)$this->header->is_tax_income == 1) ? round($this->getSubTotalBeforeTax() * 2 / 100) : 0.00;
    }

    public function getGrandTotal() {
        
        return $this->getSubTotalBeforeTax() + $this->getCalculatedTax() - $this->getCalculatedTaxIncome();
    }
}
