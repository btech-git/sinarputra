<?php

class QuotationReturnController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('quotationReturnCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('quotationReturnEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('quotationReturnCreate') || Yii::app()->user->checkAccess('quotationReturnEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $quotationReturn = $this->instantiate(null);
        $quotationReturn->header->date = date('Y-m-d');
        $quotationReturn->header->admin_id = Yii::app()->user->id;
        $quotationReturn->header->created_datetime = date('Y-m-d H:i:s');

        $quotationReturn->generateCodeNumber(date('m'), date('y'));

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($quotationReturn);

            if ($quotationReturn->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $quotationReturn->header->id));
        }

        $this->render('create', array(
            'quotationReturn' => $quotationReturn,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'customer' => $customer,
        ));
    }

    public function actionUpdate($id) {
        $quotationReturn = $this->instantiate($id);
        $quotationReturn->header->admin_id_updated = Yii::app()->user->id;
        $quotationReturn->header->updated_datetime = date('Y-m-d H:i:s');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($quotationReturn);

            if ($quotationReturn->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $quotationReturn->header->id));
        }

        $this->render('update', array(
            'quotationReturn' => $quotationReturn,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'customer' => $customer,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $quotationReturn = $this->loadModel($id);
            if ($quotationReturn !== null) {
                $quotationReturn->is_inactive = ActiveRecord::INACTIVE;
                $quotationReturn->update(array('is_inactive'));

                foreach ($quotationReturn->quotationReturnDetails as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $detail->update(array('is_inactive'));
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionView($id) {
        $quotationReturn = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('quotation_return_header_id', $quotationReturn->id);
        $detailsDataProvider = new CActiveDataProvider('QuotationReturnDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'quotationReturn' => $quotationReturn,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $quotationReturn = $this->loadModel($id);

        $this->render('memo', array(
            'quotationReturn' => $quotationReturn,
        ));
    }

    public function actionAdmin() {
        $quotationReturn = Search::bind(new QuotationReturnHeader('search'), isset($_GET['QuotationReturnHeader']) ? $_GET['QuotationReturnHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';

//		$cnMonth = isset($_GET['CnMonth']) ? $_GET['CnMonth'] : '';
//		$quotationReturn->normalizeCnMonthBy($cnMonth);

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $quotationReturn->searchWithPaging();
//		$dataProvider->criteria->condition = 't.is_inactive = 0';
        $dataProvider->criteria->with = array('customer');
//		$dataProvider->sort->attributes = array(
//			'cn_ordinal' => 't.id',
//			'date' => 't.date',
//			'customer' => 'customer.company'
//		);

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
            'quotationReturn' => $quotationReturn,
            'dataProvider' => $dataProvider,
//			'cnMonth' => strtoupper($cnMonth),
            'customerCompany' => $customerCompany,
        ));
    }

    public function actionAjaxHtmlRemoveDetail($index, $id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotationReturn = $this->instantiate($id);

            $this->loadState($quotationReturn);

            $quotationReturn->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'quotationReturn' => $quotationReturn,
            ));
        }
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['QuotationReturnHeader']['customer_id'])) ? $_POST['QuotationReturnHeader']['customer_id'] : '';

            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_company' => CHtml::value($customer, 'company'),
                'customer_address' => CHtml::value($customer, 'address_main'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddProductColor($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotationReturn = $this->instantiate($id);

            $this->loadState($quotationReturn);

            if (isset($_POST['ProductId']))
                $quotationReturn->addDetail($_POST['ProductId']);

            $this->renderPartial('_detail', array(
                'quotationReturn' => $quotationReturn,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProducts($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotationReturn = $this->instantiate($id);

            $this->loadState($quotationReturn);

            $this->renderPartial('_detail', array(
                'quotationReturn' => $quotationReturn,
            ));
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $quotationReturn = $this->instantiate($id);

            $this->loadState($quotationReturn);

            $unitPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotationReturn->details[$index], 'unit_price')));
            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($quotationReturn->details[$index], 'total')));
            $subTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $quotationReturn->subTotal));

            echo CJSON::encode(array(
                'unitPrice' => $unitPrice,
                'total' => $total,
                'subTotal' => $subTotal,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $quotationReturn = new QuotationReturn(new QuotationReturnHeader(), array());
        else {
            $quotationReturnHeader = $this->loadModel($id);
            $quotationReturn = new QuotationReturn($quotationReturnHeader, $quotationReturnHeader->quotationReturnDetails);
        }

        return $quotationReturn;
    }

    public function loadModel($id) {
        $model = QuotationReturnHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function loadState(&$quotationReturn) {
        if (isset($_POST['QuotationReturnHeader'])) {
            $quotationReturn->header->attributes = $_POST['QuotationReturnHeader'];
        }
        if (isset($_POST['QuotationReturnDetail'])) {
            foreach ($_POST['QuotationReturnDetail'] as $i => $item) {
                if (isset($quotationReturn->details[$i]))
                    $quotationReturn->details[$i]->attributes = $item;
                else {
                    $detail = new QuotationReturnDetail();
                    $detail->attributes = $item;
                    $quotationReturn->details[] = $detail;
                }
            }
            if (count($_POST['QuotationReturnDetail']) < count($quotationReturn->details))
                array_splice($quotationReturn->details, $i + 1);
        } else
            $quotationReturn->details = array();
    }
}
