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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
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

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->grandTotalTransaction;
        }

        return $grandTotal;
    }

    protected function saveToExcel($saleSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Order Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Order Penjualan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        
        $worksheet->getStyle('A1:AD3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AD3')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan C3 by Order Penjualan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));
        
        $worksheet->getStyle("A5:AD5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AB6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Penjualan #');
        $worksheet->setCellValue('C6', 'Kode Customer');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'PO');
        $worksheet->setCellValue('F6', 'Catatan');
        $worksheet->setCellValue('G6', 'Penawaran #');
        $worksheet->setCellValue('H6', 'Job Number');
        $worksheet->mergeCells('I5:M5');
        $worksheet->getStyle('I5:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue('I5', 'Permintaan');
        $worksheet->setCellValue('I6', 'GRADE');
        $worksheet->setCellValue('J6', 'Panjang');
        $worksheet->setCellValue('K6', 'Lebar');
        $worksheet->setCellValue('L6', 'Tinggi');
        $worksheet->setCellValue('M6', 'Quantity');
        $worksheet->mergeCells('N5:S5');
        $worksheet->getStyle('N5:S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue('N5', 'Penawaran');
        $worksheet->setCellValue('N6', 'GRADE');
        $worksheet->setCellValue('O6', 'Panjang');
        $worksheet->setCellValue('P6', 'Lebar');
        $worksheet->setCellValue('Q6', 'Tinggi');
        $worksheet->setCellValue('R6', 'Quantity');
        $worksheet->setCellValue('S6', 'Berat');
        $worksheet->mergeCells('T5:U5');
        $worksheet->setCellValue('T5', 'TYPE');
        $worksheet->mergeCells('T6:U6');
        $worksheet->setCellValue('T6', 'PROSES');
        $worksheet->setCellValue('V6', 'Harga Satuan');
        $worksheet->setCellValue('W6', 'Total');
        $worksheet->setCellValue('X6', 'Sales');
        $worksheet->setCellValue('Y6', 'User');
        $worksheet->setCellValue('Z6', 'Created');
        $worksheet->setCellValue('AA6', 'Edited');
        $worksheet->setCellValue('AB6', 'Barang / Jasa');
        $worksheet->setCellValue('AC6', 'Status');
        $worksheet->setCellValue('AD6', 'Lembaran / Batangan ?');

        $worksheet->getStyle("A6:AD6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $counter = 7;

        foreach ($saleSummary->dataProvider->data as $header) {
            foreach ($header->saleDetails as $detail) {
                $workOrderCuttingDetail = WorkOrderCuttingDetail::model()->findByAttributes(array('sale_detail_id' => $detail->id, 'is_inactive' => 0));
                $detail = $header->is_service == 1 ? $detail->quotationDetailService : $detail->quotationDetailProduct;
                $worksheet->setCellValue("A{$counter}", $header->date);
                $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(SaleHeader::CN_CONSTANT));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.code'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.company'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer_order_number'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("G{$counter}", $detail->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail, 'job_number'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, $header->is_service == 1 ? 'product_name' : 'product_name_request'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'length_request'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'width_request'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'height_request'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'quantity_request'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($detail, $header->is_service == 1 ? 'product_name' : 'product_name_quote'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($detail, 'length_quote'));
                $worksheet->setCellValue("P{$counter}", CHtml::value($detail, 'width_quote'));
                $worksheet->setCellValue("Q{$counter}", CHtml::value($detail, 'height_quote'));
                $worksheet->setCellValue("R{$counter}", CHtml::value($detail, 'quantity_quote'));
                $worksheet->setCellValue("S{$counter}", CHtml::value($detail, 'weight'));
                $worksheet->setCellValue("T{$counter}", empty($workOrderCuttingDetail) ? "" : (int) $workOrderCuttingDetail->is_cut === 1 ? "C" : "");
                $worksheet->setCellValue("U{$counter}", CHtml::value($detail, 'processList'));
                $worksheet->setCellValue("V{$counter}", CHtml::value($detail, 'unit_price'));
                $worksheet->setCellValue("W{$counter}", CHtml::value($detail, 'total'));
                $worksheet->setCellValue("X{$counter}", CHtml::value($header, 'employeeIdSalesman.name'));
                $worksheet->setCellValue("Y{$counter}", CHtml::value($header, 'admin.name'));
                $worksheet->setCellValue("Z{$counter}", CHtml::value($header, 'time_created'));
                $worksheet->setCellValue("AA{$counter}", CHtml::value($header, 'time_edited'));
                $worksheet->setCellValue("AB{$counter}", CHtml::value($header,'productServiceStatus'));
                $worksheet->setCellValue("AC{$counter}", CHtml::value($header,'status'));
                $worksheet->setCellValue("AD{$counter}", CHtml::value($header,'originalMaterialStatus'));

                $counter++;
            }
        }


        $worksheet->getStyle("A{$counter}:AD{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:AD{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->mergeCells("R{$counter}:U{$counter}");
        $worksheet->setCellValue("R{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("V{$counter}", 'Rp');
        $worksheet->setCellValue("W{$counter}", $this->reportGrandTotal($saleSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'AZ'; $col++) {
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