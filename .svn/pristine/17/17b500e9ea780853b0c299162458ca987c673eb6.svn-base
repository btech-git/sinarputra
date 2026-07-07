<?php

class EmployeeTimesheetController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }
    
    public function actionSummary() {
        $employeeTimesheet = Search::bind(new EmployeeTimesheet('search'), isset($_GET['EmployeeTimesheet']) ? $_GET['EmployeeTimesheet'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
		$employeeName = (isset($_GET['EmployeeName'])) ? $_GET['EmployeeName'] : '';

        $employeeTimesheetSummary = new EmployeeTimesheetSummary($employeeTimesheet->search());
        $employeeTimesheetSummary->setupLoading();
        $employeeTimesheetSummary->setupPaging($pageSize, $currentPage);
        $employeeTimesheetSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
			'employeeName' => $employeeName,
        );
        $employeeTimesheetSummary->setupFilter($filters);

        $this->render('summary', array(
            'employeeTimesheet' => $employeeTimesheet,
            'employeeTimesheetSummary' => $employeeTimesheetSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
			'employeeName' => $employeeName,
        ));
    }

}
