<?php

class DeliveryBackupController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deliveryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $deliveryBackup = $this->instantiate(null);
        $deliveryBackup->header->transaction_date = date('Y-m-d');
        $deliveryBackup->header->admin_id = Yii::app()->user->id;
        $deliveryBackup->header->created_datetime = date('Y-m-d H:i:s');
            
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($deliveryBackup);
            $deliveryBackup->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($deliveryBackup->header->transaction_date)), Yii::app()->dateFormatter->format('yy', strtotime($deliveryBackup->header->transaction_date)));
            
            if ($deliveryBackup->save(Yii::app()->db)) {
                Yii::app()->session['DeliveryMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $deliveryBackup->header->id));
            }
        }

        $this->render('create', array(
            'deliveryBackup' => $deliveryBackup,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $deliveryBackup = $this->instantiate($id);
        $deliveryBackup->header->admin_id_updated = Yii::app()->user->id;
        $deliveryBackup->header->updated_datetime = date('Y-m-d H:i:s');

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($deliveryBackup);
            
            if ($deliveryBackup->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $deliveryBackup->header->id));
            }
        }

        $this->render('update', array(
            'deliveryBackup' => $deliveryBackup,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $deliveryBackup = $this->loadModel($id);
            $deliveryBackup->delete(Yii::app()->db);

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionView($id) {
        $deliveryBackup = $this->loadModel($id);

        $this->render('view', array(
            'deliveryBackup' => $deliveryBackup,
        ));
    }

    public function actionMemo($id) {
        $deliveryBackup = $this->loadModel($id);

        $this->render('memo', array(
            'deliveryBackup' => $deliveryBackup,
        ));
    }

    public function actionAdmin() {
        $deliveryBackupHeader = Search::bind(new DeliveryBackupHeader('search'), isset($_GET['DeliveryBackupHeader']) ? $_GET['DeliveryBackupHeader'] : array());

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $deliveryBackupHeader->search();

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        }

        $dataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'deliveryBackupHeader' => $deliveryBackupHeader,
            'dataProvider' => $dataProvider,              
        ));
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['DeliveryBackupHeader']['customer_id'])) ? $_POST['DeliveryBackupHeader']['customer_id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_company' => CHtml::value($customer, 'company'),
                'customer_address_secondary' => CHtml::value($customer, 'address_secondary'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $deliveryBackup = $this->instantiate($id);
            $this->loadState($deliveryBackup);
            
            $detail = new DeliveryBackupDetail();
            $deliveryBackup->details[] = $detail;

            $this->renderPartial('_detail', array(
                'deliveryBackup' => $deliveryBackup,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($index, $id) {
        if (Yii::app()->request->isAjaxRequest) {
            $deliveryBackup = $this->instantiate($id);
            $this->loadState($deliveryBackup);
            $deliveryBackup->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'deliveryBackup' => $deliveryBackup,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $deliveryBackup = new DeliveryBackup(new DeliveryBackupHeader(), array());
        } else {
            $deliveryBackupHeader = $this->loadModel($id);
            $deliveryBackup = new DeliveryBackup($deliveryBackupHeader, $deliveryBackupHeader->deliveryBackupDetails);
        }

        return $deliveryBackup;
    }

    public function loadModel($id) {
        $model = DeliveryBackupHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    protected function loadState(&$deliveryBackup) {
        if (isset($_POST['DeliveryBackupHeader'])) {
            $deliveryBackup->header->attributes = $_POST['DeliveryBackupHeader'];
        }
        
        if (isset($_POST['DeliveryBackupDetail'])) {
            foreach ($_POST['DeliveryBackupDetail'] as $i => $item) {
                if (isset($deliveryBackup->details[$i])) {
                    $deliveryBackup->details[$i]->attributes = $item;
                } else {
                    $detail = new DeliveryBackupDetail();
                    $detail->attributes = $item;
                    $deliveryBackup->details[] = $detail;
                }
            }
            
            if (count($_POST['DeliveryBackupDetail']) < count($deliveryBackup->details)) {
                array_splice($deliveryBackup->details, $i + 1);
            }
        } else {
            $deliveryBackup->details = array();
        }
    }
}