<?php

class ManualSalePaymentHeader extends ManualSalePaymentHeaderBase {
    const CN_CONSTANT = 'MSP';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalReceivable() {
        $total = 0.00;

        foreach ($this->manualSalePaymentDetails as $detail) {
            $total += $detail->manualSaleInvoiceHeader->remaining;
        }

        return $total;
    }

    public function getTotalPayment() {
        $total = 0.00;

        foreach ($this->manualSalePaymentDetails as $detail) {
            $total += $detail->amount;
        }

        return $total;
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.admin_id', $this->admin_id);
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

}