<?php

class ProductionPlanningReplacement extends CComponent {

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

    public function addDetails($workOrderReplacementHeaderId) {

        $this->details = array();
        $workOrderReplacementHeader = WorkOrderReplacementHeader::model()->findByPk($workOrderReplacementHeaderId);

        if ($workOrderReplacementHeader !== null) {
            foreach ($workOrderReplacementHeader->workOrderReplacementDetails as $workOrderReplacementDetail) {
                $detail = new ProductionPlanningCuttingDetail();

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

                if ($this->details[$i]->work_order_replacement_detail_id
                        === $this->details[$j]->work_order_replacement_detail_id) {
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
//                if ($this->detailServices[$i]->work_order_Replacement_detail_service_id
//                        === $this->detailServices[$j]->work_order_Replacement_detail_service_id) {
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

        $this->header->cn_ordinal = $this->header->workOrderReplacementHeader->cn_ordinal;
        $this->header->cn_month = $this->header->workOrderReplacementHeader->cn_month;
        $this->header->cn_year = $this->header->workOrderReplacementHeader->cn_year;

        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            $detail->production_planning_cutting_header_id = $this->header->id;
            
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
