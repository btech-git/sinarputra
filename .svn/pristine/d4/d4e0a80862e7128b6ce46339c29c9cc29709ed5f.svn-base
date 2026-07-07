<?php

class EmployeeTimesheetSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {

		$this->dataProvider->criteria->select = 't.*';
		$this->dataProvider->criteria->join = '
			JOIN '. Employee::model()->tableName(). ' e ON e.id = t.employee_id
		';
		
//		$this->dataProvider->criteria->group = 't.employee_id';
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.date');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
		$this->dataProvider->criteria->compare('e.name', $filters['employeeName'],TRUE);
    }

  

}
