<?php

class DeliveryManualSummary extends CComponent {

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
                        ),
                    ),
                ),
            ),
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
//        $this->dataProvider->sort->attributes = array('t.date ASC');
        $this->dataProvider->criteria->order = 't.date ASC, t.id ASC';
    }

    public function setupFilter($startDate, $endDate, $customerName) {
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('customer.company', $customerName, true);
    }

}
