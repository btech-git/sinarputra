<?php

class SaleController extends Controller {

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

        $saleSummary = new SaleSummary($saleHeader->resetScope()->search());
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
            $grandTotal += $data->grandTotalTransaction;

        return $grandTotal;
    }

    protected function saveToExcel($saleSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
//        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
//        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Order Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Order Penjualan');

        $worksheet->mergeCells('A1:AC1');
        $worksheet->mergeCells('A2:AC2');
        $worksheet->mergeCells('A3:AC3');
        $worksheet->mergeCells('A4:AC4');
        
        $worksheet->getStyle('A1:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AC3')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan C3 by Order Penjualan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));
        

        $worksheet->getStyle("A5:AC6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AC6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AB6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Penjualan #');
        $worksheet->setCellValue('C6', 'Kode Customer');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'PO');
        $worksheet->setCellValue('F6', 'Catatan');
        $worksheet->setCellValue('G6', 'Penawaran #');
        $worksheet->mergeCells('H5:L5');
        $worksheet->getStyle('H5:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue('H5', 'Permintaan');
        $worksheet->setCellValue('H6', 'GRADE');
        $worksheet->setCellValue('I6', 'Panjang');
        $worksheet->setCellValue('J6', 'Lebar');
        $worksheet->setCellValue('K6', 'Tinggi');
        $worksheet->setCellValue('L6', 'Quantity');
        $worksheet->mergeCells('M5:Q5');
        $worksheet->getStyle('M5:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue('M5', 'Penawaran');
        $worksheet->setCellValue('M6', 'GRADE');
        $worksheet->setCellValue('N6', 'Panjang');
        $worksheet->setCellValue('O6', 'Lebar');
        $worksheet->setCellValue('P6', 'Tinggi');
        $worksheet->setCellValue('Q6', 'Quantity');
        $worksheet->setCellValue('R6', 'Berat');
        $worksheet->mergeCells('S5:T5');
        $worksheet->setCellValue('S5', 'TYPE');
        $worksheet->mergeCells('S6:T6');
        $worksheet->setCellValue('S6', 'PROSES');
        $worksheet->setCellValue('U6', 'Harga Satuan');
        $worksheet->setCellValue('V6', 'Total');
        $worksheet->setCellValue('W6', 'Sales');
        $worksheet->setCellValue('X6', 'User');
        $worksheet->setCellValue('Y6', 'Created');
        $worksheet->setCellValue('Z6', 'Edited');
        $worksheet->setCellValue('AA6', 'Barang / Jasa');
        $worksheet->setCellValue('AB6', 'Status');
        $worksheet->setCellValue('AC6', 'Lembaran / Batangan ?');

        $counter = 7;

        foreach ($saleSummary->dataProvider->data as $header) {
            foreach ($header->saleDetails as $detail) {
                $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByAttributes(array('sale_detail_id' => $detail->id));
                $detail = $header->is_service == 1 ? $detail->quotationDetailService : $detail->quotationDetailProduct;
                $worksheet->setCellValue("A{$counter}", $header->date);
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(SaleHeader::CN_CONSTANT)));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.code')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer_order_number')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($detail->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, $header->is_service == 1 ? 'product_name' : 'product_name_request')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'length_request')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'width_request')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'height_request')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_request')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, $header->is_service == 1 ? 'product_name' : 'product_name_quote')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'length_quote')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'width_quote')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'height_quote')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_quote')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                $worksheet->getStyle("S{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("S{$counter}", empty($workOrderCuttingDetail) ? "" : (int) $workOrderCuttingDetail->is_cut === 1 ? "C" : "");
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($detail, 'processList')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));
                $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($detail, 'total')));
                $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($header,'employeeIdSalesman.name')));
                $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));
                $worksheet->setCellValue("Y{$counter}", CHtml::encode($header->time_created));
                $worksheet->setCellValue("Z{$counter}", CHtml::encode($header->time_edited));
                $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header,'productServiceStatus')));
                $worksheet->setCellValue("AB{$counter}", CHtml::encode(CHtml::value($header,'status')));
                $worksheet->setCellValue("AC{$counter}", CHtml::encode(CHtml::value($header,'originalMaterialStatus')));

                $counter++;
            }
        }


        $worksheet->getStyle("A{$counter}:AC{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:AC{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("Q{$counter}:AC{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("R{$counter}:T{$counter}");
        $worksheet->setCellValue("R{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("U{$counter}", 'Rp');
        $worksheet->setCellValue("V{$counter}", $this->reportGrandTotal($saleSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'AC'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan C3 by Order Penjualan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
