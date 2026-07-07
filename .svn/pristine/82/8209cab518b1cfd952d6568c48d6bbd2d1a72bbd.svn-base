<?php

class DeliveryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deliveryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionQualityControlList() {
        $customerCompanyCutting = isset($_GET['CustomerCompanyCutting']) ? $_GET['CustomerCompanyCutting'] : '';
        $customerCuttingPurchaseNumber = isset($_GET['CustomerCuttingPurchaseNumber']) ? $_GET['CustomerCuttingPurchaseNumber'] : '';
        $workOrderOrdinal = isset($_GET['WorkOrderOrdinal']) ? $_GET['WorkOrderOrdinal'] : '';
        $workOrderMonth = isset($_GET['WorkOrderMonth']) ? $_GET['WorkOrderMonth'] : '';
        $workOrderYear = isset($_GET['WorkOrderYear']) ? $_GET['WorkOrderYear'] : '';
        
        $qualityControlCuttingHeader = Search::bind(new QualityControlCuttingHeader('search'), isset($_GET['QualityControlCuttingHeader']) ? $_GET['QualityControlCuttingHeader'] : '');
        $qualityControlCuttingHeaderDataProvider = $qualityControlCuttingHeader->searchForDelivery();
        $qualityControlCuttingHeaderDataProvider->criteria->with = array(
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
        
        if (!empty($customerCompanyCutting)) {
            $qualityControlCuttingHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $qualityControlCuttingHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompanyCutting}%";
        }
        
        if (!empty($customerCuttingPurchaseNumber)) {
            $qualityControlCuttingHeaderDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
            $qualityControlCuttingHeaderDataProvider->criteria->params[':customer_order_number'] = "%{$customerCuttingPurchaseNumber}%";
        }
        
        if (!empty($workOrderOrdinal)) {
            $qualityControlCuttingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_ordinal = :cn_ordinal');
            $qualityControlCuttingHeaderDataProvider->criteria->params[':cn_ordinal'] = $workOrderOrdinal;
        }
        if (!empty($workOrderMonth)) {
            $qualityControlCuttingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_month = :cn_month');
            $qualityControlCuttingHeaderDataProvider->criteria->params[':cn_month'] = $workOrderMonth;
        }
        if (!empty($workOrderYear)) {
            $qualityControlCuttingHeaderDataProvider->criteria->addCondition('workOrderCuttingHeader.cn_year = :cn_year');
            $qualityControlCuttingHeaderDataProvider->criteria->params[':cn_year'] = $workOrderYear;
        }

        $qualityControlCuttingHeaderDataProvider->criteria->order = 't.date DESC';

        $customerCompanyMiling = isset($_GET['CustomerCompanyMiling']) ? $_GET['CustomerCompanyMiling'] : '';
        $customerMilingPurchaseNumber = isset($_GET['CustomerMilingPurchaseNumber']) ? $_GET['CustomerMilingPurchaseNumber'] : '';
        
        $qualityControlMilingHeader = Search::bind(new QualityControlMilingHeader('search'), isset($_GET['QualityControlMilingHeader']) ? $_GET['QualityControlMilingHeader'] : '');
        $qualityControlMilingHeaderDataProvider = $qualityControlMilingHeader->searchForDelivery();
        $qualityControlMilingHeaderDataProvider->criteria->with = array(
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
        if (!empty($customerCompanyMiling)) {
            $qualityControlMilingHeaderDataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $qualityControlMilingHeaderDataProvider->criteria->params[':customer_company'] = "%{$customerCompanyMiling}%";
        }
        if (!empty($customerMilingPurchaseNumber)) {
            $qualityControlMilingHeaderDataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
            $qualityControlMilingHeaderDataProvider->criteria->params[':customer_order_number'] = "%{$customerMilingPurchaseNumber}%";
        }
        $qualityControlMilingHeaderDataProvider->criteria->order = 't.date DESC';

        $this->render('qualityControlList', array(
            'qualityControlCuttingHeader' => $qualityControlCuttingHeader,
            'qualityControlCuttingHeaderDataProvider' => $qualityControlCuttingHeaderDataProvider,
            'customerCompanyCutting' => $customerCompanyCutting,
            'customerCuttingPurchaseNumber' => $customerCuttingPurchaseNumber,
            'qualityControlMilingHeader' => $qualityControlMilingHeader,
            'qualityControlMilingHeaderDataProvider' => $qualityControlMilingHeaderDataProvider,
            'customerCompanyMiling' => $customerCompanyMiling,
            'customerMilingPurchaseNumber' => $customerMilingPurchaseNumber,
            'workOrderOrdinal' => $workOrderOrdinal,
            'workOrderMonth' => $workOrderMonth,
            'workOrderYear' => $workOrderYear,
        ));
    }

