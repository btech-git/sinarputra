<?php

class ProductionPlanningMiling extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $header = ProductionPlanningMilingHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($header !== null)
            $this->header->setCodeNumber($header->cn_ordinal, $header->cn_month, $header->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addCuttingDetails($workOrderCuttingId) {

        $this->details = array();
        $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByPk($workOrderCuttingId);

        if ($workOrderCuttingHeader !== null) {
            foreach ($workOrderCuttingHeader->workOrderCuttingDetails as $workOrderCuttingDetail) {
                if ((int)$workOrderCuttingDetail->is_external_order === 0) {
                    $detail = new ProductionPlanningMilingDetail();

                    $detail->work_order_cutting_detail_id = $workOrderCuttingDetail->id;
                    $detail->work_order_replacement_detail_id = null;
                    $detail->length_request = $workOrderCuttingDetail->length_request;
                    $detail->width_request = $workOrderCuttingDetail->width_request;
                    $detail->height_request = $workOrderCuttingDetail->height_request;
                    $detail->length_quote = $workOrderCuttingDetail->length_quote;
                    $detail->width_quote = $workOrderCuttingDetail->width_quote;
                    $detail->height_quote = $workOrderCuttingDetail->height_quote;
                    $detail->quantity = $workOrderCuttingDetail->quantity;
                    $detail->weight = $workOrderCuttingDetail->weight;
                    $this->details[] = $detail;
                }
            }
        }
    }

    public function addReplacementDetails($workOrderReplacementId) {

        $this->details = array();
        $workOrderReplacementHeader = WorkOrderReplacementHeader::model()->findByPk($workOrderReplacementId);

        if ($workOrderReplacementHeader !== null) {
            foreach ($workOrderReplacementHeader->workOrderReplacementDetails as $workOrderReplacementDetail) {
                $detail = new ProductionPlanningMilingDetail();

                $detail->work_order_cutting_detail_id = null;
                $detail->work_order_replacement_detail_id = $workOrderReplacementDetail->id;
                $detail->length_request = $workOrderReplacementDetail->length_request;
                $detail->width_request = $workOrderReplacementDetail->width_request;
                $detail->height_request = $workOrderReplacementDetail->height_request;
                $detail->length_quote = $workOrderReplacementDetail->length_quote;
                $detail->width_quote = $workOrderReplacementDetail->width_quote;
                $detail->height_quote = $workOrderReplacementDetail->height_quote;
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

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

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

        $totalQuantityRemaining = 0;
        foreach ($this->details as $index => $detail) {
            $totalQuantityRemaining += $detail->quantity;
        }
        $this->header->total_quantity_production_remaining = $totalQuantityRemaining;
            
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            $detail->production_planning_miling_header_id = $this->header->id;
            $valid = $detail->save(false) && $valid;
        }

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

}
