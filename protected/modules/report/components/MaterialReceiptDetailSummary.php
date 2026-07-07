<?php

class MaterialReceiptDetailSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'materialInvoiceHeader',
            'materialReceiptHeader' => array(
                'with' => array(
                    'customer:resetScope',
                )
            ),
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
        $this->dataProvider->sort->attributes = array('materialReceiptHeader.date', 'customer.company');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $customerName) {
        $this->dataProvider->criteria->addBetweenCondition('materialReceiptHeader.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('customer.company', $customerName,TRUE);
    }

}
