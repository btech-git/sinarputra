<?php

class WorkOrderCuttingHeader extends WorkOrderCuttingHeaderBase {

    const CN_CONSTANT = 'SPK';
    const NO_VALUE = 0;
    const YES_VALUE = 1;
    const NO_LITERAL = 'No';
    const YES_LITERAL = 'Yes';
    const SERVICE = 1;
    const PRODUCT = 0;
    const SERVICE_LITERAL = 'Jasa';
    const PRODUCT_LITERAL = 'Barang';
    const NO_MILING = 0;
    const ADD_MILING = 1;
    const NO_MILING_LITERAL = 'No';
    const ADD_MILING_LITERAL = 'Yes';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPending() {
        return ($this->is_pending) ? self::YES_LITERAL : self::NO_LITERAL;
    }

    public function getMilingStatus() {
        return ($this->is_miling_additional) ? self::ADD_MILING_LITERAL : self::NO_MILING_LITERAL;
    }

    public function getProgressStatus() {

        $onProgressFlag = ProductionPlanningCuttingHeader::model()->findByAttributes(array('work_order_cutting_header_id' => $this->id));
        $completeFlag = !empty($onProgressFlag) ? ProductionCuttingHeader::model()->findByAttributes(array('production_planning_cutting_header_id' => $onProgressFlag->id)) : '';
        $partialDeliveryFlag = DeliveryHeader::model()->findByAttributes(array('work_order_cutting_header_id' => $this->id));
        $deliveredFlag = SaleInvoiceHeader::model()->findByAttributes(array('work_order_cutting_header_id' => $this->id));

        if ($deliveredFlag)
            $progresStatus = 'Invoiced';
        elseif ($partialDeliveryFlag)
            $progresStatus = 'On Partial Delivery';
        elseif ($completeFlag)
            $progresStatus = 'Completed';
        elseif ($onProgressFlag)
            $progresStatus = 'On PPC Process';
        else
            $progresStatus = 'On Queue';

        return $progresStatus;
    }

    public function getProgressValue() {
        $progresValue = 0;

        $onProgressFlag = JobOrderHeader::model()->findAllByAttributes(array('work_order_cutting_header_id' => $this->id));

        $completeFlag = CuttingHeader::model()->findAllByAttributes(array('work_order_cutting_header_id' => $this->id));

        if ($onProgressFlag)
            $progresValue = 1;

        if ($completeFlag)
            $progresValue = 2;

        return $progresValue;
    }

