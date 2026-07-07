<?php

class PurchaseReceiptComponent extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $header = PurchaseReceiptHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($header !== null)
            $this->header->setCodeNumber($header->cn_ordinal, $header->cn_month, $header->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addInvoice($purchaseInvoiceHeaderId) {

        $exist = FALSE;
        $purchaseInvoiceHeader = PurchaseInvoice::model()->findByPk($purchaseInvoiceHeaderId);

        if ($purchaseInvoiceHeader != null) {
            foreach ($this->details as $detail) {
                if ($detail->purchase_invoice_id == $purchaseInvoiceHeader->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new PurchaseReceiptDetail;
                $detail->purchase_invoice_id = $purchaseInvoiceHeaderId;
                $detail->total_invoice = $purchaseInvoiceHeader->grand_total;
//                $detail->total_payment = 0.00;
                $this->details[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Invoice tidak ada di dalam detail TT');
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->purchase_invoice_id === $this->details[$j]->purchase_invoice_id) {
                    $valid = false;
                    $this->header->addError('error', 'Detail tidak boleh sama.');
                    break;
                }
            }
        }

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

    public function validate() {
        $fields = array('date', 'note', 'supplier_id', 'admin_id');
        $valid = $this->header->validate($fields);
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'purchase_invoice_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function flush() {
        $this->header->due_date = date('Y-m-d', strtotime($this->header->date . ' + ' . $this->header->supplier->invoice_due_days . ' days'));
        $this->header->grand_total = $this->getSubTotal();
        
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord)
                $detail->purchase_receipt_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
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

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail) {
//            if ($detail->purchaseInvoice->receive_header_id != null)
                $total += $detail->purchaseInvoice->grand_total;
//            else
//                $total += $detail->purchaseInvoice->receiveItemHeader->subTotal;
        }

        return $total;
    }

}