<?php

class ProductionPlanningMilingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('ppcMilingCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('ppcMilingEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('ppcMilingCreate') || Yii::app()->user->checkAccess('ppcMilingEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        $model = ProductionPlanningMilingHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($model) {
        if (isset($_POST['ProductionPlanningMilingHeader']))
            $model->header->attributes = $_POST['ProductionPlanningMilingHeader'];

        if (isset($_POST['ProductionPlanningMilingDetail'])) {
            foreach ($_POST['ProductionPlanningMilingDetail'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new ProductionPlanningMilingDetail();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['ProductionPlanningMilingDetail']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();

    }

    public function instantiate($id) {
        if (empty($id))
            $model = new ProductionPlanningMiling(new ProductionPlanningMilingHeader(), array());
        else {
            $header = $this->loadModel($id);
            $model = new ProductionPlanningMiling($header, $header->productionPlanningMilingDetails);
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
        $workOrderCuttingHeaderDataProvider = $workOrderCuttingHeader->searchForProductionPlanningMiling();

        $workOrderCuttingHeaderDataProvider->criteria->with = array(
            'saleHeader' => array(
                'with' => array(
                    'customer:resetScope'
                )
            )
        );
        $workOrderCuttingHeaderDataProvider->criteria->order = 't.id DESC';
        
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
        $workOrderReplacementHeaderDataProvider = $workOrderReplacementHeader->searchForProductionPlanningMiling();

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
        
        if (!empty($workOrderCuttingId))
            $model->addCuttingDetails($workOrderCuttingId);
        else
            $model->addReplacementDetails($workOrderReplacementId);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);
            
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('create', array(
            'model' => $model,
            'workOrderCutting' => $workOrderCutting,
            'workOrderReplacement' => $workOrderReplacement,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('production_planning_miling_header_id', $model->id);

        $detailsDataProvider = new CActiveDataProvider('ProductionPlanningMilingDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'model' => $model,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $this->render('memoMilling', array(
            'model' => $this->loadModel($id)
        ));
    }

    public function actionUpdate($id) {
        $model = $this->instantiate($id);
        $model->header->admin_id_updated = Yii::app()->user->id;
        $model->header->updated_datetime = date('Y-m-d H:i:s');
        
        $workOrderCutting = WorkOrderCuttingHeader::model()->findByPk($model->header->work_order_cutting_header_id);
        $workOrderReplacement = WorkOrderReplacementHeader::model()->findByPk($model->header->work_order_replacement_header_id);

        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);

            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('update', array(
            'model' => $model,
            'workOrderCutting' => $workOrderCutting,
            'workOrderReplacement' => $workOrderReplacement,
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new ProductionPlanningMilingHeader('search'), isset($_GET['ProductionPlanningMilingHeader']) ? $_GET['ProductionPlanningMilingHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $modelDataProvider = $model->search();
        $modelDataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader'
                )
            ),
            'workOrderReplacementHeader',
            'customer',
        );
        
		$modelDataProvider->criteria->addCondition("customer.company LIKE :company");
		$modelDataProvider->criteria->params[':company'] = "%{$customerCompany}%";

		$modelDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
		$modelDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $modelDataProvider->criteria->addCondition('t.is_inactive = 0');
        $modelDataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'customerCompany' => $customerCompany,
            'customerPurchaseNumber' => $customerPurchaseNumber,
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

    public function actionAjaxHtmlAddWorkOrder($id) {
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
            else if (isset($_POST['WorkOrderId']))
                $model->addDetail($_POST['WorkOrderId']);

            $this->renderPartial('_detail', array(
                'model' => $model
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveWorkOrder($id, $index) {
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