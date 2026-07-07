<?php

class WorkOrderReplacementComponent extends CComponent {

    public $header;
    public $details;
    public $detailStocks;
    public $detailOffCuts;
    public $detailMaterials;

    public function __construct($header, array $details, array $detailStocks, array $detailOffCuts, array $detailMaterials) {
        $this->header = $header;
        $this->details = $details;
//        $this->detailStocks = $detailStocks;
        $this->detailOffCuts = $detailOffCuts;
        $this->detailMaterials = $detailMaterials;
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $header = WorkOrderReplacementHeader::model()->find(array(
            'condition' => 'cn_year = :cn_year AND cn_month = :cn_month',
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $currentMonth),
            'order' => 'cn_year DESC, cn_month DESC, cn_ordinal DESC',
        ));

        if ($header !== null)
            $this->header->setCodeNumber($header->cn_ordinal, $header->cn_month, $header->cn_year);

        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
    }

    public function generateSerialNumber($receiveDetailId) {
        $serialNumber = Yii::app()->db->createCommand()
            ->select('serial_number')
            ->from('tblsp_work_order_cutting_detail_material')
            ->where('receive_detail_id = :receiveDetailId', array(':receiveDetailId' => $receiveDetailId))
            ->order('id DESC')
            ->queryRow();

        if ($serialNumber != null)
            return $serialNumber['serial_number'] + 1;
        else
            return 1;
    }

    public function addQualityControlCuttingDetails($qualityControlCuttingId) {
        $this->details = array();

        $qualityControlCuttingHeader = QualityControlCuttingHeader::model()->findByPk($qualityControlCuttingId);
        if ($qualityControlCuttingHeader != null) {
            foreach ($qualityControlCuttingHeader->qualityControlCuttingDetails as $qualityControlCuttingDetail) {
                if ($qualityControlCuttingDetail->control_result === 'NG') {
                    $detail = new WorkOrderReplacementDetail();
                    $detail->work_order_cutting_detail_id = $qualityControlCuttingDetail->work_order_cutting_detail_id;
                    $detail->quality_control_cutting_detail_id = $qualityControlCuttingDetail->id;
                    $detail->quality_control_miling_detail_id = NULL;
                    $detail->job_number = $qualityControlCuttingDetail->workOrderCuttingDetail->job_number;
                    $detail->product_name = $qualityControlCuttingDetail->workOrderCuttingDetail->product_name;
                    $detail->height_quote = $qualityControlCuttingDetail->workOrderCuttingDetail->height_quote;
                    $detail->width_quote = $qualityControlCuttingDetail->workOrderCuttingDetail->width_quote;
                    $detail->length_quote = $qualityControlCuttingDetail->workOrderCuttingDetail->length_quote;
                    $detail->height_request = $qualityControlCuttingDetail->workOrderCuttingDetail->height_request;
                    $detail->width_request = $qualityControlCuttingDetail->workOrderCuttingDetail->width_request;
                    $detail->length_request = $qualityControlCuttingDetail->workOrderCuttingDetail->length_request;
                    $detail->quantity = $qualityControlCuttingDetail->quantity;
                    $detail->weight = $qualityControlCuttingDetail->workOrderCuttingDetail->weight;
                    $detail->product_category_id = $qualityControlCuttingDetail->workOrderCuttingDetail->product_category_id;
                    $detail->is_miling = $qualityControlCuttingDetail->workOrderCuttingDetail->is_miling;
                    $detail->is_grinding = $qualityControlCuttingDetail->workOrderCuttingDetail->is_grinding;
                    $detail->is_hardness = $qualityControlCuttingDetail->workOrderCuttingDetail->is_hardness;
                    $detail->is_annelying = $qualityControlCuttingDetail->workOrderCuttingDetail->is_annelying;
                    $detail->is_sidemiling = $qualityControlCuttingDetail->workOrderCuttingDetail->is_sidemiling;
                    $detail->is_cut = $qualityControlCuttingDetail->workOrderCuttingDetail->is_cut;
                    $this->details[] = $detail;
                }
            }
        }
    }
    
    public function addQualityControlMilingDetails($qualityControlMilingId) {
        $this->details = array();

        $qualityControlMilingHeader = QualityControlMilingHeader::model()->findByPk($qualityControlMilingId);
        if ($qualityControlMilingHeader != null) {
            foreach ($qualityControlMilingHeader->qualityControlMilingDetails as $qualityControlMilingDetail) {
                if ($qualityControlMilingDetail->control_result === 'NG') {
                    $detail = new WorkOrderReplacementDetail();
                    $detail->work_order_cutting_detail_id = $qualityControlMilingDetail->work_order_cutting_detail_id;
                    $detail->quality_control_cutting_detail_id = NULL;
                    $detail->quality_control_miling_detail_id = $qualityControlMilingDetail->id;
                    $detail->job_number = $qualityControlMilingDetail->workOrderCuttingDetail->job_number;
                    $detail->product_name = $qualityControlMilingDetail->workOrderCuttingDetail->product_name;
                    $detail->height_quote = $qualityControlMilingDetail->workOrderCuttingDetail->height_quote;
                    $detail->width_quote = $qualityControlMilingDetail->workOrderCuttingDetail->width_quote;
                    $detail->length_quote = $qualityControlMilingDetail->workOrderCuttingDetail->length_quote;
                    $detail->height_request = $qualityControlMilingDetail->workOrderCuttingDetail->height_request;
                    $detail->width_request = $qualityControlMilingDetail->workOrderCuttingDetail->width_request;
                    $detail->length_request = $qualityControlMilingDetail->workOrderCuttingDetail->length_request;
                    $detail->quantity = $qualityControlMilingDetail->quantity;
                    $detail->weight = $qualityControlMilingDetail->workOrderCuttingDetail->weight;
                    $detail->product_category_id = $qualityControlMilingDetail->workOrderCuttingDetail->product_category_id;
                    $detail->is_miling = $qualityControlMilingDetail->workOrderCuttingDetail->is_miling;
                    $detail->is_grinding = $qualityControlMilingDetail->workOrderCuttingDetail->is_grinding;
                    $detail->is_hardness = $qualityControlMilingDetail->workOrderCuttingDetail->is_hardness;
                    $detail->is_annelying = $qualityControlMilingDetail->workOrderCuttingDetail->is_annelying;
                    $detail->is_sidemiling = $qualityControlMilingDetail->workOrderCuttingDetail->is_sidemiling;
                    $detail->is_cut = $qualityControlMilingDetail->workOrderCuttingDetail->is_cut;
                    $this->details[] = $detail;
                }
            }
        }
    }
    
    public function removeDetailProduct($index) {
        array_splice($this->details, $index, 1);
    }

    public function addDetail($modelId, $index, $type, $rowQuantity) {
        if ($type === 'receive') {
            $model = ReceiveDetail::model();
            $attribute = 'receive_detail_id';
        } else if ($type === 'work_order') {
            $model = WorkOrderCuttingDetailMaterial::model();
            $attribute = 'work_order_cutting_detail_material_id';
        } else {
            return;
        }
        
        $modelDetail = $model->findByPk($modelId);

        if ($modelDetail !== null) {
            $detail = new WorkOrderCuttingDetailMaterial();
            $detail->$attribute = $modelId;
            
            $detail->width = $modelDetail->width;
            $detail->height = $modelDetail->height;
            $detail->product_name = $modelDetail->product_name;
            $detail->product_category_id = $modelDetail->product_category_id;
            $detail->quantity = ($type === 'receive') ? 1 : $modelDetail->quantity;
            $detail->location_id = $modelDetail->location_id;
            $detail->weight = $modelDetail->weight; 
            $detail->receive_detail_id = ($type === 'work_order') ? $modelDetail->receive_detail_id : $modelId;

            for ($i = 0; $i < $rowQuantity; $i++)
                $this->detailOffCuts[] = $detail;
        }
    }

    public function removeDetailMaterial($index) {
        array_splice($this->detailOffCuts, $index, 1);
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0)
            $valid = false;
        
        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        return $valid;
    }

    public function flush() {
        $this->header->cn_ordinal = $this->header->workOrderCuttingHeader->cn_ordinal;
        $this->header->cn_month = $this->header->workOrderCuttingHeader->cn_month;
        $this->header->cn_year = $this->header->workOrderCuttingHeader->cn_year;
        $this->header->is_service = $this->header->workOrderCuttingHeader->is_service;

        $valid = $this->header->save(false);

        foreach ($this->details as $index => $detail) {
            if ($detail->isNewRecord)
                $detail->work_order_replacement_header_id = $this->header->id;
            
            $detail->weight = $detail->weightRequest;

            $valid = $detail->save(false) && $valid;
            
            foreach ($this->detailMaterials[$index] as $detailMaterial) {
                $serialNumber = $this->generateSerialNumber($detailMaterial->receive_detail_id);
                $detailMaterial->serial_number = $serialNumber;
                $detailMaterial->work_order_replacement_detail_id = $detail->id;

                $valid = $detailMaterial->save(false) && $valid;
            }
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->flush();

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