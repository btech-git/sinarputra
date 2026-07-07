<?php

class SaleOmzetSalesmanController extends Controller {

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
		
        $sql = SqlViewGenerator::salesmanMonthlySales();

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
            if ($lastId != $item['employee_id_salesman']) {
                $data[$item['employee_id_salesman']]['name'] = $item['employee_name'];
                $data[$item['employee_id_salesman']]['values'] = $records;
            }
            $month = intval($item['month']);
            $year = intval($item['year']);
            $yearMonth = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            if (isset($data[$item['employee_id_salesman']]['values'][$yearMonth])) {
                $data[$item['employee_id_salesman']]['values'][$yearMonth] = doubleval($item['grand_total']);
            }
            $lastId = $item['employee_id_salesman'];
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
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Penjualan By Salesman');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penjualan By Salesman');

        $worksheet->mergeCells('A1:C1');
        $worksheet->mergeCells('A2:C2');
        $worksheet->mergeCells('A3:C3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:C3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Penjualan By Salesman');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:C4');

        $worksheet->getStyle("A6:C6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:C6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:C6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Salesman Name');
        $worksheet->setCellValue('C6', 'Salesman Code');
        
        $counter = 7;
        $column = 'B';

        foreach ($records as $yearMonth => $record)
        {
            $worksheet->setCellValue("{$column}{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('MMM yyyy', strtotime($yearMonth))));
            $column++;
        }

        $counter++;

        foreach ($data as $customerId => $item)
        {
            $column = 'B';
            $worksheet->getStyle("B{$counter}:M{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($item['name']));
            foreach ($item['values'] as $yearMonth => $amount)
            {
                $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($amount));
                $column++;
            }
            $counter++;
        }

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Omzet Per Salesman General.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}

