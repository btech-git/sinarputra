<?php

class ProductionMiling extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $header = ProductionMilingHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($header !== null)
            $this->header->setCodeNumber($header->cn_ordinal, $header->cn_month, $header->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addDetails($productionPlanningId) {
        $sql = "SELECT wo.id AS production_planning_miling_detail_id, wo.quantity - COALESCE(SUM(pc.quantity), 0) AS quantity_remaining, 
                wo.length_request, wo.width_request, wo.height_request, wo.length_quote, wo.width_quote, wo.height_quote, wo.weight, 
                wo.job_group_facemil AS job_group_facemil,
                wo.job_group_sidemil AS job_group_sidemil,
                wo.job_group_grinding AS job_group_grinding, 
                wo.planning_date_facemil AS planning_date_facemil, 
                wo.planning_date_sidemil AS planning_date_sidemil,
                wo.planning_date_grinding AS planning_date_grinding,
                wo.machine_id_facemil AS machine_id_facemil,
                wo.machine_id_sidemil AS machine_id_sidemil,
                wo.machine_id_grinding AS machine_id_grinding
                FROM " . ProductionPlanningMilingDetail::model()->tableName() . " wo
                LEFT OUTER JOIN " . ProductionMilingDetail::model()->tableName() . " pc
                ON wo.id = pc.production_planning_miling_detail_id 
                WHERE wo.production_planning_miling_header_id = :production_planning_miling_header_id AND wo.is_inactive = 0
                GROUP BY wo.id
                HAVING quantity_remaining > 0
                ORDER BY wo.id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':production_planning_miling_header_id' => $productionPlanningId));

        $this->details = array();

        foreach ($resultSet as $row) {
            $detail = new ProductionMilingDetail();

            $detail->production_planning_miling_detail_id = $row['production_planning_miling_detail_id'];
            $detail->length_request = $row['length_request'];
            $detail->width_request = $row['width_request'];
            $detail->height_request = $row['height_request'];
            $detail->length_quote = $row['length_quote'];
            $detail->width_quote = $row['width_quote'];
            $detail->height_quote = $row['height_quote'];
            $detail->weight = $row['weight'];
            $detail->job_group_facemil = $row['job_group_facemil'];
            $detail->job_group_sidemil = $row['job_group_sidemil'];
            $detail->job_group_grinding = $row['job_group_grinding'];
            $detail->production_date_facemil = $row['planning_date_facemil'];
            $detail->production_date_sidemil = $row['planning_date_sidemil'];
            $detail->production_date_grinding = $row['planning_date_grinding'];
            $detail->machine_id_facemil = $row['machine_id_facemil'];
            $detail->machine_id_sidemil = $row['machine_id_sidemil'];
            $detail->machine_id_grinding = $row['machine_id_grinding'];
            $detail->productionPlanningQuantity = $row['quantity_remaining'];
            $this->details[] = $detail;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validateDetailsCount() {
        $valid = true;

        if (count($this->details) === 0)
            $valid = false;

        return $valid;
    }

    public function validateDetailsUnique() {
        $valid = true;

        $count = count($this->details);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i; $j < $count; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->production_planning_miling_detail_id
                        === $this->details[$j]->production_planning_miling_detail_id) {
                    $valid = false;
                    $this->header->addError('error', 'Detail tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        $valid = $this->validateDetailsCount() && $valid;
        if (!$valid)
            $this->header->addError('error', 'Validate Details Count Error');

        $valid = $this->validateDetailsUnique() && $valid;
        if (!$valid)
            $this->header->addError('error', 'Validate Details Unique Error');

        foreach ($this->details as $detail) {
            $fields = array(
                'length',
                'height',
                'quantity',
                'weight'
            );
            $valid = $detail->validate($fields) && $valid;
            
            if (!$valid)
                break;
        }

        return $valid;
    }

    public function flush() {

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;
            
            $detail->production_miling_header_id = $this->header->id;
            $detail->production_date_facemil = $this->header->date;
            $detail->production_date_sidemil = $this->header->date;
            $detail->production_date_grinding = $this->header->date;
            
            $valid = $detail->save(false) && $valid;
        }

        $valid = $this->syncProductionPlanningMilingHeader(true) && $valid;
        
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
    
    public function syncProductionPlanningMilingHeader($isSaved) {
        $detailIds = array();
        foreach ($this->details as $detail) {
            $detailIds[] = $detail->id;
        }
        
        $productionPlanningMilingHeader = $this->header->productionPlanningMilingHeader;
        $totalQuantityRemaining = 0;
        foreach ($productionPlanningMilingHeader->productionPlanningMilingDetails as $productionPlanningMilingDetail) {
            $totalQuantityRemaining += $productionPlanningMilingDetail->quantity;
            
            foreach ($productionPlanningMilingDetail->productionMilingDetails as $productionMilingDetail) {
                if (!in_array($productionMilingDetail->id, $detailIds)) {
                    $totalQuantityRemaining -= $productionMilingDetail->quantity;
                }
            }
        }
        if ($isSaved) {
            foreach ($this->details as $detail) {
                $totalQuantityRemaining -= $detail->quantity;
            }
        }
        $productionPlanningMilingHeader->total_quantity_production_remaining = $totalQuantityRemaining;
        $valid = $productionPlanningMilingHeader->update(array('total_quantity_production_remaining'));
        
        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;
            if ($this->header->productionPlanningMilingDetails != NULL) {
                foreach ($this->header->productionPlanningMilingDetails as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $valid = $valid && $detail->update(array('is_inactive'));
                }
            }

            $this->header->is_inactive = ActiveRecord::INACTIVE;
            $valid = $valid && $this->header->update(array('is_inactive'));
        
            $valid = $this->syncProductionPlanningMilingHeader(false) && $valid;

            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollBack();
        } catch (Exception $e) {
            $dbTransaction->rollback();
        }

        return $valid;
    }
}
