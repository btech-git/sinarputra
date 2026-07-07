<?php

class JournalVoucherController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('finance')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $journalVoucherHeader = Search::bind(new JournalVoucherHeader('search'), isset($_GET['JournalVoucherHeader']) ? $_GET['JournalVoucherHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $journalVoucherSummary = new JournalVoucherSummary($journalVoucherHeader->search());
        $journalVoucherSummary->setupLoading();
        $journalVoucherSummary->setupPaging($pageSize, $currentPage);
        $journalVoucherSummary->setupSorting();
        $journalVoucherSummary->setupFilter($startDate, $endDate);

        $this->render('summary', array(
            'journalVoucherHeader' => $journalVoucherHeader,
            'journalVoucherSummary' => $journalVoucherSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

}
