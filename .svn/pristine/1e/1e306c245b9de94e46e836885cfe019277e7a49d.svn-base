<?php class ManualSaleInvoiceDailyController extends Controller {

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
		
        $saleInvoiceHeader = Search::bind(new ManualSaleInvoiceHeader('search'), isset($_GET['ManualSaleInvoiceHeader']) ? $_GET['ManualSaleInvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $saleInvoiceSummary = new ManualSaleInvoice($saleInvoiceHeader->search());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $saleInvoiceSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'saleInvoiceHeader' => $saleInvoiceHeader,
            'saleInvoiceSummary' => $saleInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate) {
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
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Buku Penjualan Manual');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Buku Penjualan Manual');

        $worksheet->mergeCells('A1:AJ1');
        $worksheet->mergeCells('A2:AJ2');
        $worksheet->mergeCells('A3:AJ3');
        $worksheet->getStyle('A1:AJ3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AJ3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'PT. SINAR PUTRA METALINDO');
        $worksheet->setCellValue('A2', 'Buku Penjualan Manual: ' . $startDate . ' - ' . $endDate);
        $worksheet->setCellValue('A3', '');

        $worksheet->getStyle("A5:AJ6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AJ6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AJ6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'No Faktur');
        $worksheet->setCellValue('D6', 'No Pajak');
        $worksheet->setCellValue('E6', 'No NPWP');
        $worksheet->setCellValue('F6', 'Code');
        $worksheet->setCellValue('G6', 'Customer');
        $worksheet->setCellValue('H6', 'No PO');
        $worksheet->setCellValue('I6', 'Sales');
        $worksheet->setCellValue('J6', 'No SPK');
        $worksheet->setCellValue('K6', 'Material');
        $worksheet->setCellValue('L6', 'Job Number');
        $worksheet->setCellValue('M6', 'Jenis');
        $worksheet->setCellValue('N6', 'Tbl req');
        $worksheet->setCellValue('O6', 'Lbr req');
        $worksheet->setCellValue('P6', 'Pjg req');
        $worksheet->setCellValue('Q6', 'Tbl quo');
        $worksheet->setCellValue('R6', 'Lbr quo');
        $worksheet->setCellValue('S6', 'Pjg quo');
        $worksheet->setCellValue('T6', 'Quantity');
        $worksheet->setCellValue('U6', 'Berat');
        $worksheet->setCellValue('V6', 'Harga');
        $worksheet->setCellValue('W6', 'Jumlah');
        $worksheet->setCellValue('X6', 'kg/pcs');
        $worksheet->setCellValue('Y6', 'Tanggal TT');
        $worksheet->setCellValue('Z6', 'PPH 23');
        $worksheet->setCellValue('AA6', 'Disc');
        $worksheet->setCellValue('AB6', 'Disc Faktur');
        $worksheet->setCellValue('AC6', 'Bulan');
        $worksheet->setCellValue('AD6', 'Tahun');
        $worksheet->setCellValue('AE6', 'Status');
        $worksheet->setCellValue('AF6', 'TGL Input');
        $worksheet->setCellValue('AG6', 'Created By');
        $worksheet->setCellValue('AH6', 'Catatan');
        $worksheet->setCellValue('AI6', 'Note SO');
        $counter = 7;
        $number = 1;

        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            foreach ($header->manualSaleInvoiceDetails as $saleInvoiceDetail) {
                $worksheet->setCellValue("A{$counter}", $number);
                $number++;
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'tax_number')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.tax_registration_number')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'customer.code')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_number')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'employeeIdSalesman.name')));

                if ($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail !== NULL) {
                    $worksheet->setCellValue("J{$counter}", CHtml::encode($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.product_name')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.job_number')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.productCategory.name')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.height_request')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.width_request')));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.length_request')));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.height_quote')));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.width_quote')));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.length_quote')));
                }

                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'quantity')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'weight')));
                $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'unit_price')));
                $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'total')));
                $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($saleInvoiceDetail, 'multiplicationStatus')));
                $worksheet->setCellValue("Y{$counter}", empty($header->saleReceiptDetails) ? "N/A" : CHtml::encode($header->saleReceiptDetails[0]->saleReceiptHeader->date));
                $worksheet->setCellValue("Z{$counter}", $header->is_tax_income == 0 ? 0 : 2);
                $worksheet->setCellValue("AA{$counter}", $header->discount > 0 ? 'Yes' : 'No');
                $worksheet->setCellValue("AB{$counter}", $header->discount > 0 ?  ($header->discount) : '');
                $worksheet->setCellValue("AC{$counter}", CHtml::encode(CHtml::value($header, 'cn_month')));
                $worksheet->setCellValue("AD{$counter}", CHtml::encode(CHtml::value($header, 'cn_year')));
                $worksheet->setCellValue("AE{$counter}", CHtml::encode($header->getServiceType($header->service_type)));
                $worksheet->setCellValue("AF{$counter}", CHtml::encode($header->date_created));
                $worksheet->setCellValue("AG{$counter}", CHtml::value($header, 'admin.name'));
                $worksheet->setCellValue("AH{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("AI{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.note')));

                $counter++;
            }
        }
        $counter++;

        for ($col = 'A'; $col !== 'AJ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Buku Penjualan Manual.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}