<?php

class SaleDailyController extends Controller {

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
		
        $saleHeader = Search::bind(new SaleHeader('search'), isset($_GET['SaleHeader']) ? $_GET['SaleHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $saleSummary = new SaleSummary($saleHeader->search());
        $saleSummary->setupLoading();
        $saleSummary->setupPaging($pageSize, $currentPage);
        $saleSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $saleSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'saleHeader' => $saleHeader,
            'saleSummary' => $saleSummary,
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

    protected function saveToExcel($saleSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Penjualan Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan  C3 Harian (PO)');

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');
        $worksheet->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:T3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan C3 Harian (PO)');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:T5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:T5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:T5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $worksheet->getStyle('A5:T5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'NO');
        $worksheet->setCellValue('B5', 'Nama Perusahaan');
        $worksheet->setCellValue('C5', 'NO PO');
        $worksheet->setCellValue('D5', 'Qty PO');
        $worksheet->setCellValue('E5', 'PO Pending');
        $worksheet->setCellValue('F5', 'Lembaran / Batangan ?');
        $worksheet->setCellValue('G5', 'Tgl PO');
        $worksheet->setCellValue('H5', 'Tgl Kirim');
        $worksheet->setCellValue('I5', 'ACC');
        $worksheet->setCellValue('J5', 'Price');
        $worksheet->setCellValue('K5', 'Jam SO');
        $worksheet->setCellValue('L5', 'Jam SPK');
        $worksheet->setCellValue('M5', 'NO SO');
        $worksheet->setCellValue('N5', 'NO SPK');
        $worksheet->setCellValue('O5', 'Catatan');
        $worksheet->setCellValue('P5', 'Status');
        $worksheet->setCellValue('Q5', 'User');
        $worksheet->setCellValue('R5', 'Salesman');
        $worksheet->setCellValue('S5', 'Barang / Jasa');
        $worksheet->setCellValue('T5', 'New / Replacement');

        $counter = 6;
        $number = 1;

        foreach ($saleSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $number);
            $number++;
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->customer_order_number));
            $worksheet->setCellValue("D{$counter}", CHtml::encode($header->totalQuantity));
            $worksheet->setCellValue("E{$counter}", CHtml::encode($header->orderStatus));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($header->originalMaterialStatus));
            $worksheet->setCellValue("G{$counter}", $header->customer_order_date);
            $worksheet->setCellValue("H{$counter}", $header->estimate_delivery_date);
            $worksheet->setCellValue("I{$counter}", "Yes") ;
            $worksheet->setCellValue("J{$counter}", CHtml::encode($header->grandTotalTransaction));
            $worksheet->setCellValue("K{$counter}", CHtml::encode($header->time_created));
            $worksheet->setCellValue("L{$counter}", !empty($header->workOrderCuttingHeaders) ? CHtml::encode($header->workOrderCuttingHeaders[0]->time_created) : "N/A");
            $worksheet->setCellValue("M{$counter}", CHtml::encode($header->getCodeNumber(SaleHeader::CN_CONSTANT)));
            $worksheet->setCellValue("N{$counter}", !empty($header->workOrderCuttingHeaders) ? $header->workOrderCuttingHeaders[0]->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT) : "N/A");
            $worksheet->setCellValue("O{$counter}", !empty($header->workOrderCuttingHeaders) ? $header->workOrderCuttingHeaders[0]->note : "N/A");
            $worksheet->setCellValue("P{$counter}", !empty($header->workOrderCuttingHeaders) ? $header->workOrderCuttingHeaders[0]->progressStatus : "N/A");
            $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));
            $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($header,'employeeIdSalesman.name')));
            $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($header,'productServiceStatus')));
            $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header,'transactionStatus')));

            $counter++;
        }

        for ($col = 'A'; $col !== 'T'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan C3 Harian (PO).xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
