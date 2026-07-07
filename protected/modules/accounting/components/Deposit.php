<?php

class Deposit extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $depositHeader = DepositHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($depositHeader !== null)
            $this->header->setCodeNumber($depositHeader->cn_ordinal, $depositHeader->cn_month, $depositHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetail($accountId) {
        $account = Account::model()->findByPk($accountId);
        if ($account != NULL) {
            $exist = FALSE;
            foreach ($this->details as $detail) {
                if ($detail->account_id === $accountId) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new DepositDetail();
                $detail->account_id = $accountId;
                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
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
            $this->header->addError('error', 'Exception Error');
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        $valid = $valid && $this->validateDetailsCount();
        if (!$valid)
            $this->header->addError('error', 'Details Count Error');

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('amount', 'memo', 'account_id');
                $valid = $valid && $detail->validate($fields);
                if (!$valid)
                    $this->header->addError('error', 'Details Error');
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

    public function flush() {
        JournalAccounting::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(DepositHeader::CN_CONSTANT),
            'transaction_type' => AccountingJournalHelper::DEPOSIT,
        ));

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->amount <= 0)
                continue;

            if ($detail->isNewRecord) {
                $detail->deposit_header_id = $this->header->id;
                $valid = $valid && $detail->save(false);
            } else {
                if ($detail->is_inactive == 1) {
                    $detail->delete();
                    continue;
                }
                else
                    $valid = $valid && $detail->save(false);
            }
            
            if ((int)$detail->is_inactive === 0) {
                $accountingJournalCredit = AccountingJournalHelper::make(
                    'credit', 
                    $this->header->getCodeNumber(DepositHeader::CN_CONSTANT), 
                    AccountingJournalHelper::DEPOSIT, 
                    $detail->account_id, 
                    $detail->amount, 
                    $this->header->account->name,
                    $detail->memo, 
                    $this->header->date,
                    $this->header->admin_id
                );
                $valid = $accountingJournalCredit->save(false) && $valid;
            }
        }

        $accountingJournalDebit = AccountingJournalHelper::make(
            'debit', 
            $this->header->getCodeNumber(DepositHeader::CN_CONSTANT),
            AccountingJournalHelper::DEPOSIT,
            $this->header->account_id, 
            $this->grandTotal,
            'Penerimaan',
            $this->header->note, 
            $this->header->date,
            $this->header->admin_id
        );
        $valid = $accountingJournalDebit->save(false) && $valid;

        return $valid;
    }

    public function getGrandTotal() {
        $total = 0.00;
        foreach ($this->details as $detail)
            $total += $detail->amount;

        return $total;
    }

}

