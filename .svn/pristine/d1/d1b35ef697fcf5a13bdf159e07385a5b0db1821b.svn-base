<?php

class QualityControlCuttingHeader extends QualityControlCuttingHeaderBase {

    const CN_CONSTANT = 'QCC';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalQuantity() {
        $total = 0;

        foreach ($this->qualityControlCuttingDetails as $detail) {
            $total += $detail->quantity;
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
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
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

    public function searchForWorkOrderReplacement() {
        $dataProvider = $this->search();

        $dataProvider->criteria->addCondition("
            t.id NOT IN (
                SELECT h.quality_control_cutting_header_id
                FROM " . WorkOrderReplacementHeader::model()->tableName() . " h
                WHERE h.is_inactive = 0 AND t.id = h.quality_control_cutting_header_id
            ) AND EXISTS (
                SELECT d.control_result
                FROM " . QualityControlCuttingDetail::model()->tableName() . " d
                WHERE t.id = d.quality_control_cutting_header_id AND d.control_result = 'NG'
            ) AND t.is_inactive = 0 AND t.date > '2021-12-31'
        ");

        return $dataProvider;
    }

    public function searchForDelivery() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.date > '2022-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.production_cutting_header_id', $this->production_cutting_header_id);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.is_delivered', 0);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            )
        ));
    }
}
