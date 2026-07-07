<?php

class WorkOrderReplacementDetailComponent extends CComponent {

    public $details;

    public function __construct(array $details) {
        $this->details = $details;
    }

    public function validate() {
        $valid = true;
        foreach ($this->details as $index => $detail) {
            $fields = array('weight_tolerance', 'location_id');
            $valid = $detail->validate($fields) && $valid;
        }
        
        return $valid;
    }

    public function flush() {
        $valid = true;
        foreach ($this->details as $index => $detail) {
            $valid = $valid && $detail->save(false);
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();

            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

}