<?php

class ProductionPlanningMilingHeader extends ProductionPlanningMilingHeaderBase {

    const CN_CONSTANT = 'PPCM';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchForProductionMiling() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.total_quantity_production_remaining > 0 AND t.work_order_cutting_header_id IS NOT NULL AND t.date > '2021-12-31'";

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
