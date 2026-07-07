<?php

class ProductController extends CrudController {

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

    public function loadModel($id) {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($model) {
        if (isset($_POST['Product'])) {
            $model->header->attributes = $_POST['Product'];
        }
        if (isset($_POST['ProductSize'])) {
            foreach ($_POST['ProductSize'] as $i => $item) {
                if (isset($model->details[$i]))
                    $model->details[$i]->attributes = $item;
                else {
                    $detail = new ProductSize();
                    $detail->attributes = $item;
                    $model->details[] = $detail;
                }
            }
            if (count($_POST['ProductSize']) < count($model->details))
                array_splice($model->details, $i + 1);
        }
        else
            $model->details = array();
    }

    public function instantiate($id) {
        if (empty($id))
            $model = new ProductComponent(new Product, array());
        else {
            $header = $this->loadModel($id);
            $model = new ProductComponent($header, $header->productSizes);
        }

        return $model;
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = $this->instantiate(null);

        if (isset($_POST['Product'])) {
            $this->loadState($model);
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->instantiate($id);

        if (isset($_POST['Product'])) {
            $this->loadState($model);
            if ($model->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $model->header->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);
            if ($model->delete(Yii::app()->db))
                Yii::app()->user->setFlash('message', 'Delete Successful');
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Product');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Product('search');
        $model->unsetAttributes();
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);
            $this->loadState($model);

            $model->addDetail();

            $this->renderPartial('_detail', array(
                'model' => $model,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->instantiate($id);
            $this->loadState($model);

            $model->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'model' => $model,
            ));
        }
    }

}
