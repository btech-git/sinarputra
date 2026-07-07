<?php

class SaleController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('saleEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('saleCreate') || Yii::app()->user->checkAccess('saleEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function instantiate($id) {
        if (empty($id))
            $sale = new Sale(new SaleHeader(), array());
        else {
            $saleHeader = $this->loadModel($id);
            $sale = new Sale($saleHeader, $saleHeader->saleDetails);
        }

        return $sale;
    }

    public function loadModel($id) {
        $model = SaleHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($sale) {
        if (isset($_POST['SaleHeader'])) {
            $sale->header->attributes = $_POST['SaleHeader'];
        }

        if (isset($_POST['SaleDetail'])) {
            foreach ($_POST['SaleDetail'] as $i => $item) {
                if (isset($sale->saleDetails[$i]))
                    $sale->saleDetails[$i]->attributes = $item;
                else {
                    $detail = new SaleDetail();
                    $detail->attributes = $item;
                    $sale->saleDetails[] = $detail;
                }
            }
            if (count($_POST['SaleDetail']) < count($sale->saleDetails))
                array_splice($sale->saleDetails, $i + 1);
        }
        else
            $sale->saleDetails = array();
    }

    public function actionCreate() {
        $sale = $this->instantiate(null);
        $sale->header->date = date('Y-m-d');
        $sale->header->admin_id = Yii::app()->user->id;
        $sale->header->admin_id_edit = null;
        
        $customer = Search::bind(new Customer, isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $customerDataProvider = $customer->search();

        $quotationDetailProduct = Search::bind(new QuotationDetailProduct, isset($_GET['QuotationDetailProduct']) ? $_GET['QuotationDetailProduct'] : '');
        $quotationDetailProductDataProvider = $quotationDetailProduct->searchNotSelectedInSaleDetailProduct();

        $quotationDetailService = Search::bind(new QuotationDetailService, isset($_GET['QuotationDetailService']) ? $_GET['QuotationDetailService'] : '');
        $quotationDetailServiceDataProvider = $quotationDetailService->searchNotSelectedInSaleDetailService();

        //filters
        $customerId = isset($_GET['SaleHeader']['customer_id']) ? $_GET['SaleHeader']['customer_id'] : '';
        $cnOrdinal = isset($_GET['CnOrdinal']) ? $_GET['CnOrdinal'] : '';
        $cnMonth = isset($_GET['CnMonth']) ? $_GET['CnMonth'] : '';
        $cnYear = isset($_GET['CnYear']) ? $_GET['CnYear'] : '';

        $quotationDetailProductDataProvider->criteria->with = array('quotationHeader');
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.customer_id', $customerId);
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.cn_ordinal', $cnOrdinal);
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.cn_month', $cnMonth);
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.cn_year', $cnYear);

        $quotationDetailServiceDataProvider->criteria->with = array('quotationHeader');
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.customer_id', $customerId);
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.cn_ordinal', $cnOrdinal);
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.cn_month', $cnMonth);
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.cn_year', $cnYear);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($sale);
            $sale->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($sale->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($sale->header->date)));
            
            $customer = Customer::model()->findByPk($sale->header->customer_id);
            $sale->header->employee_id_salesman = $customer->employee_id;
            
            if ($sale->save(Yii::app()->db)) 
                $this->redirect(array('view', 'id' => $sale->header->id));
        }

        $this->render('create', array(
            'sale' => $sale,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'quotationDetailProduct' => $quotationDetailProduct,
            'quotationDetailProductDataProvider' => $quotationDetailProductDataProvider,
            'quotationDetailService' => $quotationDetailService,
            'quotationDetailServiceDataProvider' => $quotationDetailServiceDataProvider,
            'cnOrdinal' => $cnOrdinal,
            'cnMonth' => $cnMonth,
            'cnYear' => $cnYear
        ));
    }

    public function actionUpdate($id) {
        $sale = $this->instantiate($id);
        $sale->header->time_edited = date('Y-m-d H:i:s');
        $sale->header->admin_id_edit = Yii::app()->user->id;

        $customer = Search::bind(new Customer, isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $customerDataProvider = $customer->search();

        $quotationDetailProduct = Search::bind(new QuotationDetailProduct, isset($_GET['QuotationDetailProduct']) ? $_GET['QuotationDetailProduct'] : '');
        $quotationDetailProductDataProvider = $quotationDetailProduct->search();
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.customer_id', $sale->header->customer_id);

        $quotationDetailService = Search::bind(new QuotationDetailService, isset($_GET['QuotationDetailService']) ? $_GET['QuotationDetailService'] : '');
        $quotationDetailServiceDataProvider = $quotationDetailService->search();
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.customer_id', $sale->header->customer_id);

        //filters
        $customerId = isset($_GET['SaleHeader']['customer_id']) ? $_GET['SaleHeader']['customer_id'] : '';
        $cnOrdinal = isset($_GET['CnOrdinal']) ? $_GET['CnOrdinal'] : '';
        $cnMonth = isset($_GET['CnMonth']) ? $_GET['CnMonth'] : '';
        $cnYear = isset($_GET['CnYear']) ? $_GET['CnYear'] : '';

        $quotationDetailProductDataProvider->criteria->with = array('quotationHeader');
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.customer_id', $customerId);
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.cn_ordinal', $cnOrdinal);
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.cn_month', $cnMonth);
        $quotationDetailProductDataProvider->criteria->compare('quotationHeader.cn_year', $cnYear);

        $quotationDetailServiceDataProvider->criteria->with = array('quotationHeader');
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.customer_id', $customerId);
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.cn_ordinal', $cnOrdinal);
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.cn_month', $cnMonth);
        $quotationDetailServiceDataProvider->criteria->compare('quotationHeader.cn_year', $cnYear);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($sale);
            if ($sale->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $sale->header->id));
        }

        $this->render('update', array(
            'sale' => $sale,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'quotationDetailProduct' => $quotationDetailProduct,
            'quotationDetailProductDataProvider' => $quotationDetailProductDataProvider,
            'quotationDetailService' => $quotationDetailService,
            'quotationDetailServiceDataProvider' => $quotationDetailServiceDataProvider,
            'cnOrdinal' => $cnOrdinal,
            'cnMonth' => $cnMonth,
            'cnYear' => $cnYear
        ));
    }

    public function actionView($id) {
        $sale = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('sale_header_id', $sale->id);

        $detailDataProvider = new CActiveDataProvider('SaleDetail', array(
            'criteria' => $criteria,
        ));
        $detailDataProvider->criteria->with = array(
            'quotationDetailProduct:resetScope',
        );

        $this->render('view', array(
            'sale' => $sale,
            'detailDataProvider' => $detailDataProvider,
        ));
    }

    public function actionMemo($id) {
        $sale = $this->loadModel($id);

        $this->render('memo', array(
            'sale' => $sale,
        ));
    }

    public function actionAdmin() {
        $sale = Search::bind(new SaleHeader('search'), isset($_GET['SaleHeader']) ? $_GET['SaleHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $sale->searchWithPaging();
        $dataProvider->criteria->with = array(
            'customer:resetScope',
        );
        
		$dataProvider->criteria->addCondition("customer.company LIKE :company");
		$dataProvider->criteria->params[':company'] = "%{$customerCompany}%";

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
            'sale' => $sale,
            'dataProvider' => $dataProvider,
            'customerCompany' => $customerCompany,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $sale = $this->loadModel($id);
            if ($sale !== null) {
                $sale->is_inactive = ActiveRecord::INACTIVE;
                $sale->update(array('is_inactive'));

                foreach ($sale->saleDetails as $saleDetail) {
                    if (empty($saleDetail->workOrderCuttingDetails))
                        $saleDetail->delete();
                    else {
                        foreach ($saleDetail->workOrderCuttingDetails as $workOrderCuttingDetail) {
                            $workOrderCuttingDetail->is_inactive = ActiveRecord::INACTIVE;
                            $workOrderCuttingDetail->update(array('is_inactive'));
                        }
                        $saleDetail->is_inactive = ActiveRecord::INACTIVE;
                        $saleDetail->update(array('is_inactive'));
                    }
                        
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['SaleHeader']['customer_id'])) ? $_POST['SaleHeader']['customer_id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_company' => CHtml::value($customer, 'company'),
                'customer_address' => CHtml::value($customer, 'address_main'),
                'customer_address_secondary' => CHtml::value($customer, 'address_secondary'),
                'customer_salesman' => CHtml::value($customer, 'employee.name'),
                'customer_credit_limit' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($customer, 'credit_limit'))),
                'customer_outstanding' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($customer, 'outstandingCredit'))),
                'customer_remaining_limit' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($customer, 'remainingCreditLimit'))),
            );
            echo CJSON::encode($object);
        }
    }

