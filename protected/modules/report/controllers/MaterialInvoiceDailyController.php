<?php class MaterialInvoiceDailyController extends Controller {

    public function filters() {
        return array(
//            'access',
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
		
        $materialInvoiceHeader = Search::bind(new MaterialInvoiceHeader('search'), isset($_GET['MaterialInvoiceHeader']) ? $_GET['MaterialInvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
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

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($materialInvoiceSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'materialInvoiceHeader' => $materialInvoiceHeader,
            'materialInvoiceSummary' => $materialInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($materialInvoiceSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Buku Penjualan Manual 2');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Buku Penjualan Manual 2');

        $worksheet->mergeCells('A1:AA1');
        $worksheet->mergeCells('A2:AA2');
        $worksheet->mergeCells('A3:AA3');
        $worksheet->getStyle('A1:AA3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AA3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'PT. SINAR PUTRA METALINDO');
        $worksheet->setCellValue('A2', 'Buku Penjualan Manual 2: ' . $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:AA6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AA6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AA6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'No Faktur');
        $worksheet->setCellValue('D6', 'No Pajak');
        $worksheet->setCellValue('E6', 'No NPWP');
        $worksheet->setCellValue('F6', 'Code');
        $worksheet->setCellValue('G6', 'Customer');
        $worksheet->setCellValue('H6', 'No PO');
        $worksheet->setCellValue('I6', 'Sales');
        $worksheet->setCellValue('J6', 'Material');
        $worksheet->setCellValue('K6', 'Tbl');
        $worksheet->setCellValue('L6', 'Lbr');
        $worksheet->setCellValue('M6', 'Pjg');
        $worksheet->setCellValue('N6', 'Quantity');
        $worksheet->setCellValue('O6', 'Satuan');
        $worksheet->setCellValue('P6', 'Berat');
        $worksheet->setCellValue('Q6', 'Harga');
        $worksheet->setCellValue('R6', 'Jumlah');
        $worksheet->setCellValue('S6', 'kg/pcs');
        $worksheet->setCellValue('T6', 'Tanggal Bayar');
        $worksheet->setCellValue('U6', 'PPH 23');
        $worksheet->setCellValue('V6', 'Disc');
        $worksheet->setCellValue('W6', 'Disc Faktur');
        $worksheet->setCellValue('X6', 'Tanggal Input');
        $worksheet->setCellValue('Y6', 'Dibuat Oleh');
        $worksheet->setCellValue('Z6', 'Catatan');
        $counter = 7;
        $number = 1;
        $totalSale = 0;

        foreach ($materialInvoiceSummary->dataProvider->data as $header) {
            foreach ($header->materialInvoiceDetails as $materialInvoiceDetail) {
                $total = CHtml::value($materialInvoiceDetail, 'total');
                $worksheet->setCellValue("A{$counter}", $number);
                $number++;
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'tax_number')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.tax_registration_number')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'customer.code')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'reference_number')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'employeeIdSalesman.name')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'material_name')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'height')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'width')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'length')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'quantity')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'unit.name')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'weight')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'unit_price')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode($total));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($materialInvoiceDetail, 'quantityWeightLiteral')));
                $worksheet->setCellValue("T{$counter}", empty($header->materialPaymentDetails) ? "N/A" : CHtml::encode($header->materialPaymentDetails[0]->materialPaymentHeader->date_transaction));
                $worksheet->setCellValue("U{$counter}", $header->is_tax_income == 0 ? 0 : 2);
                $worksheet->setCellValue("V{$counter}", $header->discount > 0 ? 'Yes' : 'No');
                $worksheet->setCellValue("W{$counter}", $header->discount > 0 ?  ($header->discount) : '');
                $worksheet->setCellValue("X{$counter}", CHtml::encode($header->datetime_created));
                $worksheet->setCellValue("Y{$counter}", CHtml::value($header, 'admin.name'));
                $worksheet->setCellValue("Z{$counter}", CHtml::value($header, 'note'));
                
                $totalSale += $total;

                $counter++;
            }
        }
        
        $worksheet->getStyle("A{$counter}:AA{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells("A{$counter}:Q{$counter}");
        $worksheet->getStyle("A{$counter}:AA{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("A{$counter}", 'TOTAL PENJUALAN');
        $worksheet->setCellValue("R{$counter}", CHtml::encode($totalSale));
        $counter++;

        for ($col = 'A'; $col !== 'AA'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Buku Penjualan Manual 2.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}