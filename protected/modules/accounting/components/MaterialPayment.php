<?php

class MaterialPayment extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $materialPaymentHeader = MaterialPaymentHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($materialPaymentHeader !== null) {
            $this->header->setCodeNumber($materialPaymentHeader->cn_ordinal, $materialPaymentHeader->cn_month, $materialPaymentHeader->cn_year);
        }

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addInvoice($materialInvoiceHeaderId) {

        $exist = FALSE;
        $materialInvoiceHeader = MaterialInvoiceHeader::model()->findByPk($materialInvoiceHeaderId);

        if ($materialInvoiceHeader != null) {
            foreach ($this->details as $detail) {
                if ($detail->material_invoice_header_id == $materialInvoiceHeader->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new MaterialPaymentDetail;
                $detail->material_invoice_header_id = $materialInvoiceHeaderId;
                $detail->income_tax = ((int)$materialInvoiceHeader->is_tax_income == 1) ? 2 : 0;
                $this->details[] = $detail;
            }
        } else {
            $this->header->addError('error', 'Invoice tidak ada di dalam detail');
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function resetDetail() {
        $this->details = array();
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

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail)
                $valid = $valid && $detail->delete();

            $valid = $valid && $this->header->delete();

            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'amount', 'income_tax');
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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->material_invoice_header_id === $this->details[$j]->material_invoice_header_id) {
                    $valid = false;
                    $this->header->addError('error', 'Invoice tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        ReceivableLedger::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(MaterialPaymentHeader::CN_CONSTANT),
        ));
        
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->amount <= 0.00) {
                continue;
            }

            if ($detail->isNewRecord) {
                $detail->material_payment_header_id = $this->header->id;
            }

            $valid = $detail->save(false) && $valid;

            $materialInvoiceHeader = MaterialInvoiceHeader::model()->findByPk($detail->material_invoice_header_id);
            if ((int)$detail->is_inactive === 0) {
                $materialInvoiceHeader->total_payment = $materialInvoiceHeader->getPayment();
                $materialInvoiceHeader->remaining_payment = $materialInvoiceHeader->getRemainingPayment();
                $valid = $materialInvoiceHeader->update(array('total_payment', 'remaining_payment')) && $valid;
            }
            
            $receivableLedger = new ReceivableLedger();
            $receivableLedger->transaction_number = $this->header->getCodeNumber(MaterialPaymentHeader::CN_CONSTANT);
            $receivableLedger->transaction_date = $this->header->date_payment; 
            $receivableLedger->note = $detail->materialInvoiceHeader->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT);
            $receivableLedger->memo = $detail->memo;
            $receivableLedger->debit = '0.00';
            $receivableLedger->credit = $detail->amount + $detail->additional_payment_1 + $detail->additional_payment_2;
            $receivableLedger->customer_id = $this->header->customer_id;
            $receivableLedger->admin_id = $this->header->admin_id;
            $receivableLedger->posting_datetime = date('Y-m-d H:i:s');
            $valid = $receivableLedger->save(false) && $valid;
        }

        return $valid;
    }

    public function getTotalReceivable() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->materialInvoiceHeader->remaining_payment;
        }

        return $total;
    }

    public function getTotalPayment() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->amount;
        }

        return $total;
    }
    
    public function getTotalAdditionalPayment1() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->additional_payment_1;
        }

        return $total;
    }

    public function getTotalAdditionalPayment2() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->additional_payment_2;
        }

        return $total;
    }

    public function getRemaining() {
        return $this->totalReceivable - $this->totalPayment - $this->totalAdditionalPayment1 - $this->totalAdditionalPayment2;
    }
}
