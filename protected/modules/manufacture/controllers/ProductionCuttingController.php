<?php

class ProductionCuttingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('poCuttingCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('poCuttingEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('poCuttingCreate') || Yii::app()->user->checkAccess('poCuttingEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        $model = ProductionCuttingHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($model) {
        if (isset($_POST['ProductionCuttingHeader']))
            $model->header->attributes = $_POST['ProductionCuttingHeader'];

        if (isset($_POST['ProductionCuttingDetail'])) {
            foreach ($_POST['ProductionCuttingDetail'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new ProductionCuttingDetail();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['ProductionCuttingDetail']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();
    }

    public function instantiate($id) {
        if (empty($id))
            $model = new ProductionCutting(new ProductionCuttingHeader(), array());
        else {
            $header = $this->loadModel($id);
            $model = new ProductionCutting($header, $header->productionCuttingDetails);
        }

        return $model;
    }

    public function actionProductionPlanningList() {
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerCompanyReplacement = isset($_GET['CustomerCompanyReplacement']) ? $_GET['CustomerCompanyReplacement'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        $workOrderOrdinal = isset($_GET['WorkOrderOrdinal']) ? $_GET['WorkOrderOrdinal'] : '';
        $workOrderMonth = isset($_GET['WorkOrderMonth']) ? $_GET['WorkOrderMonth'] : '';
        $workOrderYear = isset($_GET['WorkOrderYear']) ? $_GET['WorkOrderYear'] : '';

        $productionPlanningCuttingHeader = Search::bind(new ProductionPlanningCuttingHeader('search'), isset($_GET['ProductionPlanningCuttingHeader']) ? $_GET['ProductionPlanningCuttingHeader'] : '');
        $productionPlanningCuttingHeaderDataProvider = $productionPlanningCuttingHeader->searchForProductionCutting();

        $productionPlanningCuttingHeaderDataProvider->criteria->with = array(
            'customer:resetScope',
            'workOrderReplacementHeader',
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader'
                )
            ),
        );
        $productionPlanningCuttingHeaderDataProvider->criteria->order = 't.id DESC';

        if (!empty($customerCompany)) {
            $productionPlanningCuttingHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $productionPlanningCuttingHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }
        
        if (!empty($workOrderOrdinal)) {
            $productionPlanningCuttingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_ordinal = :cn_ordinal');
            $productionPlanningCuttingHeaderDataProvider->criteria->params[':cn_ordinal'] = $workOrderOrdinal;
        }
        if (!empty($workOrderMonth)) {
            $productionPlanningCuttingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_month = :cn_month');
            $productionPlanningCuttingHeaderDataProvider->criteria->params[':cn_month'] = $workOrderMonth;
        }
        if (!empty($workOrderYear)) {
            $productionPlanningCuttingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_year = :cn_year');
            $productionPlanningCuttingHeaderDataProvider->criteria->params[':cn_year'] = $workOrderYear;
        }

		$productionPlanningCuttingHeaderDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
		$productionPlanningCuttingHeaderDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $productionPlanningReplacementHeader = Search::bind(new ProductionPlanningCuttingHeader('search'), isset($_GET['ProductionPlanningCuttingHeader']) ? $_GET['ProductionPlanningCuttingHeader'] : '');
        $productionPlanningReplacementHeaderDataProvider = $productionPlanningReplacementHeader->searchForProductionCuttingReplacement();

        $productionPlanningReplacementHeaderDataProvider->criteria->with = array(
            'customer:resetScope',
            'workOrderCuttingHeader',
            'workOrderReplacementHeader',
        );
        $productionPlanningReplacementHeaderDataProvider->criteria->order = 't.id DESC';

        if (!empty($customerCompanyReplacement)) {
            $productionPlanningReplacementHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $productionPlanningReplacementHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompanyReplacement}%";
        }

        $this->render('productionPlanningList', array(
            'productionPlanningCuttingHeader' => $productionPlanningCuttingHeader,
            'productionPlanningCuttingHeaderDataProvider' => $productionPlanningCuttingHeaderDataProvider,
            'customerCompany' => $customerCompany,
            'productionPlanningReplacementHeader' => $productionPlanningReplacementHeader,
            'productionPlanningReplacementHeaderDataProvider' => $productionPlanningReplacementHeaderDataProvider,
            'customerCompanyReplacement' => $customerCompanyReplacement,
            'customerPurchaseNumber' => $customerPurchaseNumber,
            'workOrderOrdinal' => $workOrderOrdinal,
            'workOrderMonth' => $workOrderMonth,
            'workOrderYear' => $workOrderYear,
        ));
    }

    public function actionCreate($productionPlanningId) {
        $model = $this->instantiate(null);
        $model->header->date = date('Y-m-d');
        $model->header->time = date('H:i:s');
        $model->generateCodeNumber(date('m'), date('y'));
        $model->header->admin_id = Yii::app()->user->id;
        $model->header->created_datetime = date('Y-m-d H:i:s');
        $model->header->production_planning_cutting_header_id = $productionPlanningId;
        $model->addDetails($productionPlanningId);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);

            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('create', array(
            'model' => $model, false, true
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('production_cutting_header_id', $model->id);

        $detailsDataProvider = new CActiveDataProvider('ProductionCuttingDetail', array(
            'criteria' => $criteria,
        ));

        $qualityControlsDataProvider = new CActiveDataProvider('QualityControlCuttingHeader', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'model' => $model,
            'detailsDataProvider' => $detailsDataProvider,
            'qualityControlsDataProvider' => $qualityControlsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $this->render('memoMain', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionUpdate($id) {
        $model = $this->instantiate($id);
        $model->header->admin_id_updated = Yii::app()->user->id;
        $model->header->updated_datetime = date('Y-m-d H:i:s');

        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';

        $productionPlanningCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : '');
        $productionPlanningCuttingHeaderDataProvider = $productionPlanningCuttingHeader->search();
        $productionPlanningCuttingHeaderDataProvider->criteria->addCondition(
            "t.id NOT IN (
                SELECT work_order_cutting_header_id
                FROM " . ProductionPlanningCuttingHeader::model()->tableName() . "
            ) AND t.is_inactive = 0"
        );

        if (!empty($customerId)) {
            $productionPlanningCuttingHeaderDataProvider->criteria->with = array('saleHeader');

            $productionPlanningCuttingHeaderDataProvider->criteria->addCondition('saleHeader.customer_id = :customer_id');
            $productionPlanningCuttingHeaderDataProvider->criteria->params[':customer_id'] = $customerId;
            $productionPlanningCuttingHeaderDataProvider->criteria->compare('saleHeader.customer_id', $customerId);
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);

            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('create', array(
            'model' => $model,
            'workOrderCuttingHeader' => $productionPlanningCuttingHeader,
            'workOrderCuttingHeaderDataProvider' => $productionPlanningCuttingHeaderDataProvider,
            'customerId' => $customerId,
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new ProductionCuttingHeader('search'), isset($_GET['ProductionCuttingHeader']) ? $_GET['ProductionCuttingHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        $workOrderOrdinal = isset($_GET['WorkOrderOrdinal']) ? $_GET['WorkOrderOrdinal'] : '';
        $workOrderMonth = isset($_GET['WorkOrderMonth']) ? $_GET['WorkOrderMonth'] : '';
        $workOrderYear = isset($_GET['WorkOrderYear']) ? $_GET['WorkOrderYear'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $modelDataProvider = $model->searchWithPaging();
        $modelDataProvider->criteria->with = array(
            'productionPlanningCuttingHeader' => array(
                'with' => array(
                    'workOrderCuttingHeader' => array(
                        'with' => array(
                            'saleHeader' => array(
                                'with' => array(
                                    'customer:resetScope'
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );

        if (!empty($customerCompany)) {
            $modelDataProvider->criteria->addCondition('customer.company = :customer_company');
            $modelDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }
        if (!empty($workOrderOrdinal)) {
            $modelDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_ordinal = :cn_ordinal');
            $modelDataProvider->criteria->params[':cn_ordinal'] = $workOrderOrdinal;
        }
        if (!empty($workOrderMonth)) {
            $modelDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_month = :cn_month');
            $modelDataProvider->criteria->params[':cn_month'] = $workOrderMonth;
        }
        if (!empty($workOrderYear)) {
            $modelDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_year = :cn_year');
            $modelDataProvider->criteria->params[':cn_year'] = $workOrderYear;
        }

        $modelDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
        $modelDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $modelDataProvider->criteria->addCondition('t.is_inactive = 0');
        $modelDataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'customerCompany' => $customerCompany,
            'customerPurchaseNumber' => $customerPurchaseNumber,
            'workOrderOrdinal' => $workOrderOrdinal,
            'workOrderMonth' => $workOrderMonth,
            'workOrderYear' => $workOrderYear,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);
            $model->delete(Yii::app()->db);

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}