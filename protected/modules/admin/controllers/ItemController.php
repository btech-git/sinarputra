<?php

class ItemController extends CrudController {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!Yii::app()->user->checkAccess('purchaseCreateMaster')) {
                $this->redirect(array('/site/login'));
            }
        } 
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'delete') {
            if (!Yii::app()->user->checkAccess('purchaseEditMaster')) {
                $this->redirect(array('/site/login'));
            }
        } 
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin') {
            if (!(
                Yii::app()->user->checkAccess('purchaseCreateMaster') || 
                Yii::app()->user->checkAccess('purchaseEditMaster') || 
                Yii::app()->user->checkAccess('purchaseViewMaster')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Item;

        if (isset($_POST['Item'])) {
            $model->attributes = $_POST['Item'];
            
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Item'])) {
            $model->attributes = $_POST['Item'];
            
            if ($model->save()) {
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

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Item');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Item('search');
        
        $model->unsetAttributes();
        if (isset($_GET['Item'])) {
            $model->attributes = $_GET['Item'];
        }

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel();
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Item::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    protected function saveToExcel() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $items = Item::model()->findAll(array('condition' => 'is_inactive = 0', 'order' => 't.code ASC'));


        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Data Item');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Data Item');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');

        $worksheet->getStyle('A1:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G4')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Data Item');

        $worksheet->getStyle('A4:G4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A4', 'Code');
        $worksheet->setCellValue('B4', 'Name');
        $worksheet->setCellValue('C4', 'Description');
        $worksheet->setCellValue('D4', 'Category');
        $worksheet->setCellValue('E4', 'Satuan');
        $worksheet->setCellValue('F4', 'COA Inventory');
        $worksheet->setCellValue('G4', 'COA Biaya');

        $worksheet->getStyle('A4:G4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 5;
        foreach ($items as $i => $model) {

            $worksheet->setCellValue("A{$counter}", CHtml::value($model, 'code'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($model, 'name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($model, 'description'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($model, 'itemCategory.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($model, 'unit.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($model, 'accountIdInventory.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($model, 'accountIdExpense.name'));
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Data Item.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}