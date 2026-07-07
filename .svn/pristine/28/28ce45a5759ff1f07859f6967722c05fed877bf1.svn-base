<?php

class ManualDeliveryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionWorkOrderList() {
        $workOrderCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : '');
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';

        $workOrderCuttingHeaderDataProvider = $workOrderCuttingHeader->searchForDelivery();
        $workOrderCuttingHeaderDataProvider->criteria->with = array(
            'saleHeader' => array(
                'with' => array(
                    'customer:resetScope'
                )
            )
        );
        if (!empty($customerCompany)) {
            $workOrderCuttingHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $workOrderCuttingHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }
        if (!empty($customerPurchaseNumber)) {
            $workOrderCuttingHeaderDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
            $workOrderCuttingHeaderDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";
        }
        $workOrderCuttingHeaderDataProvider->criteria->order = 't.date DESC';

        $this->render('workOrderList', array(
            'workOrderCuttingHeader' => $workOrderCuttingHeader,
            'workOrderCuttingHeaderDataProvider' => $workOrderCuttingHeaderDataProvider,
            'customerCompany' => $customerCompany,
            'customerPurchaseNumber' => $customerPurchaseNumber,
        ));
    }

    public function actionCreate($workOrderCuttingId) {
        $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByPk($workOrderCuttingId);
        $delivery = $this->instantiate(null);
        $delivery->header->date = date('Y-m-d');
        $delivery->header->admin_id = Yii::app()->user->id;
        $delivery->header->created_datetime = date('Y-m-d H:i:s');
        $delivery->header->work_order_cutting_header_id = $workOrderCuttingId;
        $delivery->header->customer_address = $workOrderCuttingHeader->saleHeader->customer->address_main;

        if (!empty($workOrderCuttingId)) {
            $delivery->addCuttingDetails($workOrderCuttingId);
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($delivery);
            $delivery->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($delivery->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($delivery->header->date)));
            
            if ($delivery->save(Yii::app()->db)) {
                Yii::app()->session['DeliveryMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $delivery->header->id));
            }
        }

        $this->render('create', array(
            'delivery' => $delivery,
        ));
    }

    public function actionUpdate($id) {
        $delivery = $this->instantiate($id);
        $delivery->header->admin_id_updated = Yii::app()->user->id;
        $delivery->header->updated_datetime = date('Y-m-d H:i:s');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($delivery);
            
            if ($delivery->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $delivery->header->id));
        }

        $this->render('update', array(
            'delivery' => $delivery,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $delivery = $this->loadModel($id);
            if ($delivery !== null) {
                $delivery->is_inactive = ActiveRecord::INACTIVE;
                $delivery->update(array('is_inactive'));
                
                foreach ($delivery->manualDeliveryDetails as $detail) {
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

    public function actionView($id) {
        $delivery = $this->loadModel($id);

        $this->render('view', array(
            'delivery' => $delivery,
        ));
    }

    public function actionMemo($id) {
        $delivery = $this->loadModel($id);

        $this->render('memo', array(
            'delivery' => $delivery,
        ));
    }

    public function actionAdmin() {
        $delivery = Search::bind(new ManualDeliveryHeader('search'), isset($_GET['ManualDeliveryHeader']) ? $_GET['ManualDeliveryHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';

        $workOrderCnOrdinal = isset($_GET['WorkOrderCnOrdinal']) ? $_GET['WorkOrderCnOrdinal'] : '';   
        $workOrderCnMonth = isset($_GET['WorkOrderCnMonth']) ? $_GET['WorkOrderCnMonth'] : '';          
        $workOrderCnYear = isset($_GET['WorkOrderCnYear']) ? $_GET['WorkOrderCnYear'] : '';  
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $delivery->search();
        $dataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => array(
                            'customer:resetScope',
                        ),
                    ),
                ),
            ),
        );     

        if (!empty($customerCompany)) {
            $dataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $dataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }

        if (!empty($customerPurchaseNumber)) {
            $dataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
            $dataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";
        }
        
        $dataProvider->criteria->compare('workOrderCuttingHeader.cn_ordinal', $workOrderCnOrdinal, true);
        $dataProvider->criteria->compare('workOrderCuttingHeader.cn_month', $workOrderCnMonth, true);
        $dataProvider->criteria->compare('workOrderCuttingHeader.cn_year', $workOrderCnYear, true);
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }

        $dataProvider->criteria->addCondition('t.is_inactive = 0');
        $dataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'delivery' => $delivery,
            'dataProvider' => $dataProvider,
            'customerCompany' => $customerCompany,
            'customerPurchaseNumber' => $customerPurchaseNumber,         
            'workOrderCnOrdinal' => $workOrderCnOrdinal,   
            'workOrderCnMonth' => $workOrderCnMonth,   
            'workOrderCnYear' => $workOrderCnYear,
        ));
    }

    public function actionAjaxHtmlRemoveDetail($index, $id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);
            $this->loadState($delivery);

            $delivery->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'delivery' => $delivery,
            ));
        }
    }

    public function actionAjaxJsonGetTotalQuantityWeight($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);
            $this->loadState($delivery);

            $object = array(
                'totalQuantity' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $delivery->getTotalQuantity())),
                'totalWeight' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.0000', $delivery->getTotalWeight())),
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $delivery = new ManualDelivery(new ManualDeliveryHeader(), array());
        else {
            $deliveryHeader = $this->loadModel($id);
            $delivery = new ManualDelivery($deliveryHeader, $deliveryHeader->manualDeliveryDetails);
        }

        return $delivery;
    }

    public function loadModel($id) {
        $model = ManualDeliveryHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function loadState(&$delivery) {
        if (isset($_POST['ManualDeliveryHeader'])) {
            $delivery->header->attributes = $_POST['ManualDeliveryHeader'];
        }
        if (isset($_POST['ManualDeliveryDetail'])) {
            foreach ($_POST['ManualDeliveryDetail'] as $i => $item) {
                if (isset($delivery->details[$i]))
                    $delivery->details[$i]->attributes = $item;
                else {
                    $detail = new ManualDeliveryDetail();
                    $detail->attributes = $item;
                    $delivery->details[] = $detail;
                }
            }
            if (count($_POST['ManualDeliveryDetail']) < count($delivery->details))
                array_splice($delivery->details, $i + 1);
        }
        else
            $delivery->details = array();
    }
}
