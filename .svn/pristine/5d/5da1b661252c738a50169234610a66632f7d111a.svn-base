<?php

class ProductionPlanningCutting extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $header = ProductionPlanningCuttingHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($header !== null)
            $this->header->setCodeNumber($header->cn_ordinal, $header->cn_month, $header->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addCuttingDetails($workOrderCuttingId) {

        $sql = "SELECT w.quantity - COALESCE(SUM(p.quantity), 0) AS quantity_remaining, w.id AS work_order_cutting_detail_id
                FROM " . WorkOrderCuttingDetail::model()->tableName() . " w
                LEFT OUTER JOIN " . ProductionPlanningCuttingDetail::model()->tableName() . " p ON w.id = p.work_order_cutting_detail_id AND p.is_inactive = 0
                WHERE w.work_order_cutting_header_id = :work_order_cutting_header_id AND w.is_inactive = 0 
                GROUP BY w.id
                HAVING quantity_remaining > 0
                ORDER BY w.id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':work_order_cutting_header_id' => $workOrderCuttingId));
        $this->details = array(); //reset detail

        foreach ($resultSet as $row) {
            $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByPk($row['work_order_cutting_detail_id']);
            
            $detail = new ProductionPlanningCuttingDetail();
            $detail->work_order_cutting_detail_id = $workOrderCuttingDetail->id;
            $detail->work_order_replacement_detail_id = null;
            $detail->length = $workOrderCuttingDetail->length_quote;
            $detail->width = $workOrderCuttingDetail->width_quote;
            $detail->height = $workOrderCuttingDetail->height_quote;
            $detail->quantity = $workOrderCuttingDetail->quantity;
            $detail->weight = $workOrderCuttingDetail->weight;
            $this->details[] = $detail;
        }
    }

    public function addReplacementDetails($workOrderReplacementId) {

        $this->details = array();
        $workOrderReplacementHeader = WorkOrderReplacementHeader::model()->findByPk($workOrderReplacementId);

        if ($workOrderReplacementHeader !== null) {
            foreach ($workOrderReplacementHeader->workOrderReplacementDetails as $workOrderReplacementDetail) {
                $detail = new ProductionPlanningCuttingDetail();

                $detail->work_order_cutting_detail_id = null;
                $detail->work_order_replacement_detail_id = $workOrderReplacementDetail->id;
                $detail->length = $workOrderReplacementDetail->length_quote;
                $detail->width = $workOrderReplacementDetail->width_quote;
                $detail->height = $workOrderReplacementDetail->height_quote;
                $detail->quantity = $workOrderReplacementDetail->quantity;
                $detail->weight = $workOrderReplacementDetail->weight;
                $this->details[] = $detail;
            }
        }
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

                if ($this->details[$i]->work_order_cutting_detail_product_id
                        === $this->details[$j]->work_order_cutting_detail_product_id) {
                    $valid = false;
                    $this->header->addError('error', 'Detail product tidak boleh sama.');
                    break;
                }
            }
        }

//        $count = count($this->detailServices);
//        for ($i = 0; $i < $count; $i++) {
//            for ($j = $i; $j < $count; $j++) {
//                if ($i === $j)
//                    continue;
//
//                if ($this->detailServices[$i]->work_order_cutting_detail_service_id
//                        === $this->detailServices[$j]->work_order_cutting_detail_service_id) {
//                    $valid = false;
//                    $this->header->addError('error', 'Detail service tidak boleh sama.');
//                    break;
//                }
//            }
//        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

//        $valid = $this->validateDetailsCount() && $valid;
//        if (!$valid)
//            $this->header->addError('error', 'Validate Details Count Error');

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
        $workOrder = empty($this->header->workOrderCuttingHeader) ? $this->header->workOrderReplacementHeader : $this->header->workOrderCuttingHeader;
        $this->header->cn_ordinal = $workOrder->cn_ordinal;
        $this->header->cn_month = $workOrder->cn_month;
        $this->header->cn_year = $workOrder->cn_year;

        $totalQuantityRemaining = 0;
        foreach ($this->details as $index => $detail) {
            $totalQuantityRemaining += $detail->quantity;
        }
        $this->header->total_quantity_production_remaining = $totalQuantityRemaining;
                
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            $detail->production_planning_cutting_header_id = $this->header->id; 
            
            $valid = $detail->save(false) && $valid;
        }
        
        $valid = $this->syncWorkOrderCuttingHeader(true) && $valid;
        
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
    
    public function syncWorkOrderCuttingHeader($isSaved) {
        $detailIds = array();
        foreach ($this->details as $detail) {
            $detailIds[] = $detail->id;
        }
        
        $workOrderCuttingHeader = $this->header->workOrderCuttingHeader;
        $totalQuantityRemaining = 0;
        foreach ($workOrderCuttingHeader->workOrderCuttingDetails as $workOrderCuttingDetail) {
            $totalQuantityRemaining += $workOrderCuttingDetail->quantity;
            
            foreach ($workOrderCuttingDetail->productionPlanningCuttingDetails as $productionPlanningCuttingDetail) {
                if (!in_array($productionPlanningCuttingDetail->id, $detailIds)) {
                    $totalQuantityRemaining -= $productionPlanningCuttingDetail->quantity;
                }
            }
        }
        if ($isSaved) {
            foreach ($this->details as $detail) {
                $totalQuantityRemaining -= $detail->quantity;
            }
        }
        $workOrderCuttingHeader->total_quantity_cutting_planning_remaining = $totalQuantityRemaining;
        $valid = $workOrderCuttingHeader->update(array('total_quantity_cutting_planning_remaining'));
        
        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;
            if ($this->header->productionPlanningCuttingDetails != NULL) {
                foreach ($this->header->productionPlanningCuttingDetails as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $valid = $valid && $detail->update(array('is_inactive'));
                }
            }

            $this->header->is_inactive = ActiveRecord::INACTIVE;
            $valid = $valid && $this->header->update(array('is_inactive'));
        
            $valid = $this->syncWorkOrderCuttingHeader(false) && $valid;

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
