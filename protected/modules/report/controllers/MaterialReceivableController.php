<?php

class MaterialReceivableController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('salePaymentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $materialInvoiceHeader = Search::bind(new MaterialInvoiceHeader('search'), isset($_GET['MaterialInvoiceHeader']) ? $_GET['MaterialInvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
    
        $materialReceivableSummary = new MaterialReceivableSummary($materialInvoiceHeader->search());
        $materialReceivableSummary->setupLoading();
        $materialReceivableSummary->setupPaging($pageSize, $currentPage);
        $materialReceivableSummary->setupSorting();
        $materialReceivableSummary->setupFilter($startDate, $endDate);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($materialReceivableSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'materialInvoiceHeader' => $materialInvoiceHeader,
            'materialReceivableSummary' => $materialReceivableSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($materialReceivableSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Outstanding Material Invoice');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Outstanding Material INV');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');
        $worksheet->getStyle('A1:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Outstanding Material Invoice');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:N4');
    
        $worksheet->getStyle("A6:N6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:N6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:N6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Tgl Nota');
        $worksheet->setCellValue('C6', 'TOP (hari)');
        $worksheet->setCellValue('D6', 'No Nota');
        $worksheet->setCellValue('E6', 'Faktur Pajak');
        $worksheet->setCellValue('F6', 'Kode Customer');
        $worksheet->setCellValue('G6', 'Customer');
        $worksheet->setCellValue('H6', 'Salesman');
        $worksheet->setCellValue('I6', 'User');
        $worksheet->setCellValue('J6', 'TOTAL');
        $worksheet->setCellValue('K6', 'Pelunasan');
        $worksheet->setCellValue('L6', 'Sisa');
    
        $counter = 7;
        $number = 1;

        foreach ($materialReceivableSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $number);
            $number++;
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.invoice_due_days')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode($header->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT)));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'tax_number')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'customer.code')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'employeeIdSalesman.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'total_payment')));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'remaining_payment')));

            $counter++;
        }

        $counter++;

        for ($col = 'A'; $col !== 'N'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Outstanding Material Invoice.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
