<?php

class CustomerController extends CrudController {

    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!Yii::app()->user->checkAccess('accountingCreateMaster')) {
                $this->redirect(array('/site/login'));
            }
        } 
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'delete') {
            if (!Yii::app()->user->checkAccess('accountingEditMaster')) {
                $this->redirect(array('/site/login'));
            }
        } 
        if ($filterChain->action->id === 'view' || $filterChain->action->id === 'admin') {
            if (!(
                Yii::app()->user->checkAccess('accountingCreateMaster') || 
                Yii::app()->user->checkAccess('accountingEditMaster') || 
                Yii::app()->user->checkAccess('accountingViewMaster')
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
        $model = new Customer;

        if (isset($_POST['Customer']) && IdempotentManager::check()) {
            $model->attributes = $_POST['Customer'];
            $model->date_created = date('Y-m-d H:m:s');
            $model->date_updated = null;
            $model->admin_id_updated = null;
            
            if ($model->validateCreditLimit() && IdempotentManager::build()->save() && $model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->date_updated = date('Y-m-d H:m:s');
        $model->admin_id_updated = Yii::app()->user->id;

        if (isset($_POST['Customer'])) {
            $model->attributes = $_POST['Customer'];
            if ($model->validateCreditLimit() && $model->save()) {
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
        $dataProvider = new CActiveDataProvider('Customer');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new Customer('search');
        $model->unsetAttributes();
        
        if (isset($_GET['Customer'])) {
            $model->attributes = $_GET['Customer'];
        }
        
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel();
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Customer::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }
    
    protected function saveToExcel() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $criteria = new CDbCriteria();
        $criteria->compare('t.is_inactive', 0);
        $customers = Customer::model()->findAll($criteria);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Master Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Master Customer');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');

        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Master Customer');

        $worksheet->getStyle("A5:O5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:O5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:O5')->getFont()->setBold(true);

        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Name');
        $worksheet->setCellValue('C5', 'Company');
        $worksheet->setCellValue('D5', 'Address');
        $worksheet->setCellValue('E5', 'Phone');
        $worksheet->setCellValue('F5', 'Note');
        $worksheet->setCellValue('G5', 'TOP');
        $worksheet->setCellValue('H5', 'Kredit Limit');
        $worksheet->setCellValue('I5', 'Sisa Limit');
        $worksheet->setCellValue('J5', 'NPWP');
        $worksheet->setCellValue('K5', 'Pajak Atas Nama');
        $worksheet->setCellValue('L5', 'Alamat Pajak');
        $worksheet->setCellValue('M5', 'Kategori');
        $worksheet->setCellValue('N5', 'Salesman');
        $worksheet->setCellValue('O5', 'PPN/Non');
        $worksheet->setCellValue('P5', 'Status');
        
        $counter = 6;

        foreach ($customers as $customer) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode($customer->code));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($customer->name));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($customer, 'company')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode($customer->address_main));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($customer, 'phone')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($customer, 'note')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($customer, 'invoice_due_days')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($customer, 'credit_limit')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($customer, 'remainingCreditLimit')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($customer, 'tax_registration_number')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($customer, 'tax_name')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($customer, 'completeTaxAddress')));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($customer, 'customerType')));
            $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($customer, 'employee.name')));
            $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($customer, 'taxStatus')));
            $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($customer, 'status')));

            $counter ++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Master Customer.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
