<?php

class ProfitLossController extends Controller {

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
		
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $accounts = ProfitLossSummary::getAccountList();

        $sql = SqlGenerator::profitLoss();
        $params = array(':start_date' => $startDate, ':end_date' => $endDate);

        $row = Yii::app()->db->createCommand($sql)->queryRow(true, $params);

        $this->render('summary', array(
            'row' => $row,
            'accounts' => $accounts,
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
