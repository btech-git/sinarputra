<?php

class ProductSizeController extends CrudController {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!Yii::app()->user->checkAccess('inventoryCreateMaster'))
                $this->redirect(array('/site/login'));
        } 
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'delete') {
            if (!Yii::app()->user->checkAccess('inventoryEditMaster'))
                $this->redirect(array('/site/login'));            
        } 
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('inventoryCreateMaster') || 
            Yii::app()->user->checkAccess('inventoryEditMaster') || 
            Yii::app()->user->checkAccess('inventoryViewMaster')))
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
        $model = new ProductSize;

        if (isset($_POST['ProductSize'])) {
            $model->attributes = $_POST['ProductSize'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['ProductSize'])) {
            $model->attributes = $_POST['ProductSize'];
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
        $dataProvider = new CActiveDataProvider('ProductSize');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new ProductSize('search');
        $model->unsetAttributes();
        if (isset($_GET['ProductSize']))
            $model->attributes = $_GET['ProductSize'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = ProductSize::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

}
