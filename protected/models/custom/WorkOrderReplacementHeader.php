<?php

class WorkOrderReplacementHeader extends WorkOrderReplacementHeaderBase {

    const CN_CONSTANT = 'SPK-R';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchForProductionPlanningReplacement() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.id NOT IN (
            SELECT work_order_replacement_header_id
            FROM " . ProductionPlanningCuttingHeader::model()->tableName() . "
            WHERE work_order_replacement_header_id IS NOT NULL
        )
        AND t.is_inactive = 0 AND t.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.quality_control_cutting_header_id', $this->quality_control_cutting_header_id);
        $criteria->compare('t.quality_control_miling_header_id', $this->quality_control_miling_header_id);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchForProductionPlanningMiling() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.id NOT IN (
            SELECT work_order_cutting_header_id
            FROM " . ProductionPlanningMilingHeader::model()->tableName() . "   
            WHERE work_order_replacement_header_id IS NOT NULL
        ) AND EXISTS (
            SELECT d.is_miling, d.is_grinding, d.is_hardness, d.is_annelying, d.is_sidemiling
            FROM " . WorkOrderReplacementDetail::model()->tableName() . " d
            WHERE t.id = d.work_order_replacement_header_id
            HAVING d.is_miling = 1 OR d.is_grinding = 1 OR d.is_hardness = 1 OR d.is_annelying = 1 OR d.is_sidemiling = 1
        )
        AND t.is_inactive = 0 AND t.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.quality_control_cutting_header_id', $this->quality_control_cutting_header_id);
        $criteria->compare('t.quality_control_miling_header_id', $this->quality_control_miling_header_id);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
