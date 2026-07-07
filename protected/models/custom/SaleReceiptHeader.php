<?php

class SaleReceiptHeader extends SaleReceiptHeaderBase {
    const CN_CONSTANT = 'SRCP';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalReceipt() {
        $total = 0.00;

        foreach ($this->saleReceiptDetails as $detail)
            $total += CHtml::value($detail, 'total_invoice');

        return $total;
    }

    public function getRemaining() {
        return $this->grand_total - $this->payment_total;
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.due_date', $this->due_date, true);
        $criteria->compare('t.grand_total', $this->grand_total, true);
        $criteria->compare('t.payment_total', $this->payment_total, true);
        $criteria->compare('t.return_total', $this->return_total, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_id', $this->customer_id);
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