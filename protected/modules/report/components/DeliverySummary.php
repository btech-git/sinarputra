<?php

class DeliverySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'workOrderCuttingHeader:resetScope' => array(
                'with' => array(
                    'saleHeader:resetScope' => array(
                        'with' => array(
                            'customer:resetScope',
                            'employeeIdSalesman:resetScope'
                        ),
                    ),
                ),
            ),
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

    public function setupFilter($startDate, $endDate, $customerName) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('customer.company', $customerName, TRUE);
    }

}
