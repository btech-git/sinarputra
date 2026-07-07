<?php

class ManualSaleReceiptController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleReceiptCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('saleReceiptEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin'
                || $filterChain->action->id === 'ajaxHtmlRemoveDetail' 
                || $filterChain->action->id === 'ajaxHtmlAddSaleInvoice'
                || $filterChain->action->id === 'ajaxJsonCustomer'
                || $filterChain->action->id === 'memo' 
                || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $saleReceipt = $this->instantiate(null);
        $saleReceipt->header->date = date('Y-m-d');
        $saleReceipt->header->due_date = date('Y-m-d');
        $saleReceipt->header->admin_id = Yii::app()->user->id;
        $saleReceipt->header->created_datetime = date('Y-m-d H:i:s');

        $saleInvoice = Search::bind(new ManualSaleInvoiceHeader('search'), isset($_GET['ManualSaleInvoiceHeader']) ? $_GET['ManualSaleInvoiceHeader'] : array());
        $saleInvoiceDataProvider = $saleInvoice->searchForSaleReceipt();

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        $customerId = isset($_GET['ManualSaleReceiptHeader']['customer_id']) ? $_GET['ManualSaleReceiptHeader']['customer_id'] : '';

        $saleInvoiceDataProvider->criteria->with = array(
            'customer'
//            'workOrderCuttingHeader' => array(
//                'with' => array(
//                    'saleHeader' => array(
//                        'with' => 
//                    ),
//                ),
//            ),
        );

        if (!empty($customerId)) {
            $saleInvoiceDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $saleInvoiceDataProvider->criteria->params[':customer_id'] = $customerId;
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleReceipt);
			$saleReceipt->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($saleReceipt->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($saleReceipt->header->date)));
            
            if ($saleReceipt->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $saleReceipt->header->id));
        }

        $this->render('create', array(
            'saleReceipt' => $saleReceipt,
            'saleInvoice' => $saleInvoice,
            'saleInvoiceDataProvider' => $saleInvoiceDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $saleReceipt = $this->instantiate($id);
        $saleReceipt->header->admin_id_updated = Yii::app()->user->id;
        $saleReceipt->header->updated_datetime = date('Y-m-d H:i:s');
        
        $saleInvoice = Search::bind(new ManualSaleInvoiceHeader('search'), isset($_GET['ManualSaleInvoiceHeader']) ? $_GET['ManualSaleInvoiceHeader'] : array());
        $saleInvoiceDataProvider = $saleInvoice->searchForSaleReceipt();

        $saleInvoiceDataProvider->criteria->with = array('customer');

        if (!empty($saleReceipt->header->customer_id)) {
            $saleInvoiceDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $saleInvoiceDataProvider->criteria->params[':customer_id'] = $saleReceipt->header->customer_id;
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleReceipt);
            
            if ($saleReceipt->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $saleReceipt->header->id));
        }

        $this->render('update', array(
            'saleReceipt' => $saleReceipt,
            'saleInvoice' => $saleInvoice,
            'saleInvoiceDataProvider' => $saleInvoiceDataProvider,
        ));
    }

    public function actionView($id) {
        $saleReceipt = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('manual_sale_receipt_header_id', $saleReceipt->id);
        $detailsDataProvider = new CActiveDataProvider('ManualSaleReceiptDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'saleReceipt' => $saleReceipt,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $saleReceipt = $this->loadModel($id);

        $this->render('memo', array(
            'saleReceipt' => $saleReceipt
        ));
    }

    public function actionAdmin() {
        $saleReceipt = Search::bind(new ManualSaleReceiptHeader('search'), isset($_GET['ManualSaleReceiptHeader']) ? $_GET['ManualSaleReceiptHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $saleReceipt->search();
        $dataProvider->criteria->with = array('customer:resetScope');

        $dataProvider->criteria->addCondition("customer.company LIKE :company");
        $dataProvider->criteria->params[':company'] = "%{$customerCompany}%";

        $dataProvider->criteria->addCondition('t.is_inactive = 0');
        $dataProvider->criteria->order = 't.id DESC';
        
        $this->render('admin', array(
            'saleReceipt' => $saleReceipt,
            'dataProvider' => $dataProvider,
            'customerCompany' => $customerCompany,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $saleReceiptHeader = $this->instantiate($id);
            if ($saleReceiptHeader !== null) {
                if ($saleReceiptHeader->header->manualSalePaymentHeaders != NULL) {
                    Yii::app()->user->setFlash('message', 'This Transaction Has Been Used as Reference');
                } else {
                    $saleReceiptHeader->delete(Yii::app()->db);
                    Yii::app()->user->setFlash('message', 'Delete Successful');
                }
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id);
            $this->loadState($saleReceipt);

            if (isset($_POST['selectedIds'])) {
                $invoices = array();
                $invoices = $_POST['selectedIds'];

                foreach ($invoices as $invoice)
                    $saleReceipt->addInvoice($invoice);
            }

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt,
            ));
        }
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['ManualSaleReceiptHeader']['customer_id'])) ? $_POST['ManualSaleReceiptHeader']['customer_id'] : '';

            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_company' => CHtml::value($customer, 'company'),
                'customer_address_main' => CHtml::value($customer, 'address_main'),
                'customer_due_days' => CHtml::value($customer, 'invoice_due_days'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id);
            $this->loadState($saleReceipt);

            $saleReceipt->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt
            ));
        }
    }

    public function actionAjaxHtmlResetDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id);
            $this->loadState($saleReceipt);

            $saleReceipt->resetDetail();

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $saleReceipt = new ManualSaleReceipt(new ManualSaleReceiptHeader(), array());
        else {
            $saleReceiptHeader = $this->loadModel($id);
            $saleReceipt = new ManualSaleReceipt($saleReceiptHeader, $saleReceiptHeader->manualSaleReceiptDetails);
        }

        return $saleReceipt;
    }

    public function loadModel($id) {
        $model = ManualSaleReceiptHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($saleReceipt) {
        if (isset($_POST['ManualSaleReceiptHeader'])) {
            $saleReceipt->header->attributes = $_POST['ManualSaleReceiptHeader'];
        }
        if (isset($_POST['ManualSaleReceiptDetail'])) {
            foreach ($_POST['ManualSaleReceiptDetail'] as $i => $item) {
                if (isset($saleReceipt->details[$i]))
                    $saleReceipt->details[$i]->attributes = $item;
                else {
                    $detail = new ManualSaleReceiptDetail();
                    $detail->attributes = $item;
                    $saleReceipt->details[] = $detail;
                }
            }
            if (count($_POST['ManualSaleReceiptDetail']) < count($saleReceipt->details))
                array_splice($saleReceipt->details, $i + 1);
        }
        else
            $saleReceipt->details = array();
    }
}