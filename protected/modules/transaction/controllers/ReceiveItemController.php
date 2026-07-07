<?php

class ReceiveItemController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('receiveItemCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('receiveItemEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'view'
            || $filterChain->action->id === 'memo'
            || $filterChain->action->id === 'admin'
        ) {
            if (!(Yii::app()->user->checkAccess('receiveItemCreate') || Yii::app()->user->checkAccess('receiveItemEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $receiveItem = $this->instantiate(null);
        $receiveItem->header->date = date('Y-m-d');
        $receiveItem->header->admin_id = Yii::app()->user->id;
        $receiveItem->header->created_datetime = date('Y-m-d H:i:s');

        $purchaseItemHeader = Search::bind(new PurchaseItemHeader('search'), isset($_GET['PurchaseItemHeader']) ? $_GET['PurchaseItemHeader'] : array());

        $supplierCompany = isset($_GET['SupplierCompany']) ? $_GET['SupplierCompany'] : '';

        $purchaseItemHeaderDataProvider = $purchaseItemHeader->searchByReceiveItem();
        $purchaseItemHeaderDataProvider->criteria->with = array(
            'supplier',
        );

        $purchaseItemHeaderDataProvider->criteria->addCondition("supplier.company LIKE :company");
        $purchaseItemHeaderDataProvider->criteria->params[':company'] = "%{$supplierCompany}%";

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($receiveItem);
            $receiveItem->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($receiveItem->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($receiveItem->header->date)));
            
            if ($receiveItem->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $receiveItem->header->id));
        }

        $this->render('create', array(
            'receiveItem' => $receiveItem,
            'purchaseItemHeader' => $purchaseItemHeader,
            'purchaseItemHeaderDataProvider' => $purchaseItemHeaderDataProvider,
            'supplierCompany' => $supplierCompany,
        ));
    }

    public function actionUpdate($id) {
        $receiveItem = $this->instantiate($id);
        $receiveItem->header->admin_id_updated = Yii::app()->user->id;
        $receiveItem->header->updated_datetime = date('Y-m-d H:i:s');

        $purchaseItemHeader = Search::bind(new PurchaseItemHeader('search'), isset($_GET['PurchaseItemHeader']) ? $_GET['PurchaseItemHeader'] : array());

        $supplierCompany = isset($_GET['SupplierCompany']) ? $_GET['SupplierCompany'] : '';

        $purchaseItemHeaderDataProvider = $purchaseItemHeader->searchByReceiveItem();
        $purchaseItemHeaderDataProvider->criteria->with = array(
            'supplier',
        );

        $purchaseItemHeaderDataProvider->criteria->addCondition("supplier.company LIKE :company");
        $purchaseItemHeaderDataProvider->criteria->params[':company'] = "%{$supplierCompany}%";

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($receiveItem);
            if ($receiveItem->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $receiveItem->header->id));
        }

        $this->render('update', array(
            'receiveItem' => $receiveItem,
            'purchaseItemHeader' => $purchaseItemHeader,
            'purchaseItemHeaderDataProvider' => $purchaseItemHeaderDataProvider,
            'supplierCompany' => $supplierCompany,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $receive = $this->loadModel($id);
            
            if ($receive !== null) {
                $receive->is_inactive = ActiveRecord::INACTIVE;
                $receive->update(array('is_inactive'));
                
                foreach ($receive->receiveItemDetails as $detail) {
                    $detail->is_inactive = ActiveRecord::INACTIVE;
                    $detail->update(array('is_inactive'));
                }
            }

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionView($id) {
        $receiveItem = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('receive_item_header_id', $receiveItem->id);
        $detailsDataProvider = new CActiveDataProvider('ReceiveItemDetail', array(
                    'criteria' => $criteria,
                ));

        $this->render('view', array(
            'receiveItem' => $receiveItem,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $receiveItem = $this->loadModel($id);

        $this->render('memo', array(
            'receiveItem' => $receiveItem,
        ));
    }

    public function actionAdmin() {
        $receiveItem = Search::bind(new ReceiveItemHeader('search'), isset($_GET['ReceiveItemHeader']) ? $_GET['ReceiveItemHeader'] : array());
        $supplierCompany = isset($_GET['SupplierCompany']) ? $_GET['SupplierCompany'] : '';
        $purchaseItem = Search::bind(new PurchaseItemHeader('search'), isset($_GET['PurchaseItemHeader']) ? $_GET['PurchaseItemHeader'] : array());

        $purchaseItemCnOrdinal = isset($_GET['PurchaseItemCnOrdinal']) ? $_GET['PurchaseItemCnOrdinal'] : '';
        $purchaseItemCnMonth = isset($_GET['PurchaseItemCnMonth']) ? $_GET['PurchaseItemCnMonth'] : '';
        $purchaseItemCnYear = isset($_GET['PurchaseItemCnYear']) ? $_GET['PurchaseItemCnYear'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $receiveItem->searchWithPaging();
        $dataProvider->criteria->with = array(
            'purchaseItemHeader' => array(
                'with' => array('supplier')
            ),
        );
//        $dataProvider->sort->attributes = array(
//            'id' => 't.id',
//            'date' => 't.date',
//            'purchaseItemHeaderId' => 'purchaseItemHeader.id',
//            'supplierCompanyName' => 'supplier.company',
//        );

        if ($purchaseItemCnOrdinal != null || $purchaseItemCnMonth != null || $purchaseItemCnYear != null) {
            $dataProvider->criteria->compare('purchaseItemHeader.cn_ordinal', $purchaseItemCnOrdinal);
            $dataProvider->criteria->compare('purchaseItemHeader.cn_month', $purchaseItemCnMonth);
            $dataProvider->criteria->compare('purchaseItemHeader.cn_year', $purchaseItemCnYear);
        }

        if ($supplierCompany != null) {
            $dataProvider->criteria->addCondition("supplier.company LIKE :company");
            $dataProvider->criteria->params[':company'] = "%{$supplierCompany}%";
        }

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
            'receiveItem' => $receiveItem,
            'dataProvider' => $dataProvider,
            'supplierCompany' => $supplierCompany,
            'purchaseItem' => $purchaseItem,
            'purchaseItemCnOrdinal' => $purchaseItemCnOrdinal,
            'purchaseItemCnMonth' => $purchaseItemCnMonth,
            'purchaseItemCnYear' => $purchaseItemCnYear,
        ));
    }

    public function actionAjaxHtmlRemoveDetail($index, $id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $receiveItem->removeDetailAt($index);

            $this->renderPartial('_detail', array(
            'receiveItem' => $receiveItem,
                'error' => false,
            ));
        }
    }

    public function actionAjaxJsonPurchaseItem($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $purchaseItemHeader = PurchaseItemHeader::model()->findByPk($_POST['ReceiveItemHeader']['purchase_item_header_id']);

            $object = array(
                'purchase_item_header_code_number' => ($purchaseItemHeader === null) ? '' : $purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT),
                'purchase_item_header_date' => CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($purchaseItemHeader, 'date')))),
                'supplier_company' => $purchaseItemHeader->supplier->company,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlShowPurchaseItem($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            if (isset($_POST['ReceiveItemHeader']['purchase_item_header_id']))
                $receiveItem->addDetailByPurchaseItem($_POST['ReceiveItemHeader']['purchase_item_header_id']);

            $this->renderPartial('_detail', array(
                'receiveItem' => $receiveItem,
            ));
        }
    }

    public function actionAjaxHtmlResetDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receiveItem = $this->instantiate($id);
            $this->loadState($receiveItem);

            $receiveItem->details = array();

            $this->renderPartial('_detail', array(
                'receiveItem' => $receiveItem,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $receiveItem = new ReceiveItem(new ReceiveItemHeader(), array());
        else {
            $receiveItemHeader = $this->loadModel($id);
            $receiveItem = new ReceiveItem($receiveItemHeader, $receiveItemHeader->receiveItemDetails);
        }

        return $receiveItem;
    }

    public function loadModel($id) {
        $model = ReceiveItemHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function loadState(&$receiveItem) {
        if (isset($_POST['ReceiveItemHeader'])) {
            $receiveItem->header->attributes = $_POST['ReceiveItemHeader'];
        }

        if (isset($_POST['ReceiveItemDetail'])) {
            foreach ($_POST['ReceiveItemDetail'] as $i => $item) {
                if (isset($receiveItem->details[$i]))
                    $receiveItem->details[$i]->attributes = $item;
                else {
                    $detail = new ReceiveItemDetail();
                    $detail->attributes = $item;
                    $receiveItem->details[] = $detail;
                }
            }
            if (count($_POST['ReceiveItemDetail']) < count($receiveItem->details))
                array_splice($receiveItem->details, $i + 1);
        }
        else
            $receiveItem->details = array();
    }

}
