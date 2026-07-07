<?php

class ProductionPlanningCuttingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('ppcCuttingCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('ppcCuttingEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('ppcCuttingCreate') || Yii::app()->user->checkAccess('ppcCuttingEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        $model = ProductionPlanningCuttingHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function loadState(&$model) {
        if (isset($_POST['ProductionPlanningCuttingHeader']))
            $model->header->attributes = $_POST['ProductionPlanningCuttingHeader'];

        if (isset($_POST['ProductionPlanningCuttingDetail'])) {
            foreach ($_POST['ProductionPlanningCuttingDetail'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new ProductionPlanningCuttingDetail();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['ProductionPlanningCuttingDetail']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();
    }

    public function instantiate($id) {
        if (empty($id))
            $model = new ProductionPlanningCutting(new ProductionPlanningCuttingHeader(), array());
        else {
            $header = $this->loadModel($id);
            $model = new ProductionPlanningCutting($header, $header->productionPlanningCuttingDetails);
        }

        return $model;
    }

    public function actionWorkOrderList() {
        $customerCompanyCutting = isset($_GET['CustomerCompanyCutting']) ? $_GET['CustomerCompanyCutting'] : '';
        $customerCompanyReplacement = isset($_GET['CustomerCompanyReplacement']) ? $_GET['CustomerCompanyReplacement'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        $workOrderCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : '');
        $workOrderCuttingHeaderDataProvider = $workOrderCuttingHeader->searchForProductionPlanningCutting();

        $workOrderCuttingHeaderDataProvider->criteria->with = array(
            'saleHeader' => array(
                'with' => array(
                    'customer:resetScope'
                )
            )
        );
        $workOrderCuttingHeaderDataProvider->criteria->order = 't.date DESC';
        
        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $workOrderCuttingHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }        
        
        if (!empty($customerCompanyCutting)) {
            $workOrderCuttingHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $workOrderCuttingHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompanyCutting}%";
        }

		$workOrderCuttingHeaderDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
		$workOrderCuttingHeaderDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $workOrderReplacementHeader = Search::bind(new WorkOrderReplacementHeader('search'), isset($_GET['WorkOrderReplacementHeader']) ? $_GET['WorkOrderReplacementHeader'] : '');
        $workOrderReplacementHeaderDataProvider = $workOrderReplacementHeader->searchForProductionPlanningReplacement();

        $workOrderReplacementHeaderDataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => array(
                            'customer:resetScope'
                        )
                    )
                )
            )
        );
        $workOrderReplacementHeaderDataProvider->criteria->order = 't.date DESC';
        
        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $workOrderReplacementHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }        
        
        if (!empty($customerCompanyReplacement)) {
            $workOrderReplacementHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $workOrderReplacementHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompanyReplacement}%";
        }

        $this->render('workOrderList', array(
            'workOrderCuttingHeader' => $workOrderCuttingHeader,
            'workOrderCuttingHeaderDataProvider' => $workOrderCuttingHeaderDataProvider,
            'customerCompanyCutting' => $customerCompanyCutting,
            'workOrderReplacementHeader' => $workOrderReplacementHeader,
            'workOrderReplacementHeaderDataProvider' => $workOrderReplacementHeaderDataProvider,
            'customerCompanyReplacement' => $customerCompanyReplacement,
            'customerPurchaseNumber' => $customerPurchaseNumber,
        ));
    }

    public function actionCreate($workOrderCuttingId, $workOrderReplacementId) {
        $model = $this->instantiate(null);
        $workOrderCutting = WorkOrderCuttingHeader::model()->findByPk($workOrderCuttingId);
        $workOrderReplacement = WorkOrderReplacementHeader::model()->findByPk($workOrderReplacementId);
        
        $model->header->date = date('Y-m-d');
        $model->generateCodeNumber(date('m'), date('y'));
        $model->header->admin_id = Yii::app()->user->id;
        $model->header->created_datetime = date('Y-m-d H:i:s');
        $model->header->work_order_cutting_header_id = $workOrderCuttingId;
        $model->header->work_order_replacement_header_id = $workOrderReplacementId;
        $model->header->customer_id = empty($workOrderCuttingId) ? $workOrderReplacement->workOrderCuttingHeader->saleHeader->customer_id : $workOrderCutting->saleHeader->customer_id;
        
//        if (!isset($_POST['Submit'])) {
        if (!empty($workOrderCuttingId))
            $model->addCuttingDetails($workOrderCuttingId);
        else
            $model->addReplacementDetails($workOrderReplacementId);
//        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);
            
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('create', array(
            'model' => $model
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('production_planning_cutting_header_id', $model->id);

        $detailsDataProvider = new CActiveDataProvider('ProductionPlanningCuttingDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'model' => $model,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $model = $this->loadModel($id);

        $this->render('memo', array(
            'model' => $model,
        ));
    }

    public function actionMemoMiling($id) {
        $model = $this->loadModel($id);

        $this->render('memoMilling', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->instantiate($id);
        $model->header->admin_id_updated = Yii::app()->user->id;
        $model->header->updated_datetime = date('Y-m-d H:i:s');

        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';

        $workOrderCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : '');
        $workOrderCuttingHeaderDataProvider = $workOrderCuttingHeader->search();
        $workOrderCuttingHeaderDataProvider->criteria->addCondition(
            't.id NOT IN (
                SELECT work_order_cutting_header_id
                FROM ' . $model->header->tableName() . '
			)
			AND t.is_inactive = 0'
        );

        if (!empty($customerId)) {
            $workOrderCuttingHeaderDataProvider->criteria->with = array('saleHeader');

            $workOrderCuttingHeaderDataProvider->criteria->addCondition('saleHeader.customer_id = :customer_id');
            $workOrderCuttingHeaderDataProvider->criteria->params[':customer_id'] = $customerId;
            $workOrderCuttingHeaderDataProvider->criteria->compare('saleHeader.customer_id', $customerId);
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);

            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('update', array(
            'model' => $model,
            'workOrderCuttingHeader' => $workOrderCuttingHeader,
            'workOrderCuttingHeaderDataProvider' => $workOrderCuttingHeaderDataProvider,
            'customerId' => $customerId,
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new ProductionPlanningCuttingHeader('search'), isset($_GET['ProductionPlanningCuttingHeader']) ? $_GET['ProductionPlanningCuttingHeader'] : array());
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        $workOrderCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : '');
        $workOrderReplacementHeader = Search::bind(new WorkOrderReplacementHeader('search'), isset($_GET['WorkOrderReplacementHeader']) ? $_GET['WorkOrderReplacementHeader'] : '');

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $modelDataProvider = $model->searchWithPaging();
        $modelDataProvider->criteria->with = array(
            'workOrderReplacementHeader',
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => array(
                            'customer:resetScope'
                        )
                    )
                )
            )
        );

        if (!empty($customerId)) {
            $modelDataProvider->criteria->addCondition('saleHeader.customer_id = :customer_id');
            $modelDataProvider->criteria->params[':customer_id'] = $customerId;
            $modelDataProvider->criteria->compare('saleHeader.customer_id', $customerId);
        }
        if (!empty($workOrderCuttingHeader)) {
            $modelDataProvider->criteria->compare('workOrderCuttingHeader.cn_ordinal', $workOrderCuttingHeader->cn_ordinal);
            $modelDataProvider->criteria->compare('workOrderCuttingHeader.cn_month', $workOrderCuttingHeader->cn_month);
            $modelDataProvider->criteria->compare('workOrderCuttingHeader.cn_year', $workOrderCuttingHeader->cn_year);
        }

		$modelDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
		$modelDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $modelDataProvider->criteria->addCondition('t.is_inactive = 0');
        $modelDataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'customerId' => $customerId,
            'workOrderCuttingHeader' => $workOrderCuttingHeader,
            'workOrderReplacementHeader' => $workOrderReplacementHeader,
            'customerPurchaseNumber' => $customerPurchaseNumber,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);
            $model->delete(Yii::app()->db);

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
}