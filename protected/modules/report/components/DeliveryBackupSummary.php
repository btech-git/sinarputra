<?php

class DeliveryBackupSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'customer:resetScope',
            'employeeIdDriver:resetScope',
            'warehouse:resetScope',
            'admin:resetScope',
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
        $this->dataProvider->sort->attributes = array('t.transaction_date', 't.transaction_number');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $customerName) {
        $this->dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('customer.company', $customerName, true);
    }

}
