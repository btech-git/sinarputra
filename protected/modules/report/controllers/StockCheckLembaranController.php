<?php

class StockCheckLembaranController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockCheck')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $workOrderCuttingDetailMaterial = Search::bind(new WorkOrderCuttingDetailMaterial('search'), isset($_GET['WorkOrderCuttingDetailMaterial']) ? $_GET['WorkOrderCuttingDetailMaterial'] : array());
        $serialNumber = isset($_GET['SerialNumber']) ? $_GET['SerialNumber'] : '';

       
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
    
        $stockCheckLembaranSummary = new StockCheckLembaranSummary($workOrderCuttingDetailMaterial->search());
        $stockCheckLembaranSummary->setupLoading();
        $stockCheckLembaranSummary->setupPaging($pageSize, $currentPage);
        $stockCheckLembaranSummary->setupSorting();
        $stockCheckLembaranSummary->setupFilter($serialNumber);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($stockCheckLembaranSummary);
        }

        $this->render('summary', array(
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
            'stockCheckLembaranSummary' => $stockCheckLembaranSummary,
            'currentSort' => $currentSort,
            'serialNumber' => $serialNumber,
            
        ));
    }
}
