<?php

class SaleHeader extends SaleHeaderBase {

    const CN_CONSTANT = 'SO';
    const SERVICE = 1;
    const PRODUCT = 0;
    const SERVICE_LITERAL = 'Jasa';
    const PRODUCT_LITERAL = 'Barang';
    const PROCESSED = 0;
    const PENDING = 1;
    const PROCESSED_LITERAL = 'No';
    const PENDING_LITERAL = 'Yes';
    const NON_ORIGINAL_MATERIAL = 0;
    const ORIGINAL_MATERIAL = 1;
    const NON_ORIGINAL_MATERIAL_LITERAL = 'No';
    const ORIGINAL_MATERIAL_LITERAL = 'Yes';
    const CURRENT = 0;
    const REPLACEMENT = 1;
    const CURRENT_LITERAL = 'New';
    const REPLACEMENT_LITERAL = 'Replacement';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getProductServiceStatus() {
        return ((int) $this->is_service === 0) ? self::PRODUCT_LITERAL : self::SERVICE_LITERAL;
    }

    public function getOrderStatus() {
        return ((int) $this->is_order_delayed === 0) ? self::PROCESSED_LITERAL : self::PENDING_LITERAL;
    }

    public function getOriginalMaterialStatus() {
        return ((int) $this->is_original_material === 0) ? self::NON_ORIGINAL_MATERIAL_LITERAL : self::ORIGINAL_MATERIAL_LITERAL;
    }

    public function getTransactionStatus() {
        return ((int) $this->is_replacement === 0) ? self::CURRENT_LITERAL : self::REPLACEMENT_LITERAL;
    }

    public function searchWorkOrderCutting() {
        $dataProvider = $this->search();
        $dataProvider->criteria->addCondition(
            "t.id NOT IN (
                SELECT sale_header_id 
                FROM " . WorkOrderCuttingHeader::model()->tableName() . " workOrder
                WHERE workOrder.is_inactive = 0
            ) AND t.date > '2021-12-31'"
        );
        $dataProvider->criteria->compare('t.is_inactive', 0);

        return $dataProvider;
    }

    //we don't input quantity other than quotation, so delivery quantity will always the same as quotation quantity_quote. 15-dec-2015
    public function searchByItemDelivered($isNonTax = null) {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT q.quantity_quote - SUM(COALESCE(w.quantity, 0)) AS quantity_sold
            FROM " . QuotationDetailProduct::model()->tableName() . " q
            LEFT OUTER JOIN " . SaleDetailProduct::model()->tableName() . " s ON s.quotation_detail_product_id = q.id
            LEFT OUTER JOIN " . WorkOrderCuttingDetailProduct::model()->tableName() . " w ON w.sale_detail_id = s.id
            WHERE t.id = s.sale_header_id AND s.is_inactive = 0 
            GROUP BY q.id
            HAVING quantity_sold > 0
        )";

        if ($isNonTax !== null) {
            $criteria->addCondition('t.is_non_tax = :is_non_tax');
            $criteria->params[':is_non_tax'] = intval($isNonTax);
        }

        $criteria->compare('cn_ordinal', $this->cn_ordinal, true);
        $criteria->compare('cn_month', $this->cn_month, true);
        $criteria->compare('cn_year', $this->cn_year, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('supplier_id', $this->supplier_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchForSaleInvoice() {
        $dataProvider = $this->search();

        $dataProvider->criteria->addCondition('
            t.id NOT IN (
                SELECT saleInvoice.sale_header_id
                FROM ' . SaleInvoiceHeader::model()->tableName() . ' saleInvoice
                WHERE saleInvoice.is_inactive = 0
            )
        ');

        return $dataProvider;
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.customer_order_number', $this->customer_order_number, true);
        $criteria->compare('t.quotation_header_id', $this->quotation_header_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.is_service', $this->is_service);
        $criteria->compare('t.is_order_delayed', $this->is_order_delayed);
        $criteria->compare('t.is_inactive', $this->is_inactive);

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

    public function getCustomerOrderStatus() {
        return ((int) $this->is_order_delayed === 0) ? 'No' : 'Yes';
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->saleDetails as $saleDetail) {
            $total += CHtml::value($saleDetail, 'quantity');
        }

        return $total;
    }

    public function getTotalWeight() {
        $total = 0.00;

        foreach ($this->saleDetails as $saleDetail) {
            $total += CHtml::value($saleDetail, 'quotationDetailProduct.weight');
            $total += CHtml::value($saleDetail, 'quotationDetailService.weight');
        }

        return $total;
    }

    public function getGrandTotalTransaction() {
        $total = 0.00;

        foreach ($this->saleDetails as $saleDetail) {
            $total += $saleDetail->total;
        }

        return $total;
    }

    public function getWorkOrderCuttingHeaderNumber() {
        return empty($this->workOrderCuttingHeaders) ? ' N/A' : $this->workOrderCuttingHeaders[0]->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT);
    }

    public function getSaleInvoiceHeaderNumber() {
        $workOrderCuttingHeader = empty($this->workOrderCuttingHeaders) ? ' N/A' : $this->workOrderCuttingHeaders[0];

        return empty($workOrderCuttingHeader->saleInvoiceHeaders) ? ' N/A' : $workOrderCuttingHeader->saleInvoiceHeaders[0]->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT);
    }
//
//    public function getManualSaleInvoiceHeaderNumber() {
//        $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('sale_header_id' => $this->id));
//        $manualSaleInvoiceHeader = empty($workOrderCuttingHeader) ? "" : ManualSaleInvoiceHeader::model()->findByAttributes(array('work_order_cutting_header_id' => $workOrderCuttingHeader->id));
//
//        return empty($manualSaleInvoiceHeader) ? "" : $manualSaleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT);
//    }
//
//    public function getManualSaleInvoiceHeaderDate() {
//        $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('sale_header_id' => $this->id));
//        $manualSaleInvoiceHeader = empty($workOrderCuttingHeader) ? "" : ManualSaleInvoiceHeader::model()->findByAttributes(array('work_order_cutting_header_id' => $workOrderCuttingHeader->id));
//
//        return empty($manualSaleInvoiceHeader) ? "" : $manualSaleInvoiceHeader->date;
//    }
}
