<?php

class SaleInvoiceSamplePerYearController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $yearChoose = (isset($_GET['YearChoose'])) ? $_GET['YearChoose'] : '';

        $yearNow = date('Y');
        $yearList = array();
        for ($i = 5; $i >= 0; $i--) {
            $yearList[] = $yearNow - $i;
        }

        if ($yearChoose != NULL || $yearChoose != '') {
            $yearChoose = $yearList[$yearChoose];
        }

        $saleInvoiceSamplePerYearSummary = new SaleInvoiceSamplePerYearSummary($customer->search());
        $saleInvoiceSamplePerYearSummary->setupLoading();
        $saleInvoiceSamplePerYearSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSamplePerYearSummary->setupSorting();
        $filters = array(
//			'startDate' => $startDate,
//			'endDate' => $endDate,
            'customerName' => $customerName,
            'yearChoose' => $yearChoose,
        );
        $saleInvoiceSamplePerYearSummary->setupFilter($filters);

        $this->render('summary', array(
            'customer' => $customer,
            'saleInvoiceSamplePerYearSummary' => $saleInvoiceSamplePerYearSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
            'yearList' => $yearList,
            'yearChoose' => $yearChoose,
        ));
    }

}

