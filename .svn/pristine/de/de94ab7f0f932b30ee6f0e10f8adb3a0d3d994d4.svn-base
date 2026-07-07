<?php

class SaleInvoiceSampleSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader'
                ),
            ),
            'customer:resetScope'
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.date', 'customer.company');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('customer.company', $filters['customerName'], TRUE);
        //$this->dataProvider->criteria->compare('deliveryHeader.is_sample', 1);
    }

    public function reportGrandTotal() {
        $grandTotal = 0.00;

        foreach ($this->dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

}
