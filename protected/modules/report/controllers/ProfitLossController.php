<?php

class ProfitLossController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('finance'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $profitLossCoaReport = Account::getProfitLossCoaReport();
        $profitLossLedgerReport = JournalAccounting::getProfitLossLedgerReport($startDate, $endDate);
        
        $profitLossReportData = array();
        foreach ($profitLossCoaReport as $profitLossCoaReportItem) {
            $profitLossReportData[$profitLossCoaReportItem['code']]['id'] = $profitLossCoaReportItem['id'];
            $profitLossReportData[$profitLossCoaReportItem['code']]['name'] = $profitLossCoaReportItem['name'];
            $profitLossReportData[$profitLossCoaReportItem['code']]['parent_code'] = $profitLossCoaReportItem['parent_code'];
            $profitLossReportData[$profitLossCoaReportItem['code']]['level'] = 1;
        }
        foreach ($profitLossCoaReport as $profitLossCoaReportItem) {
            $coaCode = $profitLossCoaReportItem['code'];
            $currentCoaCode = $coaCode;
            while (isset($profitLossReportData[$currentCoaCode]) && $profitLossReportData[$currentCoaCode]['parent_code'] !== null) {
                $profitLossReportData[$coaCode]['level']++;
                $currentCoaCode = $profitLossReportData[$currentCoaCode]['parent_code'];
            }
        }
        foreach ($profitLossLedgerReport as $profitLossLedgerReportItem) {
            $profitLossReportData[$profitLossLedgerReportItem['account_code']]['balance'] = $profitLossLedgerReportItem['balance'];
        }
        
        $accountGroupSums = array();
        foreach ($profitLossReportData as $coaCode => $profitLossReportDataItem) {
            if (!isset($accountGroupSums[$coaCode[0]])) {
                $accountGroupSums[$coaCode[0]] = '0.00';
            }
            $balance = isset($profitLossReportDataItem['balance']) ? $profitLossReportDataItem['balance'] : '0.00';
            $accountGroupSums[$coaCode[0]] += $balance;
        }
        
        $this->render('summary', array(
            'profitLossReportData' => $profitLossReportData,
            'accountGroupSums' => $accountGroupSums,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionReceiveAjaxData() {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveId = (isset($_POST['ReceiveId'])) ? $_POST['ReceiveId'] : '';
            $receive = ReceiveHeader::model()->findByPk($receiveId);

            $object = array(
                'receive_header_number' => CHtml::value($receive, 'number'),
                'supplier_name' => CHtml::value($receive, 'supplier.name'),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateDataAjax() {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveId = (isset($_POST['ReceiveId'])) ? $_POST['ReceiveId'] : '';

            $sql = SqlGenerator::profitLoss(empty($receiveId));

            $rows = Yii::app()->db->createCommand($sql)->queryRow(true, array(':receive_id' => $receiveId));

            $this->renderPartial('_report', array(
                'rows' => $rows,
            ));
        }
    }

}
