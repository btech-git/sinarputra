<?php

class MaterialReceivableSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'customer:resetScope',
            'employeeIdSalesman:resetScope',
        );
       
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 100 : $pageSize;
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
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->addCondition('t.grand_total - t.total_payment > 0');
        $this->dataProvider->criteria->addCondition('t.is_inactive = 0');
    }

}
