<?php

class BalanceSheetController extends Controller
{
	public function filters()
	{
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
	
	public function actionSummary()
	{
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
		$startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
		$endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
		
		$accountCategories = AccountCategory::model()->findAll();

		$this->render('summary', array(
			'accountCategories' => $accountCategories,
			'startDate' => $startDate,
			'endDate' => $endDate,
		));
	}     
}
