<?php

class PurchaseInvoiceController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('purchaseInvoiceCreate')))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('purchaseInvoiceEdit')))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'admin'
                || $filterChain->action->id === 'memo'
                || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('purchaseInvoiceCreate') || Yii::app()->user->checkAccess('purchaseInoviceEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function loadModel($id) {
        if (empty($id)) {
            $model = new PurchaseInvoice();
        } else {
            $model = PurchaseInvoice::model()->findByPk($id);
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    public function loadState($model) {
        if (isset($_POST['PurchaseInvoice'])) {
            $model->attributes = $_POST['PurchaseInvoice'];
        }
    }

    public function actionReceiveList() {
        $supplierCompanyMaterial = isset($_GET['SupplierCompanyMaterial']) ? $_GET['SupplierCompanyMaterial'] : '';
        $supplierCompanyItem = isset($_GET['SupplierCompanyItem']) ? $_GET['SupplierCompanyItem'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        $receiveHeader = Search::bind(new ReceiveHeader('search'), isset($_GET['ReceiveHeader']) ? $_GET['ReceiveHeader'] : '');
        $receiveHeaderDataProvider = $receiveHeader->searchForPurchaseInvoice();
        
        $receiveHeaderDataProvider->criteria->with = array(
            'purchaseHeader',
            'supplier:resetScope', 
        );

        $receiveHeaderDataProvider->criteria->order = 't.id DESC';

        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $receiveHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }        
        
        if (!empty($supplierCompanyMaterial)) {
            $receiveHeaderDataProvider->criteria->addCondition('supplier.company LIKE :supplier_company');
            $receiveHeaderDataProvider->criteria->params[':supplier_company'] = "%{$supplierCompanyMaterial}%";
        }

        $receiveItemHeader = Search::bind(new ReceiveItemHeader('search'), isset($_GET['ReceiveItemHeader']) ? $_GET['ReceiveItemHeader'] : '');
        $receiveItemHeaderDataProvider = $receiveItemHeader->searchForPurchaseInvoice();
        
        $receiveItemHeaderDataProvider->criteria->with = array(
            'purchaseItemHeader' => array(
                'with' => array(
                    'supplier:resetScope',                     
                ),
            ),
        );

        $receiveItemHeaderDataProvider->criteria->order = 't.id DESC';

        if ($startDate != '' || $endDate != '') {
            $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
            $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

            $receiveItemHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        }        
        
        if (!empty($supplierCompanyItem)) {
            $receiveItemHeaderDataProvider->criteria->addCondition('supplier.company LIKE :supplier_company');
            $receiveItemHeaderDataProvider->criteria->params[':supplier_company'] = "%{$supplierCompanyItem}%";
        }

        $this->render('receiveList', array(
            'receiveHeader' => $receiveHeader,
            'receiveHeaderDataProvider' => $receiveHeaderDataProvider,
            'supplierCompanyMaterial' => $supplierCompanyMaterial,
            'receiveItemHeader' => $receiveItemHeader,
            'receiveItemHeaderDataProvider' => $receiveItemHeaderDataProvider,
            'supplierCompanyItem' => $supplierCompanyItem,
        ));
    }

    public function actionCreate($receiveHeaderId, $receiveItemHeaderId) {
        $model = new PurchaseInvoice();

        $receiveHeader = ReceiveHeader::model()->findByPk($receiveHeaderId);
        $receiveItemHeader = ReceiveItemHeader::model()->findByPk($receiveItemHeaderId);

        $model->date = date('Y-m-d');
        $model->supplier_id = empty($receiveHeader) ? $receiveItemHeader->purchaseItemHeader->supplier_id : $receiveHeader->supplier_id;
        $model->receive_header_id = $receiveHeaderId;
        $model->receive_item_header_id = $receiveItemHeaderId;
        $model->discount_amount = empty($receiveHeader) ? $receiveItemHeader->purchaseItemHeader->discount : $receiveHeader->purchaseHeader->discountAmount;
        $model->is_item = empty($receiveHeader) ? 1 : 0;
        $model->admin_id = Yii::app()->user->id;
        $model->created_datetime = date('Y-m-d H:i:s');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->date)), Yii::app()->dateFormatter->format('yy', strtotime($model->date)));
            $model->grand_total = $model->grandTotal;
            
            if ($model->save(Yii::app()->db)) {
                /*JournalAccounting::model()->deleteAllByAttributes(array(
                    'transaction_number' => $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT),
                    'transaction_type' => AccountingJournalHelper::PURCHASE_INVOICE,
                ));

                $accountingJournalDebit = AccountingJournalHelper::make(
                    'debit', 
                    $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT), 
                    AccountingJournalHelper::PURCHASE_INVOICE,  
                    1012,
                    $model->grand_total, 
                    $model->supplier->company,
                    $model->note, 
                    $model->date,
                    $model->admin_id
                );
                $accountingJournalDebit->save(false);

                $accountingJournalCredit = AccountingJournalHelper::make(
                    'credit', 
                    $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT),
                    AccountingJournalHelper::PURCHASE_INVOICE,
                    $model->supplier->account_id_payable,
                    $model->grand_total,
                    $model->supplier->company,
                    $model->note, 
                    $model->date,
                    $model->admin_id
                );
                $accountingJournalCredit->save(false);*/

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'receiveHeader' => $receiveHeader,
            'receiveItemHeader' => $receiveItemHeader,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        if (!empty($model->receive_item_header_id)) {
            $transactionNumber = $model->receiveItemHeader->purchaseItemHeader->is_tax ? $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT_TAX) : $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT_NON_TAX);
            $criteria = new CDbCriteria;
            $criteria->compare('receive_item_header_id', $model->receive_item_header_id);
            $detailsDataProvider = new CActiveDataProvider('ReceiveItemDetail', array(
                'criteria' => $criteria,
            ));
        } else {
            $transactionNumber = $model->receiveHeader->purchaseHeader->is_tax ? $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT_TAX) : $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT_NON_TAX);
            $criteria = new CDbCriteria;
            $criteria->compare('purchase_header_id', $model->receiveHeader->purchase_header_id);
            $detailsDataProvider = new CActiveDataProvider('PurchaseDetail', array(
                'criteria' => $criteria,
            ));
        }

        $this->render('view', array(
            'model' => $model,
            'transactionNumber' => $transactionNumber,
            'detailsDataProvider' => $detailsDataProvider
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->admin_id_updated = Yii::app()->user->id;
        $model->updated_datetime = date('Y-m-d H:i:s');

        $receiveHeaderId = empty($model->receive_header_id) ? "" : $model->receive_header_id;
        $receiveItemHeaderId = empty($model->receive_item_header_id) ? "" : $model->receive_item_header_id;
        $receiveHeader = ReceiveHeader::model()->findByPk($receiveHeaderId);
        $receiveItemHeader = ReceiveItemHeader::model()->findByPk($receiveItemHeaderId);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($model);
            $model->grand_total = $model->grandTotal;
            
            if ($model->save()) {
                
                JournalAccounting::model()->deleteAllByAttributes(array(
                    'transaction_number' => $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT),
                    'transaction_type' => AccountingJournalHelper::PURCHASE_INVOICE,
                ));

                $accountingJournalDebit = AccountingJournalHelper::make(
                    'debit', 
                    $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT), 
                    AccountingJournalHelper::PURCHASE_INVOICE,  
                    1012,
                    $model->grand_total, 
                    $model->supplier->company,
                    $model->note, 
                    $model->date,
                    $model->admin_id
                );
                $accountingJournalDebit->save(false);

                $accountingJournalCredit = AccountingJournalHelper::make(
                    'credit', 
                    $model->getCodeNumber(PurchaseInvoice::CN_CONSTANT),
                    AccountingJournalHelper::PURCHASE_INVOICE,
                    $model->supplier->account_id_payable,
                    $model->grand_total,
                    $model->supplier->company,
                    $model->note, 
                    $model->date,
                    $model->admin_id
                );
                $accountingJournalCredit->save(false);
                
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'receiveHeader' => $receiveHeader,
            'receiveItemHeader' => $receiveItemHeader,
        ));
    }

    public function actionAdmin() {
        $model = Search::bind(new PurchaseInvoice('search'), isset($_GET['PurchaseInvoice']) ? $_GET['PurchaseInvoice'] : array());

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $model->search();
//        $dataProvider->criteria->condition = 't.is_inactive = 0';
        $dataProvider->criteria->with = array(
            'supplier:resetScope',
            'receiveItemHeader',
            'receiveHeader',
        );
        
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
            'startDate' => $startDate,
            'endDate' => $endDate,
            'dataProvider' => $dataProvider,
            'supplierCompany' => $supplierCompany,
        ));
    }

    public function actionAjaxJsonReceiveHeader($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            $this->loadState($model);

            $receiveHeader = ReceiveHeader::model()->findByPk($model->receive_header_id);

            $object = array(
                'receiveHeaderNumber' => CHtml::encode($receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)),
                'receiveHeaderDate' => CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($receiveHeader, 'date'))),
                'receiveHeaderNote' => CHtml::encode(CHtml::value($receiveHeader, 'note'))
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonReceiveItemHeader($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            $this->loadState($model);

            $receiveItemHeader = ReceiveItemHeader::model()->findByPk($model->receive_item_header_id);

            $object = array(
                'receiveItemHeaderNumber' => CHtml::encode($receiveItemHeader->getCodeNumber(ReceiveItemHeader::CN_CONSTANT)),
                'receiveItemHeaderDate' => CHtml::encode(Yii::app()->dateFormatter->format('d-MMMM-yyyy', CHtml::value($receiveItemHeader, 'date'))),
                'receiveItemHeaderNote' => CHtml::encode(CHtml::value($receiveItemHeader, 'note'))
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            $this->loadState($model);

            $receiveHeader = ReceiveHeader::model()->findByPk($model->receive_header_id);

            $this->renderPartial('_detail', array(
                'model' => $model,
                'receiveHeader' => $receiveHeader
            ));
        }
    }

    public function actionAjaxHtmlAddDetailItem($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            $this->loadState($model);

            $receiveItemHeader = ReceiveItemHeader::model()->findByPk($model->receive_item_header_id);

            $this->renderPartial('_detail_item', array(
                'model' => $model,
                'receiveItemHeader' => $receiveItemHeader
            ));
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            
            $model = $this->loadModel($id);
            $this->loadState($model);

            $taxItem = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTax));
            $taxIncome = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->calculatedTaxIncome));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->grandTotal));

            echo CJSON::encode(array(
                'taxItem' => $taxItem,
                'taxIncome' => $taxIncome,
                'grandTotal' => $grandTotal,
            ));
        }
    }
}