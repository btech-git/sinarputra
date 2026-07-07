<?php

class WorkOrderCuttingComponent extends CComponent {

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
        $header = WorkOrderCuttingHeader::model()->find(array(
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
//        $maxWeight = $this->details[$index]->weight * 2;

        if ($modelDetail !== null) { // && $modelDetail->weight <= $maxWeight) {
            $detail = new WorkOrderCuttingDetailMaterial();
            $detail->$attribute = $modelId;

//            if ((int)$modelDetail->product_category_id === 2 && count($this->detailOffCuts) === 0) {
//                $workOrderLength = $this->details[$index]->length_request * $this->details[$index]->quantity;
//                $detail->length = $modelDetail->length - $workOrderLength;            
//            }

            $detail->length = $modelDetail->length;
            $detail->width = $modelDetail->width;
            $detail->height = $modelDetail->height;
            $detail->product_name = $modelDetail->product_name;
            $detail->product_category_id = null;
//            $detail->quantity = ($type === 'work_order') ? $modelDetail->quantity : 1;
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

    public function addWorkOrderCuttingDetails($saleHeaderId) {
        $this->details = array();

        $saleHeader = SaleHeader::model()->findByPk($saleHeaderId);
        if ($saleHeader != null) {
            foreach ($saleHeader->saleDetails as $saleDetail) {
                $saleDetailProductService = ((int)$saleDetail->quotation_detail_product_id == null) ? $saleDetail->quotationDetailService : $saleDetail->quotationDetailProduct;
                $detail = new WorkOrderCuttingDetail();
                $detail->sale_detail_id = $saleDetail->id;
                $detail->job_number = $saleDetailProductService->job_number;
                $detail->product_name = ((int)$saleDetail->quotation_detail_product_id == null) ? $saleDetail->quotationDetailService->product_name : $saleDetail->quotationDetailProduct->product_name_quote;
                $detail->height_quote = $saleDetailProductService->height_quote;
                $detail->width_quote = $saleDetailProductService->width_quote;
                $detail->length_quote = $saleDetailProductService->length_quote;
                $detail->height_request = $saleDetailProductService->height_request;
                $detail->width_request = $saleDetailProductService->width_request;
                $detail->length_request = $saleDetailProductService->length_request;
                $detail->quantity = $saleDetailProductService->quantity_quote;
                $detail->weight = $saleDetailProductService->weight;
                $detail->product_category_id = $saleDetailProductService->product_category_id;
                $detail->is_miling = $saleDetailProductService->is_miling;
                $detail->is_grinding = $saleDetailProductService->is_grinding;
                $detail->is_hardness = $saleDetailProductService->is_hardness;
                $detail->is_annelying = $saleDetailProductService->is_annelying;
                $detail->is_sidemiling = $saleDetailProductService->is_sidemiling;
                $detail->is_coating = $saleDetailProductService->is_coating;
                $detail->is_cut = ((int)$saleDetail->quotation_detail_product_id == null) ? $saleDetail->quotationDetailService->is_cutting : 1;
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

    public function validateMaterialsWeight() {
        $valid = true;
        
        foreach ($this->details as $detail) {
            $detailTransaction = !empty($detail->work_order_cutting_detail_material_id) ? $detail->workOrderCuttingDetailMaterial : $detail->receiveDetail; 
            $detailWeight = $detailTransaction->weight;
            
            foreach ($this->detailMaterials as $detailMaterial) {
                if ($detailMaterial->weight > $detailWeight) {
                    $valid = false;
                }
            }
        }
        
        return $valid;
    }

    public function validate() {
        
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');

        $valid = $this->validateDetailsCount();
        if (!$valid)
            $this->header->addError('error', 'Details Count Error');

        $valid = $this->validateMaterialsWeight();
        if (!$valid)
            $this->header->addError('error', 'Berat Material Tidak Diperbolehkan');

        return $valid;
    }

    public function flush() {
        $this->header->cn_ordinal = $this->header->saleHeader->cn_ordinal;
        $this->header->cn_month = $this->header->saleHeader->cn_month;
        $this->header->cn_year = $this->header->saleHeader->cn_year;
        $this->header->is_service = $this->header->saleHeader->is_service;
        
        $totalQuantityRemaining = 0;
        foreach ($this->details as $index => $detail) {
            if ($detail->is_miling == 1 || $detail->is_grinding == 1 || $detail->is_hardness == 1 || $detail->is_annelying == 1 || $detail->is_sidemiling == 1) {
                $this->header->is_miling_additional = 1;
            }
            
            $totalQuantityRemaining += $detail->quantity;
        }
        $this->header->total_quantity_cutting_planning_remaining = $totalQuantityRemaining;
        $this->header->total_quantity_delivery_remaining = $totalQuantityRemaining;
                
        $valid = $this->header->save(false);

        foreach ($this->details as $index => $detail) {
            if ($detail->isNewRecord)
                $detail->work_order_cutting_header_id = $this->header->id;
            
            $valid = $detail->save(false) && $valid;
            
            if ((int)$detail->is_cut === 1 && (int)$detail->is_external_order === 0) {
                foreach ($this->detailMaterials[$index] as $detailMaterial) {
                    $serialNumber = $this->generateSerialNumber($detailMaterial->receive_detail_id);

                    $detailMaterial->serial_number = $serialNumber;
                    $serialNumber++;

                    $detailMaterial->work_order_cutting_detail_id = $detail->id;

                    $valid = $detailMaterial->save(false) && $valid;
                }
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