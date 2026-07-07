<?php

class MaterialInvoicePaymentController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceReport'))) {
                $this->redirect(array('/site/login'));
            }
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

        $materialInvoiceSummary = new MaterialInvoice($materialInvoiceHeader->search());
        $materialInvoiceSummary->setupLoading();
        $materialInvoiceSummary->setupPaging($pageSize, $currentPage);
        $materialInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $materialInvoiceSummary->setupFilter($filters);

//        if (isset($_POST['SaveToExcel'])) {
//            $this->saveToExcel($materialInvoiceSummary, $startDate, $endDate);
//        }

        $this->render('summary', array(
            'materialInvoiceHeader' => $materialInvoiceHeader,
            'materialInvoiceSummary' => $materialInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->grandTotal;
        }

        return $grandTotal;
    }

    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate) {
//		set_time_limit(0);
//		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Faktur Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Penjualan');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');
        $worksheet->getStyle('A1:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Sistem');
        $worksheet->setCellValue('A2', 'Laporan Faktur Penjualan');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:Q4');
        //$worksheet->mergeCells('A5:K5');

        $worksheet->getStyle("A6:Q6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:Q6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:Q6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'Code');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Jatuh Tempo');
        $worksheet->setCellValue('F6', 'SPK #');
        $worksheet->setCellValue('G6', 'PO Customer #');
        $worksheet->setCellValue('H6', 'Catatan');
        $worksheet->setCellValue('I6', 'GRADE');
        $worksheet->setCellValue('J6', 'Tbl/Dmtr');
        $worksheet->setCellValue('K6', 'Lbr/Dmtr');
        $worksheet->setCellValue('L6', 'Pjg/Dmtr');
        $worksheet->setCellValue('M6', 'Berat');
        $worksheet->setCellValue('N6', 'Quantity');
        $worksheet->setCellValue('O6', 'Harga Satuan');
        $worksheet->setCellValue('P6', 'Total');
        $worksheet->setCellValue('Q6', 'User');

        $counter = 7;

        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            if ($header->workOrderCuttingHeader->is_service == 1){
                foreach ($header->saleInvoiceDetails as $service)
                {
                    $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                    $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.code'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.company'));
                    $worksheet->setCellValue("E{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date)));
                    $worksheet->setCellValue("F{$counter}", $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                    $worksheet->setCellValue("G{$counter}", $header->workOrderCuttingHeader->saleHeader->customer_order_number);
                    $worksheet->setCellValue("H{$counter}", $header->note);
                    $worksheet->setCellValue("I{$counter}", CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.product_name'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.height_quote'));
                    $worksheet->setCellValue("K{$counter}", CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.width_quote'));
                    $worksheet->setCellValue("L{$counter}", CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.length_quote'));
                    $worksheet->setCellValue("M{$counter}", CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.weight'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($service, 'workOrderCuttingDetail.saleDetail.quotationDetailService.quantity_quote'));
                    $worksheet->setCellValue("O{$counter}", CHtml::value($service, 'unit_price'));
                    $worksheet->setCellValue("P{$counter}", CHtml::value($service, 'total'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));
                    
                    $counter++;
                }
            } else {
                foreach ($header->saleInvoiceDetails as $detail)
                {
                    $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                    $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.code'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.company'));
                    $worksheet->setCellValue("E{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->due_date)));
                    $worksheet->setCellValue("F{$counter}", $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                    $worksheet->setCellValue("G{$counter}", $header->workOrderCuttingHeader->saleHeader->customer_order_number);
                    $worksheet->setCellValue("H{$counter}", $header->note);
                    $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.product_name_quote'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.height_quote'));
                    $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.width_quote'));
                    $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.length_quote'));
                    $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.weight'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.quantity_quote'));
                    $worksheet->setCellValue("O{$counter}", CHtml::value($detail, 'unit_price'));
                    $worksheet->setCellValue("P{$counter}", CHtml::value($detail, 'total'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));
                    
                    $counter++;
                }
            }
        }


        $worksheet->getStyle("A{$counter}:Q{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:Q{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("L{$counter}:Q{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("L{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("O{$counter}", 'Rp');
        $worksheet->setCellValue("P{$counter}", $this->reportGrandTotal($saleInvoiceSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Faktur Penjualan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
