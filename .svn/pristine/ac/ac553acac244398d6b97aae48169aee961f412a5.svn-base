<?php

class JournalVoucher extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $journalVoucherHeader = JournalVoucherHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($journalVoucherHeader !== null)
            $this->header->setCodeNumber($journalVoucherHeader->cn_ordinal, $journalVoucherHeader->cn_month, $journalVoucherHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetail($id) {
        $account = Account::model()->findByPk($id);

        if ($account !== null) {
            $exist = false;
            foreach ($this->details as $i => $detail) {
                if ($account->id === $detail->account_id) {
                    $exist = true;
                    break;
                }
            }

            if ($exist)
                $this->details[$i]->debit++;
            else {
                $detail = new JournalVoucherDetail();
                $detail->account_id = $account->id;
                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $valid && $this->validateDetailsCount();
        $valid = $valid && $this->validateDetailsUnique();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('debit', 'credit', 'account_id');
                $valid = $valid && $detail->validate($fields);
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

                if ($this->details[$i]->account_id === $this->details[$j]->account_id) {
                    $valid = false;
                    $this->header->addError('error', 'Nama Akun tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        JournalAccounting::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT),
            'transaction_type' => AccountingJournalHelper::ADJUSTMENT,
        ));

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord)
                $detail->journal_voucher_header_id = $this->header->id;

            $valid = $valid && $detail->save(false);

            $journalAccounting = new JournalAccounting();
            $journalAccounting->transaction_number = $this->header->getCodeNumber(JournalVoucherHeader::CN_CONSTANT);
            $journalAccounting->date = $this->header->date;
            $journalAccounting->transaction_type = AccountingJournalHelper::ADJUSTMENT;
            $journalAccounting->transaction_subject = $detail->memo;
            $journalAccounting->note = $this->header->note;
            $journalAccounting->debit = $detail->debit;
            $journalAccounting->credit = $detail->credit;
            $journalAccounting->account_id = $detail->account_id;
            $journalAccounting->admin_id = $this->header->admin_id;

            $valid = $valid && $journalAccounting->save(false);
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
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function getTotalDebit() {
        $total = 0.00;
        foreach ($this->details as $detail)
            $total += $detail->debit;

        return $total;
    }

    public function getTotalCredit() {
        $total = 0.00;
        foreach ($this->details as $detail)
            $total += $detail->credit;

        return $total;
    }

}
