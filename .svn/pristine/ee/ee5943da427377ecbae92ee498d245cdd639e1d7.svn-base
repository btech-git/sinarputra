<?php

class PaymentTypeController extends CrudController {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!Yii::app()->user->checkAccess('accountingCreateMaster'))
                $this->redirect(array('/site/login'));
        } 
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'delete') {
            if (!Yii::app()->user->checkAccess('accountingEditMaster'))
                $this->redirect(array('/site/login'));            
        } 
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('accountingCreateMaster') || 
            Yii::app()->user->checkAccess('accountingEditMaster') || 
            Yii::app()->user->checkAccess('accountingViewMaster')))
                $this->redirect(array('/site/login'));            
        }

        $filterChain->run();
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new PaymentType;

        if (isset($_POST['PaymentType'])) {
            $model->attributes = $_POST['PaymentType'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['PaymentType'])) {
            $model->attributes = $_POST['PaymentType'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $this->loadModel($id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('PaymentType');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new PaymentType('search');
        $model->unsetAttributes();
        if (isset($_GET['PaymentType']))
            $model->attributes = $_GET['PaymentType'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = PaymentType::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
