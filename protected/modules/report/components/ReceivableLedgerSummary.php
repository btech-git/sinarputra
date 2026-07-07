<?php

class ReceivableLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'employee',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 5000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('coa.code DESC');
        $this->dataProvider->criteria->order = 't.company ASC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $customerCompany) {
        $this->dataProvider->criteria->compare('t.company', $customerCompany, true);
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT customer_id 
            FROM " . ReceivableLedger::model()->tableName() . " 
            WHERE customer_id = t.id AND transaction_date BETWEEN :start_date AND :end_date
        ) AND t.is_inactive = 0");

        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
