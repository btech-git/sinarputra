<?php

class SaleOmzetCustomerController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $sql = SqlViewGenerator::customerMonthlySales();

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        $records = array();
        $year = intval(date('Y'));
        $month = intval(date('m'));
        for ($i = 0; $i < 12; $i++) {
            $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            $records[$yearMonth] = 0;
            $month--;
            if ($month <= 0) {
                $month += 12;
                $year--;
            }
        }
        ksort($records);

        $data = array();
        $lastId = '';
        foreach ($resultSet as $item) {
            if ($lastId != $item['customer_id']) {
                $data[$item['customer_id']]['code'] = $item['customer_code'];
                $data[$item['customer_id']]['company'] = $item['customer_company'];
                $data[$item['customer_id']]['values'] = $records;
            }
            $month = intval($item['month']);
            $year = intval($item['year']);
            $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            if (isset($data[$item['customer_id']]['values'][$yearMonth])) {
                $data[$item['customer_id']]['values'][$yearMonth] = doubleval($item['grand_total']);
            }
            $lastId = $item['customer_id'];
        }

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($data, $records);
        }

        $this->render('summary', array(
            'data' => $data,
            'records' => $records,
        ));
    }

    protected function saveToExcel($data, $records) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Omzet per Customer General');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Omzet per Customer');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->getStyle('A1:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Omzet Per Customer General');

        $worksheet->mergeCells('A4:M4');

        $worksheet->getStyle("A6:M6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:M6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:M6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Code');
        $worksheet->setCellValue('B6', 'Customer');
        $worksheet->setCellValue('C6', 'SE');
        
        $counter = 7;
        $column = 'C';

        foreach ($records as $yearMonth => $record)
        {
            $worksheet->setCellValue("{$column}{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('MMM yyyy', strtotime($yearMonth))));
            $column++;
        }

        $counter++;

        foreach ($data as $customerId => $item)
        {
            $column = 'C';
            $worksheet->getStyle("C{$counter}:N{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($item['code']));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($item['company']));
            foreach ($item['values'] as $yearMonth => $amount)
            {
                $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($amount));
                $column++;
            }
            $counter++;
        }

        for ($col = 'A'; $col !== 'N'; $col++) {
            $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Omzet Per Customer General.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}

