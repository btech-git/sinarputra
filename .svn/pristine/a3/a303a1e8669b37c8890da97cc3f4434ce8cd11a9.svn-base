<?php

class JournalVoucherController extends Controller {

    public function filters() {
        return array(
//			'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create'
                || $filterChain->action->id === 'ajaxHtmlAddProduct'
                || $filterChain->action->id === 'ajaxHtmlAddAccount'
                || $filterChain->action->id === 'ajaxHtmlRemoveAccount'
                || $filterChain->action->id === 'ajaxJsonTotalCredit'
                || $filterChain->action->id === 'ajaxJsonTotalDebit'
                || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('adjustmentCreate')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $journalVoucher = $this->instantiate(null);
        $journalVoucher->header->date = date('Y-m-d');
        $journalVoucher->header->admin_id = Yii::app()->user->id;
        $journalVoucher->header->created_datetime = date('Y-m-d H:i:s');

        $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : array());
        $dataProvider = $account->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($journalVoucher);
            $journalVoucher->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($journalVoucher->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($journalVoucher->header->date)));

            if ($journalVoucher->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $journalVoucher->header->id));
        }

        $this->render('create', array(
            'journalVoucher' => $journalVoucher,
            'account' => $account,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionView($id) {
        $journalVoucher = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('journal_voucher_header_id', $journalVoucher->id);
        $detailsDataProvider = new CActiveDataProvider('JournalVoucherDetail', array(
                    'criteria' => $criteria,
                ));

        $detailsDataProvider->criteria->with = array('account:resetScope');

        $this->render('view', array(
            'journalVoucher' => $journalVoucher,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);

            $this->loadState($journalVoucher);

            if (isset($_POST['AccountId']))
                $journalVoucher->addDetail($_POST['AccountId']);

            $this->renderPartial('_detail', array(
                'journalVoucher' => $journalVoucher,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);

            $this->loadState($journalVoucher);

            $journalVoucher->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'journalVoucher' => $journalVoucher,
            ));
        }
    }

    public function actionAjaxJsonTotalDebit($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);

            $this->loadState($journalVoucher);

            $debit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalVoucher->details[$index], 'debit')));
            $totalDebit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalVoucher->totalDebit));

            echo CJSON::encode(array(
                'debit' => $debit,
                'totalDebit' => $totalDebit,
            ));
        }
    }

    public function actionAjaxJsonTotalCredit($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $journalVoucher = $this->instantiate($id);

            $this->loadState($journalVoucher);

            $credit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($journalVoucher->details[$index], 'credit')));
            $totalCredit = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $journalVoucher->totalCredit));

            echo CJSON::encode(array(
                'credit' => $credit,
                'totalCredit' => $totalCredit,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $journalVoucher = new JournalVoucher(new JournalVoucherHeader(), array());
        else {
            $journalVoucherHeader = $this->loadModel($id);
            $journalVoucher = new JournalVoucher($journalVoucherHeader, $journalVoucherHeader->journalVoucherDetails);
        }

        return $journalVoucher;
    }

    public function loadModel($id) {
        $model = JournalVoucherHeader::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function loadState($journalVoucher) {
        if (isset($_POST['JournalVoucherHeader'])) {
            $journalVoucher->header->attributes = $_POST['JournalVoucherHeader'];
        }
        if (isset($_POST['JournalVoucherDetail'])) {
            foreach ($_POST['JournalVoucherDetail'] as $item) {
                $detail = new JournalVoucherDetail();
                $detail->attributes = $item;
                $journalVoucher->details[] = $detail;
            }
        }
        else
            $journalVoucher->details = array();
    }

}
