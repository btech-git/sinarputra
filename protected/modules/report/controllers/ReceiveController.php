<?php

class ReceiveController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('receiveReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $receiveHeader = Search::bind(new ReceiveHeader('search'), isset($_GET['ReceiveHeader']) ? $_GET['ReceiveHeader'] : array());
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $receiveSummary = new ReceiveSummary($receiveHeader->search());
        $receiveSummary->setupLoading();
        $receiveSummary->setupPaging($pageSize, $currentPage);
        $receiveSummary->setupSorting();
        $receiveSummary->setupFilter($startDate, $endDate, $supplierName);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($receiveSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'receiveHeader' => $receiveHeader,
            'receiveSummary' => $receiveSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
        ));
    }

    protected function saveToExcel($receiveSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Penerimaan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penerimaan Barang');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        
        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'PT Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Penerimaan Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:O5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:O5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Penerimaan');
        $worksheet->setCellValue('C5', 'Supplier');
        $worksheet->setCellValue('D5', 'Warehouse');
        $worksheet->setCellValue('E5', 'PO #');
        $worksheet->setCellValue('F5', 'Catatan');
        $worksheet->setCellValue('G5', 'Grade');
        $worksheet->setCellValue('H5', 'Panjang');
        $worksheet->setCellValue('I5', 'Lebar');
        $worksheet->setCellValue('J5', 'Tinggi');
        $worksheet->setCellValue('K5', 'Berat');
        $worksheet->setCellValue('L5', 'Quantity Order');
        $worksheet->setCellValue('M5', 'Quantity Terima');
        $worksheet->setCellValue('N5', 'Lokasi');
        $worksheet->setCellValue('O5', 'User');

        $counter = 6;

        foreach ($receiveSummary->dataProvider->data as $header) {
            foreach ($header->receiveDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(ReceiveHeader::CN_CONSTANT));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header,'supplier.company'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header,'warehouse.name'));
                $worksheet->setCellValue("E{$counter}", $header->purchaseHeader ? $header->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT) : "");
                $worksheet->setCellValue("F{$counter}", CHtml::value($header,'note'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($detail,'product_name'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail,'length'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail,'width'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail,'height'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail,'weight'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'purchaseDetail.quantity'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'quantity'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($detail,'location.name'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($header,'admin.name'));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Penerimaan Barang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}