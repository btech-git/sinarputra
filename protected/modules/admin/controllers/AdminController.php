<?php

class AdminController extends CrudController {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'create'
                || $filterChain->action->id === 'update'
                || $filterChain->action->id === 'delete'
                || $filterChain->action->id === 'admin') {
            if (!Yii::app()->user->checkAccess('master'))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionPassword($id) {
        $admin = $this->loadModel($id);
        $admin->scenario = 'changePassword';

        if (isset($_POST['Admin'])) {
            $admin->attributes = $_POST['Admin'];

            $validateFields = array('current_password', 'new_password', 'confirm_password');
            $updateFields = array('password', 'salt');

            if ($admin->validate($validateFields) && $admin->update($updateFields))
                $this->redirect(array('view', 'id' => $admin->id));
        }

        $this->render('password', array(
            'admin' => $admin,
        ));
    }

    public function actionCreate() {
        $model = new Admin;

        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            $model->beforeSave();
            
            $fileSignature = CUploadedFile::getInstanceByName('file_signature');
            $model->file_signature = $fileSignature;
            $model->file_extension_signature = $fileSignature;

            if ($model->save()) {
                $this->saveImageFile($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            
            $fileSignature = CUploadedFile::getInstanceByName('file_signature');
            if ($fileSignature != null) {
                $model->file_signature = $fileSignature;
                $model->file_extension_signature = $fileSignature;
            }

            if ($model->save()) {
//                $this->saveImageFile($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
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
        $dataProvider = new CActiveDataProvider('Admin');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Admin('search');
        $model->unsetAttributes();
        if (isset($_GET['Admin']))
            $model->attributes = $_GET['Admin'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Admin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function saveImageFile($model) {
        if ($model->file_signature) {
            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/signature/' . $model->file_extension_signature;
            $model->file_signature->saveAs($originalPath);

            require_once( dirname(Yii::app()->request->scriptFile) . '/protected/extensions/phpthumb/ThumbLib.inc.php' );

            $image = PhpThumbFactory::create($originalPath);
            $image->resize(1024, 768)->save($originalPath);
        }
    }
}
