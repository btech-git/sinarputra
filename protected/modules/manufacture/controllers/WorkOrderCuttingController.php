<?php

class WorkOrderCuttingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('workOrderCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('workOrderEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('workOrderCreate') || Yii::app()->user->checkAccess('workOrderEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        $model = WorkOrderCuttingHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function instantiate($id) {
        if (empty($id)) {
            $model = new WorkOrderCuttingComponent(new WorkOrderCuttingHeader(), array(), array(), array(), array());
        }
        
        return $model;
    }

    public function loadState($model) {
        //load header
        if (isset($_POST['WorkOrderCuttingHeader']))
            $model->header->attributes = $_POST['WorkOrderCuttingHeader'];

        //load detail product
        if (isset($_POST['WorkOrderCuttingDetail'])) {
            foreach ($_POST['WorkOrderCuttingDetail'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new WorkOrderCuttingDetail();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['WorkOrderCuttingDetail']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();

    }

    public function loadStateOffCut($workOrderCutting) {
        //load detail offCart
//        $workOrderCutting->detailOffCuts = null;
        if (isset($_POST['WorkOrderCuttingDetailMaterial'])) {
            foreach ($_POST['WorkOrderCuttingDetailMaterial'] as $i => $item) {

                if (isset($workOrderCutting->detailOffCuts[$i]))
                    $workOrderCutting->detailOffCuts[$i]->attributes = $item;
                else {
                    $detail = new WorkOrderCuttingDetailMaterial();
                    $detail->attributes = $item;
                    $workOrderCutting->detailOffCuts[] = $detail;
                }
            }
            if (count($_POST['WorkOrderCuttingDetailMaterial']) < count($workOrderCutting->detailOffCuts))
                array_splice($workOrderCutting->detailOffCuts, $i + 1);
        }
        else
            $workOrderCutting->detailOffCuts = array();
    }

    public function loadStateUpdateHeader($model) {
        //load header
        if (isset($_POST['WorkOrderCuttingHeader']))
            $model->attributes = $_POST['WorkOrderCuttingHeader'];
    }

    public function loadStateUpdate($workOrderCuttingDetailComponent) {
        if (isset($_POST['WorkOrderCuttingDetailMaterial'])) {
            foreach ($_POST['WorkOrderCuttingDetailMaterial'] as $i => $item) {
                if (isset($workOrderCuttingDetailComponent->details[$i]))
                    $workOrderCuttingDetailComponent->details[$i]->attributes = $item;
            }
        }
    }

    public function actionSaleOrderList() {

        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $quotationOrdinal = isset($_GET['QuotationOrdinal']) ? $_GET['QuotationOrdinal'] : '';
        $quotationMonth = isset($_GET['QuotationMonth']) ? $_GET['QuotationMonth'] : '';
        $quotationYear = isset($_GET['QuotationYear']) ? $_GET['QuotationYear'] : '';

        $saleHeader = Search::bind(new SaleHeader, isset($_GET['SaleHeader']) ? $_GET['SaleHeader'] : '');
        $saleHeaderDataProvider = $saleHeader->searchWorkOrderCutting();

        $saleHeaderDataProvider->criteria->with = array(
            'customer:resetScope',
            'quotationHeader',
        );

        if (!empty($customerCompany))
            $saleHeaderDataProvider->criteria->compare('customer.company', $customerCompany, TRUE);

        if (!empty($quotationOrdinal) || !empty($quotationMonth) || !empty($quotationYear)) {
            $saleHeaderDataProvider->criteria->compare('quotationHeader.cn_ordinal', $quotationOrdinal, TRUE);
            $saleHeaderDataProvider->criteria->compare('quotationHeader.cn_month', $quotationMonth, TRUE);
            $saleHeaderDataProvider->criteria->compare('quotationHeader.cn_year', $quotationYear, TRUE);
        }

        $saleHeaderDataProvider->criteria->compare('t.is_inactive', 0);
        $saleHeaderDataProvider->criteria->order = 't.id DESC';

        $this->render('saleOrderList', array(
            'saleHeader' => $saleHeader,
            'saleHeaderDataProvider' => $saleHeaderDataProvider,
            'customerCompany' => $customerCompany,
            'quotationOrdinal' => $quotationOrdinal,
            'quotationMonth' => $quotationMonth,
            'quotationYear' => $quotationYear,
        ));
    }

    public function actionCreate($saleHeaderId) {
        $model = $this->instantiate(null);
        $model->header->date = date('Y-m-d');
        $model->generateCodeNumber(date('m'), date('y'));
        $model->header->admin_id = Yii::app()->user->id;
        $model->header->created_datetime = date('Y-m-d H:i:s');
        $model->header->sale_header_id = $saleHeaderId;
        $model->addWorkOrderCuttingDetails($saleHeaderId);
        
        if (isset($_POST['Next'])) {
            $this->loadState($model);
            unset(Yii::app()->session['WorkOrderCutting']);

            Yii::app()->session['WorkOrderCutting'] = $model;

            $this->redirect(array('loop', 'index' => 0));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionLoop($index) {
        $workOrderCutting = isset(Yii::app()->session['WorkOrderCutting']) ? Yii::app()->session['WorkOrderCutting'] : array();
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';

        $receiveDetail = Search::bind(new ReceiveDetail(), isset($_GET['ReceiveDetail']) ? $_GET['ReceiveDetail'] : '');
        $receiveDetailDataProvider = $receiveDetail->searchNotSelectedInCuttingDetailMaterial();

//        if (!empty($productName)) {
//            $receiveDetailDataProvider->criteria->addCondition('t.product_name LIKE :productName');
//            $receiveDetailDataProvider->criteria->params[':productName'] = "%$productName%";
//        }

//        $receiveDetailDataProvider->criteria->compare('t.serial_number', $receiveDetail->serial_number,true);
//        $receiveDetailDataProvider->criteria->compare('t.height', $receiveDetail->height);
//        $receiveDetailDataProvider->criteria->compare('t.width', $receiveDetail->width);
//        $receiveDetailDataProvider->criteria->compare('t.length', $receiveDetail->length);

        $receiveSerialNumber = isset($_GET['ReceiveSerialNumber']) ? $_GET['ReceiveSerialNumber'] : '';
        $workOrderCuttingDetailMaterial = Search::bind(new WorkOrderCuttingDetailMaterial(), isset($_GET['WorkOrderCuttingDetailMaterial']) ? $_GET['WorkOrderCuttingDetailMaterial'] : '');
        $workOrderCuttingDetailMaterialDataProvider = $workOrderCuttingDetailMaterial->searchProcessedStock();
        $workOrderCuttingDetailMaterialDataProvider->criteria->with = array('receiveDetail');
        
		$workOrderCuttingDetailMaterialDataProvider->criteria->addCondition("receiveDetail.serial_number LIKE :serial_number");
		$workOrderCuttingDetailMaterialDataProvider->criteria->params[':serial_number'] = "%{$receiveSerialNumber}%";

//        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.serial_number', $workOrderCuttingDetailMaterial->serial_number);
//        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.height', $workOrderCuttingDetailMaterial->height);
//        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.width', $workOrderCuttingDetailMaterial->width);
//        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.length', $workOrderCuttingDetailMaterial->length);

        $count = count($workOrderCutting->details);

        if ($count === 0)
            $this->redirect(array('saleOrderList'));
        
        $workOrderCutting->detailOffCuts = array();

        if (isset($_POST['Next'])) {

            $this->loadStateOffCut($workOrderCutting);
            $workOrderCutting->detailMaterials[$index] = $workOrderCutting->detailOffCuts;

            Yii::app()->session['WorkOrderCutting'] = $workOrderCutting;
            
            if ($index < $count - 1) {
                $this->redirect(array('loop', 'index' => ++$index));
            } else {
                $this->redirect(array('finish'));
            }
        } else if (isset($_POST['Back'])) {
            if ($index > 0) {
                $this->redirect(array('loop', 'index' => --$index));
            } else {
                $this->redirect(array('saleOrderList'));
            }
        }

        $this->render('loop', array(
            'model' => $workOrderCutting,
            'receiveDetail' => $receiveDetail,
            'receiveDetailDataProvider' => $receiveDetailDataProvider,
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
            'workOrderCuttingDetailMaterialDataProvider' => $workOrderCuttingDetailMaterialDataProvider,
            'index' => $index,
            'receiveSerialNumber' => $receiveSerialNumber,
        ));
    }

    public function actionFinish() {
        $workOrderCutting = isset(Yii::app()->session['WorkOrderCutting']) ? Yii::app()->session['WorkOrderCutting'] : $this->instantiate(null);

        $workOrderCutting->detailOffCuts = array();

        if ($workOrderCutting->save(Yii::app()->db)) {
            unset(Yii::app()->session['WorkOrderCutting']);
            $this->redirect(array('view', 'id' => $workOrderCutting->header->id));
        } else {
            $this->redirect(array('create', 'saleHeaderId' => $workOrderCutting->header->sale_header_id));
        }
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $salesman = Employee::model()->resetScope()->findByPk($model->saleHeader->employee_id_salesman);

        $criteria = new CDbCriteria;
        $criteria->compare('work_order_cutting_header_id', $model->id);

        $detailProductsDataProvider = new CActiveDataProvider('WorkOrderCuttingDetail', array(
            'criteria' => $criteria,
        ));

        $flagCutting = 0;
        foreach ($detailProductsDataProvider->getData() as $detail) {
            if ($detail->is_cut == 1) {
                $flagCutting = 1;
            }
        }
        
        $flagMachining = 0;
        $workOrderCuttingDetails = WorkOrderCuttingDetail::model()->findAllByAttributes(array('work_order_cutting_header_id' => $model->id));
        foreach ($workOrderCuttingDetails as $detail) {
            if ((int) $detail->is_miling === 1 || (int) $detail->is_grinding === 1 || (int) $detail->is_hardness === 1 || (int) $detail->is_annelying === 1 || (int) $detail->is_sidemiling === 1) {
                $flagMachining = 1;
                continue;
            }
        }

        $this->render('view', array(
            'model' => $model,
            'salesman' => $salesman,
            'detailProductsDataProvider' => $detailProductsDataProvider,
            'flagCutting' => $flagCutting,
            'flagMachining' => $flagMachining,
        ));
    }

    public function actionMemo($id) {
        $model = $this->loadModel($id);
        $salesman = Employee::model()->resetScope()->findByPk($model->saleHeader->employee_id_salesman);

        $this->render('memoMain', array(
            'model' => $model,
            'salesman' => $salesman,
        ));
    }

    public function actionMemoMiling($id) {
        $model = $this->loadModel($id);
        $salesman = Employee::model()->resetScope()->findByPk($model->saleHeader->employee_id_salesman);

        $this->render('memoMilling', array(
            'model' => $model,
            'salesman' => $salesman,
        ));
    }

    public function actionUpdateHeader($id) {
        $model = $this->loadModel($id);
        $model->admin_id_updated = Yii::app()->user->id;
        $model->updated_datetime = date('Y-m-d H:i:s');

        if (isset($_POST['Submit'])) {
            $this->loadStateUpdateHeader($model);
            
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateHeader', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($workOrderCuttingDetailId) {
        $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByPk($workOrderCuttingDetailId);
        $workOrderCuttingDetailComponent = new WorkOrderCuttingDetailComponent($workOrderCuttingDetail->workOrderCuttingDetailMaterials);
        
        if (isset($_POST['Submit'])) {
            $this->loadStateUpdate($workOrderCuttingDetailComponent);
            if ($workOrderCuttingDetailComponent->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $workOrderCuttingDetail->work_order_cutting_header_id));
        }

        $this->render('update', array(
            'workOrderCuttingDetail' => $workOrderCuttingDetail,
            'workOrderCuttingDetailComponent' => $workOrderCuttingDetailComponent,
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        $saleHeaderCnOrdinal = isset($_GET['SaleHeaderCnOrdinal']) ? $_GET['SaleHeaderCnOrdinal'] : '';
        $saleHeaderCnMonth = isset($_GET['SaleHeaderCnMonth']) ? $_GET['SaleHeaderCnMonth'] : '';
        $saleHeaderCnYear = isset($_GET['SaleHeaderCnYear']) ? $_GET['SaleHeaderCnYear'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $modelDataProvider = $model->searchWithPaging();
        $modelDataProvider->criteria->with = array(
            'saleHeader' => array(
                'with' => array(
                    'customer',
                ),
            ),
        );
        
        $modelDataProvider->criteria->addCondition("customer.company LIKE :company");
        $modelDataProvider->criteria->params[':company'] = "%{$customerCompany}%";

        $modelDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
        $modelDataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";

        $modelDataProvider->criteria->addCondition("saleHeader.cn_ordinal LIKE :cn_ordinal");
        $modelDataProvider->criteria->params[':cn_ordinal'] = "%{$saleHeaderCnOrdinal}%";

        $modelDataProvider->criteria->addCondition("saleHeader.cn_month LIKE :cn_month");
        $modelDataProvider->criteria->params[':cn_month'] = "%{$saleHeaderCnMonth}%";

        $modelDataProvider->criteria->addCondition("saleHeader.cn_year LIKE :cn_year");
        $modelDataProvider->criteria->params[':cn_year'] = "%{$saleHeaderCnYear}%";

        $modelDataProvider->criteria->addCondition('t.is_inactive = 0');
        $modelDataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'customerCompany' => $customerCompany,
            'customerPurchaseNumber' => $customerPurchaseNumber,
            'saleHeaderCnOrdinal' => $saleHeaderCnOrdinal,
            'saleHeaderCnMonth' => $saleHeaderCnMonth,
            'saleHeaderCnYear' => $saleHeaderCnYear,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            if ($model !== null) {
                $dbTransaction = Yii::app()->db->beginTransaction();
                try {
                    $valid = true;
                    if ($model->workOrderCuttingDetailProducts != NULL) {
                        foreach ($model->workOrderCuttingDetailProducts as $detail) {
                            $detail->is_inactive = ActiveRecord::INACTIVE;
                            $valid = $valid && $detail->update(array('is_inactive'));
                        }
                    }

                    if ($model->workOrderCuttingDetailServices != NULL) {
                        foreach ($model->workOrderCuttingDetailServices as $detail) {
                            $detail->is_inactive = ActiveRecord::INACTIVE;
                            $valid = $valid && $detail->update(array('is_inactive'));
                        }
                    }

                    $model->is_inactive = ActiveRecord::INACTIVE;
                    $valid = $valid && $model->update(array('is_inactive'));

                    if ($valid)
                        $dbTransaction->commit();
                    else
                        $dbTransaction->rollBack();
                } catch (Exception $e) {
                    $dbTransaction->rollback();
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);
            $this->loadStateOffcut($model);

            if (!empty($_POST['ReceiveDetailId']))
                $model->addDetail($_POST['ReceiveDetailId'], $index, 'receive', $_POST['RowQuantity']);
            else if (!empty($_POST['WorkOrderCuttingDetailMaterialId']))
                $model->addDetail($_POST['WorkOrderCuttingDetailMaterialId'], $index, 'work_order', $_POST['RowQuantity']);

            $this->renderPartial('_detailMaterial', array(
                'model' => $model
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetailMaterial($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);
            $this->loadStateOffcut($model);

            $model->removeDetailMaterial($index);

            $this->renderPartial('_detailMaterial', array(
                'model' => $model,
            ));
        }
    }

    public function actionAjaxJsonGetProductWeight($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);
            $this->loadStateOffCut($model);

            $model->detailOffCuts[$index]->weight = $model->detailOffCuts[$index]->weightCalculation;

            $object = array(
                'weight' => CHtml::encode(CHtml::value($model->detailOffCuts[$index], 'weightCalculation')),
            );

            echo CJSON::encode($object);
        }
    }
}