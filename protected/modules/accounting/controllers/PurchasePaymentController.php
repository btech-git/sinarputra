<?php

class PurchasePaymentController extends Controller {

     public function filters() {
        return array(
			'access',
        );
    }
    
    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin'
            || $filterChain->action->id === 'memo'
            || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentCreate') || Yii::app()->user->checkAccess('purchasePaymentEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }
    
    public function loadModel($id) {
        $model = PurchasePaymentHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($model) {
        if (isset($_POST['PurchasePaymentHeader'])) {
            $model->header->attributes = $_POST['PurchasePaymentHeader'];
        }
        if (isset($_POST['PurchasePaymentDetail'])) {
            foreach ($_POST['PurchasePaymentDetail'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new PurchasePaymentDetail();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['PurchasePaymentDetail']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();
    }

    public function instantiate($id) {
        if (empty($id))
            $model = new PurchasePaymentComponent(new PurchasePaymentHeader(), array());
        else {
            $header = $this->loadModel($id);
            $model = new PurchasePaymentComponent($header, $header->purchasePaymentDetails);
        }

        return $model;
    }

    public function actionCreate() {
        $model = $this->instantiate(null);
        $model->header->date = date('Y-m-d');
        $model->header->admin_id = Yii::app()->user->id;
        $model->header->created_datetime = date('Y-m-d H:i:s');

        $purchaseReceiptHeader = Search::bind(new PurchaseReceiptHeader('search'), isset($_GET['PurchaseReceiptHeader']) ? $_GET['PurchaseReceiptHeader'] : '');
        $purchaseReceiptHeaderDataProvider = $purchaseReceiptHeader->searchForPurchasePayment();
        $purchaseReceiptHeaderDataProvider->criteria->with = array(
            'supplier:resetScope',
        );

        $supplierCompany = isset($_GET['SupplierCompany']) ? $_GET['SupplierCompany'] : '';
        if (!empty($supplierCompany)) {
            $purchaseReceiptHeaderDataProvider->criteria->addCondition('supplier.company LIKE :supplier_company');
            $purchaseReceiptHeaderDataProvider->criteria->params[':supplier_company'] = "%{$supplierCompany}%";
        }

        $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : '');
        $accountDataProvider = $account->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($model->header->date)));
            
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('create', array(
            'model' => $model,
            'purchaseReceiptHeader' => $purchaseReceiptHeader,
            'purchaseReceiptHeaderDataProvider' => $purchaseReceiptHeaderDataProvider,
            'supplierCompany' => $supplierCompany,
            'account' => $account,
            'accountDataProvider' => $accountDataProvider
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('purchase_payment_header_id', $model->id);
        $detailsDataProvider = new CActiveDataProvider('PurchasePaymentDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'model' => $model,
            'detailsDataProvider' => $detailsDataProvider
        ));
    }

    public function actionUpdate($id) {
        $model = $this->instantiate($id);
        $model->header->admin_id_updated = Yii::app()->user->id;
        $model->header->updated_datetime = date('Y-m-d H:i:s');

        $purchaseReceiptHeader = Search::bind(new PurchaseReceiptHeader('search'), isset($_GET['PurchaseReceiptHeader']) ? $_GET['PurchaseReceiptHeader'] : '');
        $purchaseReceiptHeaderDataProvider = $purchaseReceiptHeader->searchForPurchasePayment();
        $purchaseReceiptHeaderDataProvider->criteria->with = array(
            'supplier:resetScope',
        );

        $supplierCompany = isset($_GET['SupplierCompany']) ? $_GET['SupplierCompany'] : '';
        if (!empty($supplierCompany)) {
            $purchaseReceiptHeaderDataProvider->criteria->addCondition('supplier.company LIKE :supplier_company');
            $purchaseReceiptHeaderDataProvider->criteria->params[':supplier_company'] = "%{$supplierCompany}%";
        }

        $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : '');
        $accountDataProvider = $account->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);
            
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('update', array(
            'model' => $model,
            'purchaseReceiptHeader' => $purchaseReceiptHeader,
            'purchaseReceiptHeaderDataProvider' => $purchaseReceiptHeaderDataProvider,
            'account' => $account,
            'accountDataProvider' => $accountDataProvider,
            'supplierCompany' => $supplierCompany,
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new PurchasePaymentHeader, isset($_GET['PurchasePaymentHeader']) ? $_GET['PurchasePaymentHeader'] : '');
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->with = array(
            'purchaseReceiptHeader' => array(
                'with' => array(
                    'supplier:resetScope',                    
                ),
            ),
        );
//        $dataProvider->criteria->condition = 't.is_inactive = 0';
        
        $supplierCompany = isset($_GET['SupplierCompany']) ? $_GET['SupplierCompany'] : '';
        if (!empty($supplierCompany)) {
            $dataProvider->criteria->addCondition('supplier.company LIKE :supplier_company');
            $dataProvider->criteria->params[':supplier_company'] = "%{$supplierCompany}%";
        }

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'supplierCompany' => $supplierCompany,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            if ($model !== null) {
                $dbTransaction = Yii::app()->db->beginTransaction();
                try {
                    $valid = true;
                    foreach ($model->purchasePaymentDetails as $detail) {
                        $detail->is_inactive = ActiveRecord::INACTIVE;
                        $valid = $valid && $detail->update(array('is_inactive'));
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

    public function actionAjaxJsonPurchaseReceipt() {
        if (Yii::app()->request->isAjaxRequest) {
            $purchaseReceiptHeaderId = isset($_POST['PurchasePaymentHeader']['purchase_receipt_header_id']) ? $_POST['PurchasePaymentHeader']['purchase_receipt_header_id'] : '';
            $purchaseReceiptHeader = PurchaseReceiptHeader::model()->findByPk($purchaseReceiptHeaderId);

            $object = array(
                'purchaseReceiptNumber' => CHtml::encode($purchaseReceiptHeader->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT)),
                'purchaseReceiptDate' => CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($purchaseReceiptHeader, 'date'))),
                'purchaseReceiptSupplier' => CHtml::encode(CHtml::value($purchaseReceiptHeader, 'supplier.company')),
                'purchaseReceiptTotal' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseReceiptHeader, 'grand_total'))),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);
            $this->loadState($model);
            
            if (isset($_POST['AccountId']))
                $model->addDetail($_POST['AccountId']);

            $this->renderPartial('_detail', array(
                'model' => $model,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
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