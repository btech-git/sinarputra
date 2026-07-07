<?php

class ManualSaleReceiptController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleReceiptReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $saleReceiptDetail = Search::bind(new ManualSaleReceiptDetail('search'), isset($_GET['ManualSaleReceiptDetail']) ? $_GET['ManualSaleReceiptDetail'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
    
        $saleReceiptDetailSummary = new ManualSaleReceiptDetailSummary($saleReceiptDetail->search());
        $saleReceiptDetailSummary->setupLoading();
        $saleReceiptDetailSummary->setupPaging($pageSize, $currentPage);
        $saleReceiptDetailSummary->setupSorting();
        $saleReceiptDetailSummary->setupFilter($startDate, $endDate, $customerName);

        if (isset($_POST['SaveToExcel']))
            $this->saveToExcel($saleReceiptDetailSummary, $startDate, $endDate);

        $this->render('summary', array(
            'saleReceiptDetail' => $saleReceiptDetail,
            'saleReceiptDetailSummary' => $saleReceiptDetailSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function saveToExcel($saleReceiptDetailSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan TT Penjualan Manual');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan TT Penjualan Manual');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');
        $worksheet->getStyle('A1:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Tanda Terima Penjualan Manual');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:K4');
    
        $worksheet->getStyle("A6:K6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:K6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:K6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'TT #');
        $worksheet->setCellValue('C6', 'Tgl Cetak');
        $worksheet->setCellValue('D6', 'Tgl Terima');
        $worksheet->setCellValue('E6', 'Kurir');
        $worksheet->setCellValue('F6', 'Customer');
        $worksheet->setCellValue('G6', 'TOP');
        $worksheet->setCellValue('H6', 'Invoice #');
        $worksheet->setCellValue('I6', 'Tgl Invoice');
        $worksheet->setCellValue('J6', 'TOTAL');
        $worksheet->setCellValue('K6', 'Memo');
    
        $counter = 7;
        $number = 1;

        foreach ($saleReceiptDetailSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $number);
            $number++;
            $saleReceiptHeader = $header->manualSaleReceiptHeader;
            $saleInvoiceHeader = $header->manualSaleInvoiceHeader;
            $worksheet->setCellValue("B{$counter}", $saleReceiptHeader->getCodeNumber(ManualSaleReceiptHeader::CN_CONSTANT));
            $worksheet->setCellValue("C{$counter}", $saleReceiptHeader->date);
            $worksheet->setCellValue("D{$counter}", $saleReceiptHeader->date_receipt);
            $worksheet->setCellValue("E{$counter}", $saleReceiptHeader->courier_name);
            $worksheet->setCellValue("F{$counter}", $saleReceiptHeader->customer->company);
            $worksheet->setCellValue("G{$counter}", $saleReceiptHeader->customer->invoice_due_days);
            $worksheet->setCellValue("H{$counter}", $saleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT));
            $worksheet->setCellValue("I{$counter}", $saleInvoiceHeader->date);
            $worksheet->setCellValue("J{$counter}", $saleInvoiceHeader->grand_total);
            $worksheet->setCellValue("K{$counter}", $header->memo);

            $counter++;
        }

        $counter++;

        for ($col = 'A'; $col !== 'K'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Tanda Terima Penjualan Manual.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
