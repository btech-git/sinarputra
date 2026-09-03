<?php

class SalePaymentController extends Controller {

    public function filters() {
        return array(
			'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin'
                || $filterChain->action->id === 'ajaxHtmlResetPayment' 
                || $filterChain->action->id === 'ajaxHtmlRemovePayment'
                || $filterChain->action->id === 'ajaxHtmlAddAccount' 
                || $filterChain->action->id === 'ajaxJsonTotal'
                || $filterChain->action->id === 'ajaxJsonSaleReceipt' 
                || $filterChain->action->id === 'memo' 
                || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $salePayment = $this->instantiate(null);

        $salePayment->header->admin_id = Yii::app()->user->id;
        $salePayment->header->date_created = date('Y-m-d');
        $salePayment->header->time_created = date('H:i:s');
        $salePayment->header->date = date('Y-m-d');

        $saleInvoice = Search::bind(new SaleInvoiceHeader('search'), isset($_GET['SaleInvoiceHeader']) ? $_GET['SaleInvoiceHeader'] : array());
        $saleInvoiceDataProvider = $saleInvoice->searchForSalePayment();

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        $customerId = isset($_GET['SalePaymentHeader']['customer_id']) ? $_GET['SalePaymentHeader']['customer_id'] : '';

        $saleInvoiceDataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => 'customer'
                    ),
                ),
            ),
        );

        if (!empty($customerId)) {
            $saleInvoiceDataProvider->criteria->addCondition("saleHeader.customer_id = :customer_id");
            $saleInvoiceDataProvider->criteria->params[':customer_id'] = $customerId;
        }
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($salePayment);
            $salePayment->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($salePayment->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($salePayment->header->date)));

            if ($salePayment->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $salePayment->header->id));
            }
        }

        $this->render('create', array(
            'salePayment' => $salePayment,
            'saleInvoice' => $saleInvoice,
            'saleInvoiceDataProvider' => $saleInvoiceDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $salePayment = $this->instantiate($id);
        $salePayment->header->admin_id_updated = Yii::app()->user->id;
        $salePayment->header->updated_datetime = date('Y-m-d H:i:s');

        $saleInvoice = Search::bind(new SaleInvoiceHeader('search'), isset($_GET['SaleInvoiceHeader']) ? $_GET['SaleInvoiceHeader'] : array());
        $saleInvoiceDataProvider = $saleInvoice->searchForSaleReceipt();

        $saleInvoiceDataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => 'customer'
                    ),
                ),
            ),
        );

        if (!empty($salePayment->header->customer_id)) {
            $saleInvoiceDataProvider->criteria->addCondition("saleHeader.customer_id = :customer_id");
            $saleInvoiceDataProvider->criteria->params[':customer_id'] = $salePayment->header->customer_id;
        }
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($salePayment);

            if ($salePayment->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $salePayment->header->id));
        }

        $this->render('update', array(
            'salePayment' => $salePayment,
            'saleInvoice' => $saleInvoice,
            'saleInvoiceDataProvider' => $saleInvoiceDataProvider,
        ));
    }

    public function actionView($id) {
        $salePayment = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('sale_payment_header_id', $salePayment->id);
        $detailsDataProvider = new CActiveDataProvider('SalePaymentDetail', array(
                    'criteria' => $criteria,
                ));

        $this->render('view', array(
            'salePayment' => $salePayment,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $salePayment = $this->instantiate($id);
            if ($salePayment !== null) {
                foreach ($this->details as $detail) {
                    $saleInvoiceHeader = SaleInvoiceHeader::model()->findByPk($detail->sale_invoice_header_id);
                    $saleInvoiceHeader->total_payment = 0.00;
                    $valid = $saleInvoiceHeader->update(array('total_payment')) && $valid;
                }
                
                $salePayment->delete(Yii::app()->db);
                
                Yii::app()->user->setFlash('message', 'Delete Successful');
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAdmin() {
        $salePayment = Search::bind(new SalePaymentHeader('search'), isset($_GET['SalePaymentHeader']) ? $_GET['SalePaymentHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }
        
        $dataProvider = $salePayment->searchWithPaging();
        $dataProvider->criteria->with = array(
            'customer',
        );
        
		$dataProvider->criteria->addCondition("customer.company LIKE :company");
		$dataProvider->criteria->params[':company'] = "%{$customerCompany}%";
        
        $dataProvider->criteria->addCondition('t.is_inactive = 0');
        $dataProvider->criteria->order = 't.id DESC';

        $this->render('admin', array(
            'salePayment' => $salePayment,
            'dataProvider' => $dataProvider,
            'customerCompany' => $customerCompany,
        ));
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['SalePaymentHeader']['customer_id'])) ? $_POST['SalePaymentHeader']['customer_id'] : '';

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

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);

            $this->loadState($salePayment);

            $object = array(
                'amount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment->details[$index], 'amount'))),
                'totalAdditionalPayment1' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalAdditionalPayment1'))),
                'totalAdditionalPayment2' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalAdditionalPayment2'))),
                'payment' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalPayment'))),
                'receivable' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'totalReceivable'))),
                'remaining' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'remaining'))),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonRemaining($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);

            $this->loadState($salePayment);

            $object = array(
                'remaining' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($salePayment, 'remaining'))),
            );
            
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);
            $this->loadState($salePayment);

            if (isset($_POST['selectedIds'])) {
                $invoices = array();
                $invoices = $_POST['selectedIds'];

                foreach ($invoices as $invoice)
                    $salePayment->addInvoice($invoice);
            }

            $this->renderPartial('_detail', array(
                'salePayment' => $salePayment,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);
            $this->loadState($salePayment);

            $salePayment->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'salePayment' => $salePayment,
            ));
        }
    }

    public function actionAjaxHtmlResetDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePayment = $this->instantiate($id);
            $this->loadState($salePayment);

            $salePayment->resetDetail();

            $this->renderPartial('_detail', array(
                'salePayment' => $salePayment,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $salePayment = new SalePaymentComponent(new SalePaymentHeader(), array());
        else {
            $salePaymentHeader = $this->loadModel($id);
            $salePayment = new SalePaymentComponent($salePaymentHeader, $salePaymentHeader->salePaymentDetails);
        }

        return $salePayment;
    }

    public function loadModel($id) {
        $model = SalePaymentHeader::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function loadState(&$salePayment) {
        if (isset($_POST['SalePaymentHeader'])) {
            $salePayment->header->attributes = $_POST['SalePaymentHeader'];
        }
        if (isset($_POST['SalePaymentDetail'])) {
            foreach ($_POST['SalePaymentDetail'] as $i => $item) {
                if (isset($salePayment->details[$i]))
                    $salePayment->details[$i]->attributes = $item;
                else {
                    $detail = new SalePaymentDetail();
                    $detail->attributes = $item;
                    $salePayment->details[] = $detail;
                }
            }
            if (count($_POST['SalePaymentDetail']) < count($salePayment->details))
                array_splice($salePayment->details, $i + 1);
        }
        else
            $salePayment->details = array();
    }

}
