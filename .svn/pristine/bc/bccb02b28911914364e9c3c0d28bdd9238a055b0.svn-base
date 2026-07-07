<?php

class SaleInvoiceComponent extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $saleInvoice = SaleInvoiceHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($saleInvoice !== null)
            $this->header->setCodeNumber($saleInvoice->cn_ordinal, $saleInvoice->cn_month, $saleInvoice->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetails($workOrderCuttingHeaderId) {
        
        $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByPk($workOrderCuttingHeaderId);

        if ($workOrderCuttingHeader !== null) {
            foreach ($workOrderCuttingHeader->workOrderCuttingDetails as $workOrderCuttingDetail) {
                if ($workOrderCuttingDetail->is_inactive == 0) {
                    $detail = new SaleInvoiceDetail();
                    $detail->work_order_cutting_detail_id = $workOrderCuttingDetail->id;
                    $detail->grade_name = $workOrderCuttingDetail->product_name;
                    $detail->quantity = $workOrderCuttingDetail->quantity;
                    $detail->weight = $workOrderCuttingDetail->weight;
                    $detail->unit_price = $workOrderCuttingDetail->saleDetail->unitPrice;
                    $detail->is_using_weight = empty($workOrderCuttingDetail->saleDetail->quotationDetailProduct) ? $workOrderCuttingDetail->saleDetail->quotationDetailService->is_using_weight : $workOrderCuttingDetail->saleDetail->quotationDetailProduct->is_using_weight;

                    $this->details[] = $detail;
                }
            }
        }
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
        JournalAccounting::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT),
            'transaction_type' => AccountingJournalHelper::SALE_INVOICE,
        ));

        ReceivableLedger::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT),
        ));
        
//        if ((int)$this->header->service_type === 0)
//           $this->header->is_tax_income = 0;
//        else
//           $this->header->is_tax_income = 1;
        
        $this->header->grand_total = $this->grandTotal;
        $this->header->total_payment = 0.00;
        $this->header->date_receipt = empty($this->header->date_receipt) ? null : $_POST['SaleInvoiceHeader']['date_receipt'];

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord)
                $detail->sale_invoice_header_id = $this->header->id;
                
            $valid = $valid && $detail->save(false);
        }

        $accountingJournalDebit = AccountingJournalHelper::make(
            'debit', 
            $this->header->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT), 
            AccountingJournalHelper::SALE_INVOICE, 
            $this->header->customer->account_id_receivable, 
            $this->header->grand_total, 
            $this->header->customer->company,
            $this->header->note, 
            $this->header->date,
            $this->header->admin_id
        );
        $valid = $accountingJournalDebit->save(false) && $valid;

        $accountingJournalCredit = AccountingJournalHelper::make(
            'credit', 
            $this->header->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT),
            AccountingJournalHelper::SALE_INVOICE,
            1005,
            $this->header->grand_total,
            $this->header->customer->company,
            $this->header->note, 
            $this->header->date,
            $this->header->admin_id
        );
        $valid = $accountingJournalCredit->save(false) && $valid;

        $receivableLedger = new ReceivableLedger();
        $receivableLedger->transaction_number = $this->header->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT);
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

//        $this->header->tax_percentage = (int) $this->header->is_tax === 1 ? 11 : 0;
        
        return round($this->getSubTotalBeforeTax() * $this->header->tax_percentage / 100);
    }

    public function getCalculatedTaxIncome() {

        return ((int)$this->header->is_tax_income == 1) ? round($this->getSubTotalBeforeTax() * 2 / 100) : 0.00;
    }

    public function getGrandTotal() {
        
        return $this->getSubTotalBeforeTax() + $this->getCalculatedTax() - $this->getCalculatedTaxIncome();
    }

//    public function getDetailTotal($index) {
//        $detail = $this->details[$index];
//        $header = ($detail->saleInvoiceHeader === null) ? $this->header : $detail->saleInvoiceHeader;
//        $optionMultiplication = ($header->is_using_weight == 0) ? $detail->quantity : $detail->weight;
//        
//        return $optionMultiplication * $detail->unit_price;
//    }
}
