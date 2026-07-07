<?php

/**
 * @property integer $id
 * @property integer $cn_ordinal
 * @property integer $cn_month
 * @property integer $cn_year
 * @property string $date
 * @property string $time
 * @property string $note
 * @property integer $production_planning_miling_header_id
 * @property integer $admin_id
 * @property integer $is_inactive
 * @property string $created_datetime
 * @property integer $admin_id_updated
 * @property string $updated_datetime
 *
 * @property ProductionMilingDetail[] $productionMilingDetails
 * @property ProductionPlanningMilingHeader $productionPlanningMilingHeader
 * @property Admin $admin
 * @property AdminIdUpdated $adminIdUpdated
 * @property QualityControlMilingHeader[] $qualityControlMilingHeaders
 */
class ProductionMilingHeaderBase extends MonthlyTransactionActiveRecord {

    public function tableName() {
        return 'tblsp_production_miling_header';
    }

    public function rules() {
        return array(
            array('cn_ordinal, cn_month, cn_year, date, production_planning_miling_header_id, admin_id', 'required'),
            array('cn_ordinal, cn_month, cn_year, production_planning_miling_header_id, admin_id, is_inactive, admin_id_updated', 'numerical', 'integerOnly' => true),
            array('note, time, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            array('id, cn_ordinal, cn_month, cn_year, date, time, note, production_planning_miling_header_id, admin_id, is_inactive, admin_id_updated, created_datetime, updated_datetime', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'productionMilingDetails' => array(self::HAS_MANY, 'ProductionMilingDetail', 'production_miling_header_id'),
            'productionPlanningMilingHeader' => array(self::BELONGS_TO, 'ProductionPlanningMilingHeader', 'production_planning_miling_header_id'),
            'admin' => array(self::BELONGS_TO, 'Admin', 'admin_id'),
            'adminIdUpdated' => array(self::BELONGS_TO, 'Admin', 'admin_id_updated'),
            'qualityControlMilingHeaders' => array(self::HAS_MANY, 'QualityControlMilingHeader', 'production_miling_header_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cn_ordinal' => 'Cn Ordinal',
            'cn_month' => 'Cn Month',
            'cn_year' => 'Cn Year',
            'date' => 'Date',
            'time' => 'Time',
            'note' => 'Note',
            'production_planning_miling_header_id' => 'Production Planning Miling Header',
            'admin_id' => 'Admin',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.time', $this->time, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.production_planning_miling_header_id', $this->production_planning_miling_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

}
