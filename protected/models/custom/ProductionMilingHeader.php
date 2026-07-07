<?php

class ProductionMilingHeader extends ProductionMilingHeaderBase {

    const CN_CONSTANT = 'PRDM';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchForQualityControl() {
        $criteria = new CDbCriteria;

        $criteria->addCondition("EXISTS (
            SELECT production_miling_header_id 
            FROM " . ProductionMilingDetail::model()->tableName() . " 
            WHERE t.id = production_miling_header_id AND quantity - quantity_quality_control > 0
        ) AND t.date > '2023-12-31'");

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.production_planning_miling_header_id', $this->production_planning_miling_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
