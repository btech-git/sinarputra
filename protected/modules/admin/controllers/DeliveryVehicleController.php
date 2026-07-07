<?php

class DeliveryVehicleController extends CrudController
{
	public $layout = '//layouts/column2';

	public function filters()
	{
		return array(
//			'accessControl',
		);
	}

	public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!Yii::app()->user->checkAccess('hrgaCreateMaster'))
                $this->redirect(array('/site/login'));
        } 
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'delete') {
            if (!Yii::app()->user->checkAccess('hrgaEditMaster'))
                $this->redirect(array('/site/login'));            
        } 
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin') {
            if (!(Yii::app()->user->checkAccess('hrgaCreateMaster') || 
            Yii::app()->user->checkAccess('hrgaEditMaster') || 
            Yii::app()->user->checkAccess('hrgaViewMaster')))
                $this->redirect(array('/site/login'));            
        }

        $filterChain->run();
    }

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create', 'update'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin', 'delete'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view', array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model = new DeliveryVehicle;

		if (isset($_POST['DeliveryVehicle']))
		{
			$model->attributes = $_POST['DeliveryVehicle'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('create', array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if (isset($_POST['DeliveryVehicle']))
		{
			$model->attributes = $_POST['DeliveryVehicle'];
			if ($model->save())
				$this->redirect(array('view', 'id'=>$model->id));
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('DeliveryVehicle');
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model = new DeliveryVehicle('search');
		$model->unsetAttributes();
		if (isset($_GET['DeliveryVehicle']))
			$model->attributes = $_GET['DeliveryVehicle'];

		$this->render('admin', array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = DeliveryVehicle::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
}
