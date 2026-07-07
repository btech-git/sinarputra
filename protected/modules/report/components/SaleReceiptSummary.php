<?php

class SaleReceiptSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'workOrderCuttingHeader',
            'customer:resetScope',
            'employeeIdSalesman:resetScope',
        );
        $this->dataProvider->criteria->addCondition('t.is_inactive = 0');
       
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

    public function setupFilter($startDate, $endDate) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->addCondition('t.grand_total - t.total_payment - t.total_return > 0');
    }

}