    public function searchForProductionPlanningCutting() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.total_quantity_cutting_planning_remaining > 0 AND t.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.sale_header_id', $this->sale_header_id);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchForProductionPlanningMiling() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.id NOT IN (
            SELECT work_order_cutting_header_id
            FROM " . ProductionPlanningMilingHeader::model()->tableName() . "   
            WHERE t.id = work_order_cutting_header_id 
        ) AND t.is_miling_additional = 1 AND t.is_inactive = 0 AND t.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.sale_header_id', $this->sale_header_id);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_miling_additional', $this->is_miling_additional);
        $criteria->compare('t.is_pending', $this->is_pending);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchForSaleInvoice() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.id NOT IN (
            SELECT si.work_order_cutting_header_id
            FROM " . SaleInvoiceHeader::model()->tableName() . " si
            WHERE t.id = si.work_order_cutting_header_id AND si.is_inactive = 0
        ) AND t.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.sale_header_id', $this->sale_header_id);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_miling_additional', $this->is_miling_additional);
        $criteria->compare('t.is_pending', $this->is_pending);
        $criteria->compare('t.is_inactive', 0);
        $criteria->compare('t.total_quantity_delivery_remaining', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.time_created', $this->time_created, true);
        $criteria->compare('t.sale_header_id', $this->sale_header_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_pending', $this->is_pending);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        $criteria->with = array(
            'saleHeader' => array(
                'with' => array(
                    'customer:resetScope',
                ),
            ),
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }

    public function getTotalQuantityDetail() {
        $total = 0;

        foreach ($this->workOrderCuttingDetails as $workOrderCuttingDetail) {
            if ($workOrderCuttingDetail->is_inactive == 0)
                $total += $workOrderCuttingDetail->quantity;
        }

        return $total;
    }

    public function getTotalQuantityProductionPlanning() {
        $total = 0;

        foreach ($this->productionPlanningCuttingHeaders as $productionPlanningCuttingHeader) {
            foreach ($productionPlanningCuttingHeader->productionPlanningCuttingDetails as $productionPlanningCuttingDetail) {
                if ($productionPlanningCuttingDetail->is_inactive == 0)
                    $total += $productionPlanningCuttingDetail->quantity;
            }
        }

        return $total;
    }

    public function getTotalQuantityProduction() {
        $total = 0;

        foreach ($this->productionPlanningCuttingHeaders as $productionPlanningCuttingHeader) {
            foreach ($productionPlanningCuttingHeader->productionCuttingHeaders as $productionCuttingHeader) {
                foreach ($productionCuttingHeader->productionCuttingDetails as $productionCuttingDetail) {
                    if ($productionCuttingDetail->is_inactive == 0)
                        $total += $productionCuttingDetail->quantity;
                }
            }
        }

        return $total;
    }

    public function getTotalQuantityProductionMiling() {
        $total = 0;

        foreach ($this->productionPlanningMilingHeaders as $productionPlanningMilingHeader) {
            foreach ($productionPlanningMilingHeader->productionMilingHeaders as $productionMilingHeader) {
                foreach ($productionMilingHeader->productionMilingDetails as $productionMilingDetail) {
                    if ($productionMilingDetail->is_inactive == 0)
                        $total += $productionMilingDetail->quantity;
                }
            }
        }

        return $total;
    }

    public function getTotalQuantityQualityControlCutting() {
        $total = 0;

        foreach ($this->qualityControlCuttingHeaders as $qualityControlCuttingHeader) {
            foreach ($qualityControlCuttingHeader->qualityControlCuttingDetails as $qualityControlCuttingDetail) {
                if ($qualityControlCuttingDetail->is_inactive == 0)
                    $total += $qualityControlCuttingDetail->quantity;
            }
        }

        return $total;
    }

    public function getTotalQuantityQualityControlMiling() {
        $total = 0;

        foreach ($this->qualityControlMilingHeaders as $qualityControlMilingHeader) {
            foreach ($qualityControlMilingHeader->qualityControlMilingDetails as $qualityControlMilingDetail) {
                if ($qualityControlMilingDetail->is_inactive == 0)
                    $total += $qualityControlMilingDetail->quantity;
            }
        }

        return $total;
    }

    public function getTotalQuantityDelivered() {
        $total = 0;

        foreach ($this->deliveryHeaders as $deliveryHeader) {
            foreach ($deliveryHeader->deliveryDetails as $deliveryDetail) {
                if ($deliveryDetail->is_inactive == 0)
                    $total += $deliveryDetail->quantity;
            }
        }

        return $total;
    }

    public function getQuantityDeliveryRemaining() {
        return $this->totalQuantityDetail - $this->totalQuantityDelivered;
    }

    public function searchForDelivery() {
        $criteria = new CDbCriteria;

        $criteria->condition = "("
                . "SELECT SUM(quantity - quantity_delivery) as remaining "
                . "FROM " . WorkOrderCuttingDetail::model()->tableName() . " "
                . "WHERE work_order_cutting_header_id = t.id "
                . "GROUP BY work_order_cutting_header_id "
                . "HAVING remaining > 0 "
                . ") AND t.date > '2021-12-31'";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.sale_header_id', $this->sale_header_id);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            )
        ));
    }
    
    public function getSaleInvoiceNumbers() {
        $saleInvoiceHeaders = array();

        foreach ($this->saleInvoiceHeaders as $header) {
            $saleInvoiceHeaders[] = $header->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT) . ', ';
        }

        return $this->search_sale_invoice_number = implode('', $saleInvoiceHeaders);
    }

    public function getSaleInvoiceDates() {
        $saleInvoiceHeaders = array();

        foreach ($this->saleInvoiceHeaders as $header) {
            $saleInvoiceHeaders[] = $header->date . ', ';
        }

        return $this->search_sale_invoice_date = implode('', $saleInvoiceHeaders);
    }

    public function getSaleReceiptNumbers() {
        $saleReceiptHeaders = array();

        foreach ($this->saleInvoiceHeaders as $header) {
            foreach ($header->saleReceiptDetails as $detail) {
                $saleReceiptHeaders[] = $detail->saleReceiptHeader->getCodeNumber(SaleReceiptHeader::CN_CONSTANT) . ', ';
            }
        }

        return $this->search_sale_receipt_number = implode('', $saleReceiptHeaders);
    }

    public function getSaleReceiptDates() {
        $saleReceiptHeaders = array();

        foreach ($this->saleInvoiceHeaders as $header) {
            foreach ($header->saleReceiptDetails as $detail) {
                $saleReceiptHeaders[] = $detail->saleReceiptHeader->date . ', ';
            }
        }

        return $this->search_sale_receipt_date = implode('', $saleReceiptHeaders);
    }

    public function getManualSaleInvoiceNumbers() {
        $saleInvoiceHeaders = array();

        foreach ($this->deliveryHeaders as $header) {
            foreach ($header->deliveryDetails as $detail) {
                foreach ($detail->manualSaleInvoiceDetails as $invoice) {
                    $saleInvoiceHeaders[] = $invoice->manualSaleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT) . ', ';
                }
            }
        }

        return $this->search_manual_sale_invoice_number = implode('', array_unique($saleInvoiceHeaders));
    }

    public function getManualSaleInvoiceDates() {
        $saleInvoiceHeaders = array();

        foreach ($this->deliveryHeaders as $header) {
            foreach ($header->deliveryDetails as $detail) {
                foreach ($detail->manualSaleInvoiceDetails as $invoice) {
                    $saleInvoiceHeaders[] = $invoice->manualSaleInvoiceHeader->date . ', ';
                }
            }
        }

        return $this->search_manual_sale_invoice_date = implode('', array_unique($saleInvoiceHeaders));
    }

    public function getManualSaleReceiptNumbers() {
        $saleReceiptHeaders = array();

        foreach ($this->deliveryHeaders as $header) {
            foreach ($header->deliveryDetails as $detail) {
                foreach ($detail->manualSaleInvoiceDetails as $invoice) {
                    foreach ($invoice->manualSaleInvoiceHeader->manualSaleReceiptDetails as $receipt) {
                        $saleReceiptHeaders[] = $receipt->manualSaleReceiptHeader->getCodeNumber(ManualSaleReceiptHeader::CN_CONSTANT) . ', ';
                    }
                }
            }
        }

        return $this->search_manual_sale_receipt_number = implode('', array_unique($saleReceiptHeaders));
    }

    public function getManualSaleReceiptDates() {
        $saleReceiptHeaders = array();

        foreach ($this->deliveryHeaders as $header) {
            foreach ($header->deliveryDetails as $detail) {
                foreach ($detail->manualSaleInvoiceDetails as $invoice) {
                    foreach ($invoice->manualSaleInvoiceHeader->manualSaleReceiptDetails as $receipt) {
                        $saleReceiptHeaders[] = $receipt->manualSaleReceiptHeader->date . ', ';
                    }
                }
            }
        }

        return $this->search_manual_sale_receipt_date = implode('', array_unique($saleReceiptHeaders));
    }

    public function getSaleInvoiceQuantity() {
        $total = 0;

        foreach ($this->saleInvoiceHeaders as $header) {
            foreach ($header->saleInvoiceDetails as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        foreach ($this->manualSaleInvoiceHeaders as $header) {
            foreach ($header->manualSaleInvoiceDetails as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        return $total;
    }

    public function getQualityControlCuttingNumbers() {
        $qualityControlCuttingHeaders = array();

        foreach ($this->qualityControlCuttingHeaders as $qualityControlCuttingHeader) {
            $qualityControlCuttingHeaders[] = $qualityControlCuttingHeader->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT) . ', ';
        }

        return $this->search_quality_control_cutting_number = implode('', $qualityControlCuttingHeaders);
    }

    public function getQualityControlCuttingDates() {
        $qualityControlCuttingHeaders = array();

        foreach ($this->qualityControlCuttingHeaders as $qualityControlCuttingHeader) {
            $qualityControlCuttingHeaders[] = $qualityControlCuttingHeader->date . ', ';
        }

        return $this->search_quality_control_cutting_date = implode('', $qualityControlCuttingHeaders);
    }
    
    public function getQualityControlCuttingQuantity() {
        $total = 0;

        foreach ($this->qualityControlCuttingHeaders as $header) {
            foreach ($header->qualityControlCuttingDetails as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        return $total;
    }

    public function getDeliveryCuttingNumbers() {
        $deliveryHeaders = array();
        $deliveries = DeliveryHeader::model()->findAll(array(
            'condition' => 'work_order_cutting_header_id = :id AND t.quality_control_cutting_header_id IS NOT NULL', 
            'params' => array(':id' => $this->id)
        ));

        foreach ($deliveries as $deliveryHeader) {
            $deliveryHeaders[] = $deliveryHeader->getCodeNumber(DeliveryHeader::CN_CONSTANT) . ', ';
        }

        return $this->search_delivery_cutting_number = implode('', $deliveryHeaders);
    }

    public function getDeliveryCuttingDates() {
        $deliveryHeaders = array();
        $deliveries = DeliveryHeader::model()->findAll(array(
            'condition' => 'work_order_cutting_header_id = :id AND t.quality_control_cutting_header_id IS NOT NULL', 
            'params' => array(':id' => $this->id)
        ));

        foreach ($deliveries as $deliveryHeader) {
            $deliveryHeaders[] = $deliveryHeader->date . ', ';
        }

        return $this->search_delivery_cutting_date = implode('', $deliveryHeaders);
    }
    
    public function getDeliveryCuttingQuantity() {
        $total = 0;
        $deliveries = DeliveryHeader::model()->findAll(array(
            'condition' => 'work_order_cutting_header_id = :id AND t.quality_control_cutting_header_id IS NOT NULL', 
            'params' => array(':id' => $this->id)
        ));

        foreach ($deliveries as $header) {
            foreach ($header->deliveryDetails as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        return $total;
    }

    public function getQualityControlMilingNumbers() {
        $qualityControlMilingHeaders = array();

        foreach ($this->qualityControlMilingHeaders as $qualityControlMilingHeader) {
            $qualityControlMilingHeaders[] = $qualityControlMilingHeader->getCodeNumber(QualityControlMilingHeader::CN_CONSTANT) . ', ';
        }

        return $this->search_quality_control_miling_number = implode('', $qualityControlMilingHeaders);
    }

    public function getQualityControlMilingDates() {
        $qualityControlMilingHeaders = array();

        foreach ($this->qualityControlMilingHeaders as $qualityControlMilingHeader) {
            $qualityControlMilingHeaders[] = $qualityControlMilingHeader->date . ', ';
        }

        return $this->search_quality_control_miling_date = implode('', $qualityControlMilingHeaders);
    }
    
    public function getQualityControlMilingQuantity() {
        $total = 0;

        foreach ($this->qualityControlMilingHeaders as $header) {
            foreach ($header->qualityControlMilingDetails as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        return $total;
    }

    public function getDeliveryMilingNumbers() {
        $deliveryHeaders = array();
        $deliveries = DeliveryHeader::model()->findAll(array(
            'condition' => 'work_order_cutting_header_id = :id AND t.quality_control_miling_header_id IS NOT NULL', 
            'params' => array(':id' => $this->id)
        ));

        foreach ($deliveries as $deliveryHeader) {
            $deliveryHeaders[] = $deliveryHeader->getCodeNumber(DeliveryHeader::CN_CONSTANT) . ', ';
        }

        return $this->search_delivery_miling_number = implode('', $deliveryHeaders);
    }

    public function getDeliveryMilingDates() {
        $deliveryHeaders = array();
        $deliveries = DeliveryHeader::model()->findAll(array(
            'condition' => 'work_order_cutting_header_id = :id AND t.quality_control_miling_header_id IS NOT NULL', 
            'params' => array(':id' => $this->id)
        ));

        foreach ($deliveries as $deliveryHeader) {
            $deliveryHeaders[] = $deliveryHeader->date . ', ';
        }

        return $this->search_delivery_miling_date = implode('', $deliveryHeaders);
    }
    
    public function getDeliveryMilingQuantity() {
        $total = 0;
        $deliveries = DeliveryHeader::model()->findAll(array(
            'condition' => 'work_order_cutting_header_id = :id AND t.quality_control_miling_header_id IS NOT NULL', 
            'params' => array(':id' => $this->id)
        ));

        foreach ($deliveries as $header) {
            foreach ($header->deliveryDetails as $detail) {
                if ($detail->is_inactive == 0) {
                    $total += $detail->quantity;
                }
            }
        }

        return $total;
    }
}