    public function actionCreate($qualityControlCuttingId, $qualityControlMilingId) {
        $delivery = $this->instantiate(null);
        $delivery->header->date = date('Y-m-d');
        $delivery->header->admin_id = Yii::app()->user->id;
        $delivery->header->created_datetime = date('Y-m-d H:i:s');
        $delivery->header->quality_control_cutting_header_id = $qualityControlCuttingId;
        $delivery->header->quality_control_miling_header_id = $qualityControlMilingId;
            
        $qualityControlCuttingHeader = QualityControlCuttingHeader::model()->findByPk($qualityControlCuttingId);
        $qualityControlMilingHeader = QualityControlMilingHeader::model()->findByPk($qualityControlMilingId);

        if (!empty($qualityControlCuttingId)) {
            $delivery->header->work_order_cutting_header_id = $qualityControlCuttingHeader->work_order_cutting_header_id;
            $delivery->header->is_delivery_approval_needed = $qualityControlCuttingHeader->workOrderCuttingHeader->saleHeader->customer->is_delivery_approval_needed;
            $delivery->addCuttingDetails($qualityControlCuttingId);
        } else {
            $delivery->header->work_order_cutting_header_id = $qualityControlMilingHeader->work_order_cutting_header_id;
            $delivery->header->is_delivery_approval_needed = $qualityControlMilingHeader->workOrderCuttingHeader->saleHeader->customer->is_delivery_approval_needed;
            $delivery->addMilingDetails($qualityControlMilingId);
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($delivery);
            $delivery->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($delivery->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($delivery->header->date)));
            $delivery->header->customer_address = $delivery->header->workOrderCuttingHeader->saleHeader->customer->address_main;
            
            if ($delivery->save(Yii::app()->db)) {
                Yii::app()->session['DeliveryMemoAllowed'] = true;
                $this->redirect(array('view', 'id' => $delivery->header->id));
            }
        }

