<?php

class PurchasePaymentComponent extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $header = PurchasePaymentHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($header !== null)
            $this->header->setCodeNumber($header->cn_ordinal, $header->cn_month, $header->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetail($id) {
//		$this->details[] = new PurchasePaymentDetail();

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
                $this->details[$i]->amount++;
            else {
                $detail = new PurchasePaymentDetail();
                $detail->account_id = $account->id;
                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

//	public function validateDetailsUnique()
//	{
//		$valid = true;
//		
//		$detailsCount = count($this->details);
//		for ($i = 0; $i < $detailsCount; $i++)
//		{
//			for ($j = $i; $j < $detailsCount; $j++)
//			{
//				if ($i === $j) continue;
//				
//				if ($this->details[$i]->purchase_receipt_header_id === $this->details[$j]->purchase_receipt_header_id)
//				{
//					$valid = false;
//					$this->header->addError('error', 'Detail tidak boleh sama.');
//					break;
//				}
//			}
//		}
//
//		return $valid;
//	}

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        $valid = $this->validateDetailsCount() && $valid;
//		$valid = $this->validateDetailsUnique() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('amount', 'account_id', 'payment_type_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function flush() {
        JournalAccounting::model()->deleteAllByAttributes(array(
            'transaction_number' => $this->header->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT),
            'transaction_type' => AccountingJournalHelper::PURCHASE_PAYMENT,
        ));

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->isNewRecord)
                $detail->purchase_payment_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
            
            if ((int)$detail->is_inactive === 0) {
                $accountingJournalCreditAccount = AccountingJournalHelper::make(
                    'credit', 
                    $this->header->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT), 
                    AccountingJournalHelper::PURCHASE_PAYMENT, 
                    $detail->account_id, 
                    $detail->amount, 
                    'Pembayaran ' . $this->header->purchaseReceiptHeader->supplier->company,
                    $detail->memo, 
                    $this->header->date,
                    $this->header->admin_id
                );
                $valid = $accountingJournalCreditAccount->save(false) && $valid;
            }
        }

        $purchaseReceiptHeader = PurchaseReceiptHeader::model()->findByPk($this->header->purchase_receipt_header_id);
        $purchaseReceiptHeader->payment_total = $purchaseReceiptHeader->getPayment();
        $valid = $purchaseReceiptHeader->update(array('payment_total')) && $valid;

        $accountingJournalDebitTotalAmount = AccountingJournalHelper::make(
            'debit', 
            $this->header->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT),
            AccountingJournalHelper::PURCHASE_PAYMENT,
            $this->header->purchaseReceiptHeader->supplier->account_id_payable, 
            $this->totalPayment,
            'Pelunasan ' . $this->header->purchaseReceiptHeader->supplier->company,
            $this->header->note, 
            $this->header->date,
            $this->header->admin_id
        );
        $valid = $accountingJournalDebitTotalAmount->save(false) && $valid;

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

    public function getTotalPayment() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->amount;

        return $total;
    }
}
