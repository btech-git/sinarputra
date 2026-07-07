<?php

class QualityControlMilingSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => array(
                            'customer:resetScope',
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
        $this->dataProvider->sort->attributes = array('saleHeader.date', 'saleHeader.customer_id', 't.cn_ordinal');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        if (!empty($filters['startDate']) || !empty($filters['endDate'])) {
            $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
            $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
            $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }
        $this->dataProvider->criteria->compare('customer.name', $filters['customerName'], TRUE);
        $this->dataProvider->criteria->compare('t.is_inactive', 0);
    }
}
