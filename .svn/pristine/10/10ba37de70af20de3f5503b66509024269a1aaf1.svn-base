<?php

class DepositController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('depositCreate')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('depositEdit')))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'ajaxHtmlAddPayment'
            || $filterChain->action->id === 'ajaxHtmlRemoveDetail'
            || $filterChain->action->id === 'ajaxJsonTotal'
            || $filterChain->action->id === 'view'
            || $filterChain->action->id === 'memo'
            || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('depositCreate') || Yii::app()->user->checkAccess('depositEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        $model = DepositHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($deposit) {
        if (isset($_POST['DepositHeader'])) {
            $deposit->header->attributes = $_POST['DepositHeader'];
        }
        if (isset($_POST['DepositDetail'])) {
            foreach ($_POST['DepositDetail'] as $i => $item) {
                if (isset($deposit->details[$i]))
                    $deposit->details[$i]->attributes = $item;
                else {
                    $detail = new DepositDetail();
                    $detail->attributes = $item;
                    $deposit->details[] = $detail;
                }
            }
            if (count($_POST['DepositDetail']) < count($deposit->details))
                array_splice($deposit->details, $i + 1);
        }
        else
            $deposit->details = array();
    }

    public function instantiate($id) {
        if (empty($id))
            $deposit = new Deposit(new DepositHeader(), array());
        else {
            $depositHeader = $this->loadModel($id);
            $deposit = new Deposit($depositHeader, $depositHeader->depositDetails);
        }

        return $deposit;
    }

    public function actionCreate() {
        $deposit = $this->instantiate(null);
        $deposit->header->date = date('Y-m-d');
        $deposit->header->admin_id = Yii::app()->user->id;
        $deposit->header->created_datetime = date('Y-m-d H:i:s');

        $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->with = array(
            'with' => 'accountCategory:resetScope'
        );

//        $deposit->generateCodeNumber(date('m'), date('y'));

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($deposit);
            $deposit->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($deposit->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($deposit->header->date)));
            
            if ($deposit->save(Yii::app()->db)) {
                Yii::app()->session['DepositMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $deposit->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'deposit' => $deposit,
            'account' => $account,
            'accountDataProvider' => $accountDataProvider
        ));
    }

    public function actionView($id) {
        $deposit = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('deposit_header_id', $deposit->id);
        $detailsDataProvider = new CActiveDataProvider('DepositDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'deposit' => $deposit,
            'detailsDataProvider' => $detailsDataProvider
        ));
    }

    public function actionMemo($id) {
        $deposit = $this->loadModel($id);

        $this->render('memo', array(
            'deposit' => $deposit
        ));
    }

    public function actionAdmin() {
        $deposit = Search::bind(new DepositHeader('search'), isset($_GET['DepositHeader']) ? $_GET['DepositHeader'] : array());

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $deposit->searchWithPaging();
        $dataProvider->criteria->condition = 't.is_inactive = 0';
        $dataProvider->criteria->with = array(
            'branch:',
        );

        $this->render('admin', array(
            'deposit' => $deposit,
            'dataProvider' => $dataProvider
        ));
    }

    public function actionUpdate($id) {
        $deposit = $this->instantiate($id);
        $deposit->header->admin_id_updated = Yii::app()->user->id;
        $deposit->header->updated_datetime = date('Y-m-d H:i:s');

        $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->with = array(
            'with' => 'accountCategory:resetScope'
        );

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($deposit);
            if ($deposit->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $deposit->header->id));
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('update', array(
            'deposit' => $deposit,
            'account' => $account,
            'accountDataProvider' => $accountDataProvider
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $depositHeader = $this->loadModel($id);
            
            if ($depositHeader !== null) {
                JournalAccounting::model()->deleteAllByAttributes(array(
                    'transaction_number' => $depositHeader->getCodeNumber(DepositHeader::CN_CONSTANT),
                    'transaction_type' => AccountingJournalHelper::DEPOSIT,
                ));

                $depositHeader->is_inactive = !$depositHeader->is_inactive;
                $depositHeader->update(array('is_inactive'));
                
                foreach ($depositHeader->depositDetails as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $detail->update(array('is_inactive'));
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $deposit = $this->instantiate($id);
            $this->loadState($deposit);

            $accountId = isset($_POST['AccountId']) ? $_POST['AccountId'] : '';
            if (!empty($accountId))
                $deposit->addDetail($accountId);

            $this->renderPartial('_detail', array(
                'deposit' => $deposit,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $deposit = $this->instantiate($id);
            $this->loadState($deposit);

            $deposit->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'deposit' => $deposit,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $deposit = $this->instantiate($id);

            $this->loadState($deposit);

            $object = array(
                'amount' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($deposit->details[$index], 'amount')),
                'grandTotal' => Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($deposit, 'grandTotal')),
            );

            echo CJSON::encode($object);
        }
    }

}