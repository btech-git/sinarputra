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
        $supplierId = isset($_GET['SupplierId']) ? $_GET['SupplierId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

//		$dataProvider = $purchaseHeader->search();
//		$dataProvider->criteria->with = array('supplier');

        $receiveSummary = new ReceiveSummary($receiveHeader->search());
        $receiveSummary->setupLoading();
        $receiveSummary->setupPaging($pageSize, $currentPage);
        $receiveSummary->setupSorting();
        $receiveSummary->setupFilter($startDate, $endDate, $supplierId);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($receiveSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'receiveHeader' => $receiveHeader,
            'receiveSummary' => $receiveSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierId' => $supplierId,
        ));
    }

    protected function saveToExcel($receiveSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Nobleman');
        $documentProperties->setTitle('Laporan Penerimaan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penerimaan Barang');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        $worksheet->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Penerimaan Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:O4');
        $worksheet->mergeCells('A5:O5');

        $worksheet->getStyle("A6:O6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:O6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:O6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Penerimaan');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('D6', 'Warehouse');
        $worksheet->setCellValue('E6', 'PO#');
        $worksheet->setCellValue('F6', 'Catatan');
        $worksheet->setCellValue('G6', 'Grade');
        $worksheet->setCellValue('H6', 'Panjang');
        $worksheet->setCellValue('I6', 'Lebar');
        $worksheet->setCellValue('J6', 'Tinggi');
        $worksheet->setCellValue('K6', 'Berat');
        $worksheet->setCellValue('L6', 'Quantity Order');
        $worksheet->setCellValue('M6', 'Quantity Terima');
        $worksheet->setCellValue('N6', 'Lokasi');
        $worksheet->setCellValue('O6', 'User');

        $counter = 7;

        foreach ($receiveSummary->dataProvider->data as $header) {

                    foreach ($header->receiveDetails as $detail) {
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                        $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(ReceiveHeader::CN_CONSTANT)));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header,'supplier.company')));
                        $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header,'warehouse.name')));
                        $worksheet->setCellValue("E{$counter}", $header->purchaseHeader ? CHtml::encode($header->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)) : "");
                        $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header,'note')));
                        $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail,'product_name')));
                        $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail,'length')));
                        $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail,'width')));
                        $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail,'height')));
                        $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail,'weight')));
                        $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml:: value($detail, 'purchaseDetail.quantity')));
                        $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml:: value($detail, 'receiveItemDetail.quantity')));
                        $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail,'location.name')));
                        $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));

                        

                        $counter++;
                    }
        }



        for ($col = 'A'; $col !== 'I'; $col++) {
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
