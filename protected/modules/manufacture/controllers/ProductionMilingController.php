<?php

class ProductionMilingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('poMilingCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('poMilingEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('poMilingCreate') || Yii::app()->user->checkAccess('poMilingEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        $model = ProductionMilingHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($model) {
        if (isset($_POST['ProductionMilingHeader']))
            $model->header->attributes = $_POST['ProductionMilingHeader'];

        if (isset($_POST['ProductionMilingDetail'])) {
            foreach ($_POST['ProductionMilingDetail'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new ProductionMilingDetail();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['ProductionMilingDetail']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();

    }

    public function instantiate($id) {
        if (empty($id))
            $model = new ProductionMiling(new ProductionMilingHeader(), array());
        else {
            $header = $this->loadModel($id);
            $model = new ProductionMiling($header, $header->productionMilingDetails);
        }

        return $model;
    }

    public function actionProductionPlanningList() {
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        $workOrderOrdinal = isset($_GET['WorkOrderOrdinal']) ? $_GET['WorkOrderOrdinal'] : '';
        $workOrderMonth = isset($_GET['WorkOrderMonth']) ? $_GET['WorkOrderMonth'] : '';
        $workOrderYear = isset($_GET['WorkOrderYear']) ? $_GET['WorkOrderYear'] : '';

        $productionPlanningMilingHeader = Search::bind(new ProductionPlanningMilingHeader('search'), isset($_GET['ProductionPlanningMilingHeader']) ? $_GET['ProductionPlanningMilingHeader'] : '');
        $productionPlanningMilingHeaderDataProvider = $productionPlanningMilingHeader->searchForProductionMiling();

        $productionPlanningMilingHeaderDataProvider->criteria->with = array(
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
        $productionPlanningMilingHeaderDataProvider->criteria->order = 't.id DESC';

        if (!empty($customerCompany)) {
            $productionPlanningMilingHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $productionPlanningMilingHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }

        if (!empty($workOrderOrdinal)) {
            $productionPlanningMilingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_ordinal = :cn_ordinal');
            $productionPlanningMilingHeaderDataProvider->criteria->params[':cn_ordinal'] = $workOrderOrdinal;
        }
        if (!empty($workOrderMonth)) {
            $productionPlanningMilingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_month = :cn_month');
            $productionPlanningMilingHeaderDataProvider->criteria->params[':cn_month'] = $workOrderMonth;
        }
        if (!empty($workOrderYear)) {
            $productionPlanningMilingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_year = :cn_year');
            $productionPlanningMilingHeaderDataProvider->criteria->params[':cn_year'] = $workOrderYear;
        }

		$productionPlanningMilingHeaderDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
		$productionPlanningMilingHeaderDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $this->render('productionPlanningList', array(
            'productionPlanningMilingHeader' => $productionPlanningMilingHeader,
            'productionPlanningMilingHeaderDataProvider' => $productionPlanningMilingHeaderDataProvider,
            'customerCompany' => $customerCompany,
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
        $model->header->production_planning_miling_header_id = $productionPlanningId;
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
        $criteria->compare('production_miling_header_id', $model->id);

        $detailsDataProvider = new CActiveDataProvider('ProductionMilingDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'model' => $model,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $this->render('memo', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionUpdate($id) {
        $model = $this->instantiate($id);
        $model->header->admin_id_updated = Yii::app()->user->id;
        $model->header->updated_datetime = date('Y-m-d H:i:s');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);

            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('update', array(
            'model' => $model, false, true
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new ProductionMilingHeader('search'), isset($_GET['ProductionMilingHeader']) ? $_GET['ProductionMilingHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        $workOrderOrdinal = isset($_GET['WorkOrderOrdinal']) ? $_GET['WorkOrderOrdinal'] : '';
        $workOrderMonth = isset($_GET['WorkOrderMonth']) ? $_GET['WorkOrderMonth'] : '';
        $workOrderYear = isset($_GET['WorkOrderYear']) ? $_GET['WorkOrderYear'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $modelDataProvider = $model->search();
        $modelDataProvider->criteria->with = array(
            'productionPlanningMilingHeader' => array(
                'with' => array(
                    'workOrderCuttingHeader' => array(
                        'with' => array(
                            'saleHeader' => array(
                                'with' => array(
                                    'customer',
                                ),
                            ),
                        ),
                    ),
                    
                ),
            ),
        );
        
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
        
        if (!empty($customerPurchaseNumber)) {
            $modelDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
            $modelDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";
        }
        
        if (!empty($customerCompany)) {
            $modelDataProvider->criteria->addCondition("customer.company LIKE :company");
            $modelDataProvider->criteria->params[':company'] = "%{$customerCompany}%";
        }
        
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
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddProductionPlanning($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);

            $this->loadState($model);

            if (isset($_POST['selectedIds'])) {
                $ids = array();
                $ids = $_POST['selectedIds'];

                foreach ($ids as $id) {
                    $model->addDetail($id);
                }
            }
//            else if (isset($_POST['ProductionPlanningId']))
//                $model->addDetail($_POST['ProductionPlanningId']);

            $this->renderPartial('_detail', array(
                'model' => $model
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveProductionPlanning($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);

            $this->loadState($model);

            $model->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'model' => $model,
            ));
        }
    }

}