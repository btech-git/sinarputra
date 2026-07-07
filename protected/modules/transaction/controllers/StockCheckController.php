<?php

class StockCheckController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockCheck')))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'adminReceive' || 
            $filterChain->action->id === 'updateReceive' ||
            $filterChain->action->id === 'adminCutting' ||
            $filterChain->action->id === 'updateCutting') {
            if (!(Yii::app()->user->checkAccess('inventory'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {

        //stock cek
        $receiveDetail = Search::bind(new ReceiveDetail(), isset($_GET['ReceiveDetail']) ? $_GET['ReceiveDetail'] : '');
        $receiveDetailDataProvider = $receiveDetail->searchNotSelectedInCuttingDetailMaterial();

        $receiveSerialNumber = isset($_GET['ReceiveSerialNumber']) ? $_GET['ReceiveSerialNumber'] : '';
        $workOrderCuttingDetailMaterial = Search::bind(new WorkOrderCuttingDetailMaterial(), isset($_GET['WorkOrderCuttingDetailMaterial']) ? $_GET['WorkOrderCuttingDetailMaterial'] : '');
        $workOrderCuttingDetailMaterialDataProvider = $workOrderCuttingDetailMaterial->searchProcessedStock();
        $workOrderCuttingDetailMaterialDataProvider->criteria->with = array('receiveDetail');
        
        $workOrderCuttingDetailMaterialDataProvider->criteria->addCondition("receiveDetail.serial_number LIKE :serial_number");
        $workOrderCuttingDetailMaterialDataProvider->criteria->params[':serial_number'] = "%{$receiveSerialNumber}%";

        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.serial_number', $workOrderCuttingDetailMaterial->serial_number);
        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.height', $workOrderCuttingDetailMaterial->height);
        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.width', $workOrderCuttingDetailMaterial->width);
        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.length', $workOrderCuttingDetailMaterial->length);

        $this->render('summary', array(
            'receiveDetail' => $receiveDetail,
            'receiveDetailDataProvider' => $receiveDetailDataProvider,
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
            'workOrderCuttingDetailMaterialDataProvider' => $workOrderCuttingDetailMaterialDataProvider,
            'receiveSerialNumber' => $receiveSerialNumber,
        ));
    }
    
    public function actionAdminReceive() {

        $receiveDetail = Search::bind(new ReceiveDetail(), isset($_GET['ReceiveDetail']) ? $_GET['ReceiveDetail'] : '');
        $receiveDetailDataProvider = $receiveDetail->searchNotSelectedInCuttingDetailMaterial();
        $receiveDetailDataProvider->criteria->compare('t.height', $receiveDetail->height);
        $receiveDetailDataProvider->criteria->compare('t.width', $receiveDetail->width);
        $receiveDetailDataProvider->criteria->compare('t.length', $receiveDetail->length);

        $this->render('admin_receive', array(
            'receiveDetail' => $receiveDetail,
            'receiveDetailDataProvider' => $receiveDetailDataProvider,
        ));
    }
    
    public function actionUpdateReceive($id) {
        $receiveDetail = ReceiveDetail::model()->findByPk($id);

        if (isset($_POST['Submit'])) {
            $receiveDetail->attributes = $_POST['ReceiveDetail'];
            
            if ($receiveDetail->is_inactive == 1) {
                $receiveDetail->delete();
            } else {
                $receiveDetail->update();
            }
            
            $this->redirect(array('adminReceive'));
        }

        $this->render('update_receive', array(
            'receiveDetail' => $receiveDetail,
        ));
    }
    
    public function actionAjaxJsonGetReceiveWeight($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $object = array(
                'weight' => CHtml::encode($this->getReceiveWeightCalculation($id)),
            );

            echo CJSON::encode($object);
        }
    }
    
    public function getReceiveWeightCalculation($id) {
        $receiveDetail = ReceiveDetail::model()->findByPk($id);
        $height = $_POST['ReceiveDetail']['height'];
        $width = $_POST['ReceiveDetail']['width'];
        $length = $_POST['ReceiveDetail']['length'];
        $mass = CHtml::value($receiveDetail, 'productCategory.mass');

        if ($receiveDetail->product_category_id == 2 || $receiveDetail->product_category_id == 5) {
            $weightRequest = $length * $height * $height * $mass;
        } else {
            $weightRequest = $length * $width * $height * $mass;
        }

        return $weightRequest;
    }

    public function actionAdminCutting() {

        $workOrderCuttingDetailMaterial = Search::bind(new WorkOrderCuttingDetailMaterial(), isset($_GET['WorkOrderCuttingDetailMaterial']) ? $_GET['WorkOrderCuttingDetailMaterial'] : '');
        $receiveSerialNumber = isset($_GET['ReceiveSerialNumber']) ? $_GET['ReceiveSerialNumber'] : '';
        
        $workOrderCuttingDetailMaterialDataProvider = $workOrderCuttingDetailMaterial->searchProcessedStock();
        $workOrderCuttingDetailMaterialDataProvider->criteria->with = array('receiveDetail');
        
        $workOrderCuttingDetailMaterialDataProvider->criteria->addCondition("receiveDetail.serial_number LIKE :serial_number");
        $workOrderCuttingDetailMaterialDataProvider->criteria->params[':serial_number'] = "%{$receiveSerialNumber}%";

        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.height', $workOrderCuttingDetailMaterial->height);
        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.width', $workOrderCuttingDetailMaterial->width);
        $workOrderCuttingDetailMaterialDataProvider->criteria->compare('t.length', $workOrderCuttingDetailMaterial->length);

        $this->render('admin_cutting', array(
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
            'workOrderCuttingDetailMaterialDataProvider' => $workOrderCuttingDetailMaterialDataProvider,
            'receiveSerialNumber' => $receiveSerialNumber,
        ));
    }
    
    public function actionUpdateCutting($id) {
        $workOrderCuttingDetailMaterial = WorkOrderCuttingDetailMaterial::model()->findByPk($id);

        if (isset($_POST['Submit'])) {
            $workOrderCuttingDetailMaterial->attributes = $_POST['WorkOrderCuttingDetailMaterial'];
            
            if ($workOrderCuttingDetailMaterial->is_inactive == 1) {
                $workOrderCuttingDetailMaterial->delete();
            } else {
                $workOrderCuttingDetailMaterial->update();
            }
            
            $this->redirect(array('adminCutting'));
        }

        $this->render('update_cutting', array(
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
        ));
    }
    
    public function actionAjaxJsonGetCuttingWeight($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $object = array(
                'weight' => CHtml::encode($this->getCuttingWeightCalculation($id)),
            );

            echo CJSON::encode($object);
        }
    }
    
    public function getCuttingWeightCalculation($id) {
        $workOrderCuttingDetailMaterial = WorkOrderCuttingDetailMaterial::model()->findByPk($id);
        $height = $_POST['WorkOrderCuttingDetailMaterial']['height'];
        $width = $_POST['WorkOrderCuttingDetailMaterial']['width'];
        $length = $_POST['WorkOrderCuttingDetailMaterial']['length'];
        $mass = CHtml::value($workOrderCuttingDetailMaterial, 'productCategory.mass');

        if ($workOrderCuttingDetailMaterial->product_category_id == 2 || $workOrderCuttingDetailMaterial->product_category_id == 5) {
            $weightRequest = $length * $height * $height * $mass;
        } else {
            $weightRequest = $length * $width * $height * $mass;
        }

        return $weightRequest;
    }
}