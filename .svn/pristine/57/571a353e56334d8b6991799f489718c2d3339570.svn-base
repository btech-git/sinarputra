<?php

class ProductionPlanningCuttingHeader extends ProductionPlanningCuttingHeaderBase {

    const CN_CONSTANT = 'PPCC';

    public static function model($className = __CLASS__) {
        return parent::model($className);
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

    public function searchForProductionCutting() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.total_quantity_production_remaining > 0 AND t.work_order_cutting_header_id IS NOT NULL AND t.date > '2021-12-31'";

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
        ));
    }

    public function searchForProductionCuttingReplacement() {
        $criteria = new CDbCriteria;

//        $criteria->condition = "EXISTS (
//            SELECT wo.quantity - COALESCE(SUM(qc.quantity), 0) AS quantity_remaining, 
//            wo.id AS production_planning_cutting_detail_id
//            FROM " . ProductionPlanningCuttingDetail::model()->tableName() . " wo
//            LEFT OUTER JOIN " . ProductionCuttingDetail::model()->tableName() . " qc
//            ON wo.id = qc.production_planning_cutting_detail_id
//            WHERE t.id = wo.production_planning_cutting_header_id
//            GROUP BY wo.id
//            HAVING quantity_remaining > 0
//        ) AND t.is_inactive = 0 AND t.work_order_replacement_header_id IS NOT NULL";

        $criteria->condition = "t.total_quantity_production_remaining > 0 AND t.work_order_replacement_header_id IS NOT NULL";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.work_order_replacement_header_id', $this->work_order_replacement_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