//    public function actionAjaxHtmlAddProduct($id) {
//        if (Yii::app()->request->isAjaxRequest) {
//            $sale = $this->instantiate($id);
//            $this->loadState($sale);
//
//            if (!empty($_POST['QuotationDetailProductId']))
//                $sale->addProduct($_POST['QuotationDetailProductId']);
//
//            $this->renderPartial('_detailProduct', array(
//                'sale' => $sale
//            ));
//        }
//    }

    public function actionAjaxHtmlAddProducts($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sale = $this->instantiate($id);
            $this->loadState($sale);

            if (isset($_POST['selectedIds'])) {
                $products = array();
                $products = $_POST['selectedIds'];

                foreach ($products as $product) {
//                    $propertyProduct = QuotationDetailProduct::model()->findByPk($id);
                    $sale->addProduct($product);
                }
            }

            $this->renderPartial('_detail', array(
                'sale' => $sale
            ));
        }
    }

    public function actionAjaxHtmlAddService($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sale = $this->instantiate($id);
            $this->loadState($sale);

            if (!empty($_POST['QuotationDetailServiceId']))
                $sale->addService($_POST['QuotationDetailServiceId']);

            $this->renderPartial('_detail', array(
                'sale' => $sale
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $sale = $this->instantiate($id);

            $this->loadState($sale);

            $sale->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'sale' => $sale,
            ));
        }
    }

    public function actionAjaxHtmlResetDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sale = $this->instantiate($id);

            $this->loadState($sale);

            if (isset($_POST['SaleHeader']['customer_id']))
                $sale->resetDetails($_POST['SaleHeader']['customer_id']);

            $this->renderPartial('_detail', array(
                'sale' => $sale,
            ));
        }
    }

//    public function actionAjaxHtmlResetDetailService($id) {
//        if (Yii::app()->request->isAjaxRequest) {
//            $sale = $this->instantiate($id);
//
//            $this->loadState($sale);
//
//            if (isset($_POST['SaleHeader']['customer_id']))
//                $sale->resetDetailServices($_POST['SaleHeader']['customer_id']);
//
//            $this->renderPartial('_detailService', array(
//                'sale' => $sale,
//            ));
//        }
//    }

}