        $this->render('create', array(
            'delivery' => $delivery,
        ));
    }

    public function actionUpdate($id) {
        $delivery = $this->instantiate($id);
        $delivery->header->admin_id_updated = Yii::app()->user->id;
        $delivery->header->updated_datetime = date('Y-m-d H:i:s');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($delivery);
            
            if ($delivery->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $delivery->header->id));
            }
        }

        $this->render('update', array(
            'delivery' => $delivery,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $delivery = $this->loadModel($id);
            $delivery->delete(Yii::app()->db);

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionView($id) {
        $delivery = $this->loadModel($id);

        $criteria = new CDbCriteria;
        $criteria->compare('delivery_header_id', $delivery->id);
        $detailsDataProvider = new CActiveDataProvider('DeliveryDetail', array(
            'criteria' => $criteria,
        ));

        $this->render('view', array(
            'delivery' => $delivery,
            'detailsDataProvider' => $detailsDataProvider,
        ));
    }

    public function actionMemo($id) {
        $delivery = $this->loadModel($id);

        $this->render('memo', array(
            'delivery' => $delivery,
        ));
    }

    public function actionAdmin() {
        $delivery = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $customerPurchaseNumber = isset($_GET['CustomerPurchaseNumber']) ? $_GET['CustomerPurchaseNumber'] : '';
        
        $workOrderCnOrdinal = isset($_GET['WorkOrderCnOrdinal']) ? $_GET['WorkOrderCnOrdinal'] : '';   
        $workOrderCnMonth = isset($_GET['WorkOrderCnMonth']) ? $_GET['WorkOrderCnMonth'] : '';          
        $workOrderCnYear = isset($_GET['WorkOrderCnYear']) ? $_GET['WorkOrderCnYear'] : '';  
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $delivery->searchWithPaging();

        $dataProvider->criteria->with = array(
            'workOrderCuttingHeader' => array(
                'with' => array(
                    'saleHeader' => array(
                        'with' => array(
                            'customer:resetScope',
                        ),
                    ),
                ),
            ),
        );     

        if (!empty($customerCompany)) {
            $dataProvider->criteria->addCondition('customer.company LIKE :customer_company');
            $dataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }

        if (!empty($customerPurchaseNumber)) {
            $dataProvider->criteria->addCondition("saleHeader.customer_order_number LIKE :customer_order_number");
            $dataProvider->criteria->params[':customer_order_number'] = "%{$customerPurchaseNumber}%";
        }
        
        $dataProvider->criteria->compare('workOrderCuttingHeader.cn_ordinal', $workOrderCnOrdinal, true);
        $dataProvider->criteria->compare('workOrderCuttingHeader.cn_month', $workOrderCnMonth, true);
        $dataProvider->criteria->compare('workOrderCuttingHeader.cn_year', $workOrderCnYear, true);
        
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
            'delivery' => $delivery,
            'dataProvider' => $dataProvider,
            'customerCompany' => $customerCompany,  
            'customerPurchaseNumber' => $customerPurchaseNumber,         
            'workOrderCnOrdinal' => $workOrderCnOrdinal,   
            'workOrderCnMonth' => $workOrderCnMonth,   
            'workOrderCnYear' => $workOrderCnYear,               
        ));
    }

    public function actionAjaxHtmlRemoveDetail($index, $id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);

            $this->loadState($delivery);

            $delivery->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'delivery' => $delivery,
            ));
        }
    }

    public function actionAjaxJsonCutting($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);

            $this->loadState($delivery);

            $cuttingHeader = CuttingHeader::model()->findByPk($_POST['DeliveryHeader']['cutting_header_id']);

            $object = array(
                'cutting_header_code_number' => ($cuttingHeader === null) ? '' : $cuttingHeader->getCodeNumber(CuttingHeader::CN_CONSTANT),
                'cutting_header_date' => CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($cuttingHeader, 'date')))),
                'customerName' => CHtml::encode(CHtml::value($cuttingHeader, 'workOrderCuttingHeader.saleHeader.customer.company')),
                'cutting_header_spk' => ($cuttingHeader->work_order_cutting_header_id === null) ? '' : $cuttingHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT),
                'cutting_header_spk_date' => CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($cuttingHeader, 'workOrderCuttingHeader.date')))),
                'customerAddress' => CHtml::activeTextArea($delivery->header, 'customer_address', array('rows' => 5, 'cols' => 30, 'class' => 'TabOnEnter',
                    'tabindex' => '2',
                    'value' => CHtml::encode(CHtml::value($cuttingHeader, 'workOrderCuttingHeader.saleHeader.customer.address_main')),
                )),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonWorkOrderCutting($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);

            $this->loadState($delivery);

            $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByPk($_POST['DeliveryHeader']['work_order_cutting_header_id']);

            $object = array(
                'work_order_cutting_header_code_number' => ($workOrderCuttingHeader === null) ? '' : $workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT),
                'work_order_cutting_header_date' => CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($workOrderCuttingHeader, 'date')))),
                'work_order_cutting_customer_name' => CHtml::encode(CHtml::value($workOrderCuttingHeader, 'saleHeader.customer.company')),
                'work_order_cutting_customer_address' => CHtml::activeTextArea($delivery->header, 'customer_address', array('rows' => 5, 'cols' => 30, 'class' => 'TabOnEnter',
                    'tabindex' => '2',
                    'value' => CHtml::encode(CHtml::value($delivery->header, 'workOrderCuttingHeader.saleHeader.customer.address_main')),
                )),
                'work_order_cutting_customer_city' => CHtml::activeTextField($delivery->header, 'customer_city', array('class' => 'TabOnEnter',
                    'tabindex' => '3',
                    'value' => CHtml::encode(CHtml::value($delivery->header, 'workOrderCuttingHeader.saleHeader.customer.city')),
                )),
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = $this->instantiate($id);

            if (isset($_POST['DeliveryHeader']['work_order_cutting_header_id']))
                $delivery->addDetails($_POST['DeliveryHeader']['work_order_cutting_header_id']);

            $this->renderPartial('_detail', array(
                'delivery' => $delivery,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id))
            $delivery = new Delivery(new DeliveryHeader(), array());
        else {
            $deliveryHeader = $this->loadModel($id);
            $delivery = new Delivery($deliveryHeader, $deliveryHeader->deliveryDetails);
        }

        return $delivery;
    }

    public function loadModel($id) {
        $model = DeliveryHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function loadState(&$delivery) {
        if (isset($_POST['DeliveryHeader'])) {
            $delivery->header->attributes = $_POST['DeliveryHeader'];
        }
        if (isset($_POST['DeliveryDetail'])) {
            foreach ($_POST['DeliveryDetail'] as $i => $item) {
                if (isset($delivery->details[$i]))
                    $delivery->details[$i]->attributes = $item;
                else {
                    $detail = new DeliveryDetail();
                    $detail->attributes = $item;
                    $delivery->details[] = $detail;
                }
            }
            if (count($_POST['DeliveryDetail']) < count($delivery->details))
                array_splice($delivery->details, $i + 1);
        }
        else
            $delivery->details = array();
    }

}
