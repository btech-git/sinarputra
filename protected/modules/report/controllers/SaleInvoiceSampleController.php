<?php

class SaleInvoiceSampleController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $saleInvoiceHeader = Search::bind(new SaleInvoiceHeader('search'), isset($_GET['SaleInvoiceHeader']) ? $_GET['SaleInvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $saleInvoiceSampleSummary = new SaleInvoiceSampleSummary($saleInvoiceHeader->search());
        $saleInvoiceSampleSummary->setupLoading();
        $saleInvoiceSampleSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSampleSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $saleInvoiceSampleSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleInvoiceSampleSummary, $startDate, $endDate);
        }


        $this->render('summary', array(
            'saleInvoiceHeader' => $saleInvoiceHeader,
            'saleInvoiceSampleSummary' => $saleInvoiceSampleSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

    protected function saveToExcel($saleInvoiceSampleSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra');
        $documentProperties->setTitle('Laporan Faktur Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Penjualan');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Sistem');
        $worksheet->setCellValue('A2', 'Laporan Faktur Penjualan (Sample)');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:E4');
        //$worksheet->mergeCells('A5:K5');

        $worksheet->getStyle("A6:E6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:E6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:E6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No Invoice');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'Total');
        $worksheet->setCellValue('E6', 'User');
        
        $counter = 7;

        foreach ($saleInvoiceSampleSummary->dataProvider->data as $header) {

            $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
            $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company'));
            $worksheet->setCellValue("D{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->grandTotal));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'workOrderCuttingHeader.admin.name'));

            $counter++;

        }

        $worksheet->getStyle("A{$counter}:D{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("C{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("C{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("D{$counter}", Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($saleInvoiceSampleSummary->dataProvider))));

        $counter++;

        for ($col = 'A'; $col !== 'D'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Faktur Penjualan (Sample).xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
