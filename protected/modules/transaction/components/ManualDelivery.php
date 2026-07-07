<?php

class ManualDelivery extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $deliveryHeader = ManualDeliveryHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($deliveryHeader !== null)
            $this->header->setCodeNumber($deliveryHeader->cn_ordinal, $deliveryHeader->cn_month, $deliveryHeader->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function addCuttingDetails($workOrderCuttingId) {

        $this->details = array();
        $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByPk($workOrderCuttingId);

        if ($workOrderCuttingHeader !== null) {
            foreach ($workOrderCuttingHeader->workOrderCuttingDetails as $workOrderCuttingDetail) {
                $detail = new ManualDeliveryDetail();

                $detail->work_order_cutting_detail_id = $workOrderCuttingDetail->id;
                $detail->grade_name = $workOrderCuttingDetail->product_name;
                $detail->length = $workOrderCuttingDetail->length_quote;
                $detail->width = $workOrderCuttingDetail->width_quote;
                $detail->height = $workOrderCuttingDetail->height_quote;
                $detail->is_miling = $workOrderCuttingDetail->is_miling;
                $detail->is_sidemiling = $workOrderCuttingDetail->is_sidemiling;
                $detail->is_grinding = $workOrderCuttingDetail->is_grinding;
                $detail->is_hardness = $workOrderCuttingDetail->is_hardness;
                $detail->is_annelying = $workOrderCuttingDetail->is_annelying;
                $detail->quantity = $workOrderCuttingDetail->quantity;
                $detail->weight = $workOrderCuttingDetail->weight;
                $detail->product_category_id = $workOrderCuttingDetail->product_category_id;

                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function validate() {
        $valid = $this->header->validate();
        $valid = $this->validateDetailsCount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('length', 'width', 'height', 'weight', 'quantity');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
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

    public function flush() {
        $valid = $this->header->save(false);
        
        foreach ($this->details as $detail) {
            if ($detail->isNewRecord) {
                $detail->manual_delivery_header_id = $this->header->id;
            }
            
            $valid = $detail->save(false) && $valid;
            
            $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByPk($detail->work_order_cutting_detail_id);
            if (!empty($workOrderCuttingDetail)) {
                $workOrderCuttingDetail->quantity_delivery = $workOrderCuttingDetail->getAccumulatedQuantityDelivery();
            }
            $workOrderCuttingDetail->update(array('quantity_delivery'));
        }

        return $valid;
    }
    
    public function getTotalQuantity() {
        $total = 0;
        
        foreach ($this->details as $detail)
            $total += $detail->quantity;

        return $total;
    }
    
    public function getTotalWeight() {
        $total = 0.0000;
        
        foreach ($this->details as $detail)
            $total += $detail->weight;

        return $total;
    }
}
