<?php

class PurchasePaymentDetailController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchasePaymentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $purchasePaymentHeader = Search::bind(new PurchasePaymentHeader('search'), isset($_GET['PurchasePaymentHeader']) ? $_GET['PurchasePaymentHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';
    
        $purchasePaymentSummary = new PurchasePaymentSummary($purchasePaymentHeader->search());
        $purchasePaymentSummary->setupLoading();
        $purchasePaymentSummary->setupPaging($pageSize, $currentPage);
        $purchasePaymentSummary->setupSorting();
        $purchasePaymentSummary->setupFilter($startDate, $endDate, $supplierName);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchasePaymentSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchasePaymentHeader' => $purchasePaymentHeader,
            'purchasePaymentSummary' => $purchasePaymentSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
        ));
    }

    protected function saveToExcel($purchasePaymentSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Pembayaran Pembelian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembayaran Pembelian');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        $worksheet->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Pembayaran Pembelian');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:L4');
    
        $worksheet->getStyle("A6:L6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:L6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:L6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tgl');
        $worksheet->setCellValue('B6', 'NO Pembayaran');
        $worksheet->setCellValue('C6', 'Kode Supplier');
        $worksheet->setCellValue('D6', 'Supplier');
        $worksheet->setCellValue('E6', 'Jenis');
        $worksheet->setCellValue('F6', 'TT #');
        $worksheet->setCellValue('G6', 'Tgl TT');
        $worksheet->setCellValue('H6', 'Tgl JT');
        $worksheet->setCellValue('I6', 'Jumlah');
        $worksheet->setCellValue('J6', 'User');
        $worksheet->setCellValue('K6', 'Keterangan');
        $worksheet->setCellValue('L6', 'Catatan');

        $counter = 7;

        foreach ($purchasePaymentSummary->dataProvider->data as $header) {
            $lastId = '';
            foreach ($header->purchasePaymentDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->date));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(PurchasePaymentHeader::CN_CONSTANT)));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.supplier.code')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'purchaseReceiptHeader.supplier.company')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'paymentType.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($header->purchaseReceiptHeader->getCodeNumber(PurchaseReceiptHeader::CN_CONSTANT)));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($header->purchaseReceiptHeader->date));
                $worksheet->setCellValue("H{$counter}", (empty($header->purchaseReceiptHeader->due_date)) ? '' : CHtml::encode($header->purchaseReceiptHeader->due_date));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'amount')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'admin.username')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'note')));

                $lastId = $header->id; 
                $counter++;
            }

        }

        $counter++;

        for ($col = 'A'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Pelunasan Pembelian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
