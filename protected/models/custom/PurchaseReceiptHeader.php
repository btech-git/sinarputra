<?php

class PurchaseReceiptHeader extends PurchaseReceiptHeaderBase {
    const CN_CONSTANT = 'PRCP';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchForPurchasePayment() {
        $criteria = new CDbCriteria;

        $criteria->condition = " (grand_total - return_total - payment_total) > 0 AND t.is_inactive = 0 AND t.date > '2021-12-31'";
        
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.payment_total', $this->payment_total, true);
        $criteria->compare('t.return_total', $this->return_total, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.payment_total', $this->payment_total, true);
        $criteria->compare('t.return_total', $this->return_total, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->purchaseReceiptDetails as $detail) {
//            if ($detail->purchaseInvoice->receive_header_id != null)
                $total += $detail->purchaseInvoice->grand_total;
//            else
//                $total += $detail->purchaseInvoice->receiveItemHeader->subTotal;
        }

        return $total;
    }

    public function getRemaining() {
        return $this->grand_total - $this->payment_total;
    }

    public function getPayment() {
        if ($this->purchasePaymentHeaders == null)
            return 0.00;
        else {
            $total = 0.00;

            foreach ($this->purchasePaymentHeaders as $detail)
                $total += $detail->totalAmount;

            return $total;
        }
    }
}