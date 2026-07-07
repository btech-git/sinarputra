<?php

class SaleReceiptComponent extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $saleReceiptHeader = SaleReceiptHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($saleReceiptHeader !== null)
            $this->header->setCodeNumber($saleReceiptHeader->cn_ordinal, $saleReceiptHeader->cn_month, $saleReceiptHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addInvoice($saleInvoiceHeaderId) {

        $exist = FALSE;
        $saleInvoiceHeader = SaleInvoiceHeader::model()->findByPk($saleInvoiceHeaderId);

        if ($saleInvoiceHeader != null) {
            foreach ($this->details as $detail) {
                if ($detail->sale_invoice_header_id == $saleInvoiceHeader->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new SaleReceiptDetail;
                $detail->sale_invoice_header_id = $saleInvoiceHeaderId;
                $detail->total_invoice = $saleInvoiceHeader->grandTotal;
                $this->details[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Invoice tidak ada di dalam detail TT');
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

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'sale_invoice_header_id');
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

                if ($this->details[$i]->sale_invoice_header_id === $this->details[$j]->sale_invoice_header_id) {
                    $valid = false;
                    $this->header->addError('error', 'Tanda Terima tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        $this->header->due_date = date('Y-m-d', strtotime($this->header->date_receipt . ' +' . $this->header->customer->invoice_due_days . ' days'));
        $this->header->grand_total = $this->getTotalReceipt();
        $this->header->date_receipt = empty($this->header->date_receipt) ? null : $_POST['SaleReceiptHeader']['date_receipt'];
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord)
                $detail->sale_receipt_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function getTotalReceipt() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += CHtml::value($detail, 'saleInvoiceHeader.grandTotal');

        return $total;
    }

}
