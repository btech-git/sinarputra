<?php

class InventoryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('inventoryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $inventory = Search::bind(new Inventory('search'), isset($_GET['Inventory']) ? $_GET['Inventory'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        //$status = (isset($_GET['Status'])) ? $_GET['Status'] : '';
        $customerId = (isset($_GET['customerId'])) ? $_GET['customerId'] : '';

        $inventorySummary = new InventorySummary($inventory->search());
        $inventorySummary->setupLoading();
        $inventorySummary->setupPaging($pageSize, $currentPage);
        $inventorySummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerId' => $customerId,
                //'status' => $status
        );
        $inventorySummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($inventorySummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'inventory' => $inventory,
            'inventorySummary' => $inventorySummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerId' => $customerId,
                //'status' => $status
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotalTransaction;

        return $grandTotal;
    }

    protected function saveToExcel($inventorySummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Inventory');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Inventory');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        $worksheet->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Inventory');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:S4');
        //$worksheet->mergeCells('A5:K5');

        $worksheet->getStyle("A5:S6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:S6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:S6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Penjualan #');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'PO');
        $worksheet->setCellValue('E6', 'Catatan');
        $worksheet->setCellValue('F6', 'Penawaran #');
        $worksheet->setCellValue('G5', 'Permintaan');
        $worksheet->setCellValue('G6', 'GRADE');
        $worksheet->setCellValue('H6', 'Panjang');
        $worksheet->setCellValue('I6', 'Lebar');
        $worksheet->setCellValue('J6', 'Tinggi');
        $worksheet->setCellValue('K6', 'Quantity');
        $worksheet->setCellValue('L5', 'Penawaran');
        $worksheet->setCellValue('L6', 'GRADE');
        $worksheet->setCellValue('M6', 'Panjang');
        $worksheet->setCellValue('N6', 'Lebar');
        $worksheet->setCellValue('O6', 'Tinggi');
        $worksheet->setCellValue('P6', 'Quantity');
        $worksheet->setCellValue('Q6', 'Berat');
        $worksheet->setCellValue('R6', 'Harga Satuan');
        $worksheet->setCellValue('S6', 'Total');

        $counter = 7;

        foreach ($inventorySummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(SaleHeader::CN_CONSTANT)));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer_order_number')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                    

            $counter++;

            
        }


        $counter++;

        for ($col = 'A'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Inventory.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
