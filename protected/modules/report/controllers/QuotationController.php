<?php

class QuotationController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('quotationReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $quotationHeader = Search::bind(new QuotationHeader('search'), isset($_GET['QuotationHeader']) ? $_GET['QuotationHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
//        $status = (isset($_GET['QuotationHeader']['is_inactive'])) ? $_GET['QuotationHeader']['is_inactive'] : '';
//        $customerId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';

        $quotationSummary = new QuotationSummary($quotationHeader->resetScope()->search());
        $quotationSummary->setupLoading();
        $quotationSummary->setupPaging($pageSize, $currentPage);
        $quotationSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
//            'customerId' => $customerId,
//            'status' => $status
        );
        $quotationSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($quotationSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'quotationHeader' => $quotationHeader,
            'quotationSummary' => $quotationSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
//            'customerId' => $customerId,
//            'status' => $status
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

    protected function saveToExcel($quotationSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
//        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
//        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Order Penawaran');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penawaran');

        $worksheet->mergeCells('A1:AA1');
        $worksheet->mergeCells('A2:AA2');
        $worksheet->mergeCells('A3:AA3');
        $worksheet->getStyle('A1:AA3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AA3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan C3 by Order Penawaran');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:AA4');
        $worksheet->mergeCells('G5:K5');
        $worksheet->mergeCells('L5:P5');

        $worksheet->getStyle("A5:AA6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AA5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AA6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'No Quotation #');
        $worksheet->setCellValue('D6', 'Nama Perusahan');
        $worksheet->setCellValue('E6', 'Sales');
        $worksheet->setCellValue('F6', 'Contact');
        $worksheet->setCellValue('G5', 'Permintaan');
        $worksheet->setCellValue('G6', 'Grade');
        $worksheet->setCellValue('H6', 'Panjang');
        $worksheet->setCellValue('I6', 'Lebar');
        $worksheet->setCellValue('J6', 'Tinggi');
        $worksheet->setCellValue('K6', 'Quantity');
        $worksheet->setCellValue('L5', 'Penawaran');
        $worksheet->setCellValue('L6', 'Grade');
        $worksheet->setCellValue('M6', 'Panjang');
        $worksheet->setCellValue('N6', 'Lebar');
        $worksheet->setCellValue('O6', 'Tinggi');
        $worksheet->setCellValue('P6', 'Quantity');
        $worksheet->setCellValue('Q6', 'Berat');
        $worksheet->setCellValue('R6', 'Harga Satuan');
        $worksheet->setCellValue('S6', 'Value QTN');
        $worksheet->setCellValue('T6', 'Catatan');
        $worksheet->setCellValue('U6', 'Type QTN');
        $worksheet->setCellValue('V6', 'Value PO');
        $worksheet->setCellValue('W6', 'No P/O #');
        $worksheet->setCellValue('X6', 'Tgl P/O');
        $worksheet->setCellValue('Y6', 'Acc QTN');
        $worksheet->setCellValue('Z6', 'Jam');
        $worksheet->setCellValue('AA6', 'User Admin');

        $counter = 7;
        $number =1;

        foreach ($quotationSummary->dataProvider->data as $header) {
            if ($header->is_service == 1) {
                foreach ($header->quotationDetailServices as $service) {
                    $worksheet->setCellValue("A{$counter}", $number);
                    $number++;
                    $worksheet->setCellValue("B{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                    $worksheet->setCellValue("C{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.company'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'employeeIdSales.name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.name'));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($service, 'product_name')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($service, 'length_request')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($service, 'width_request')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($service, 'height_request')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($service, 'quantity_request')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($service, 'product_name')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($service, 'length_quote')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($service, 'width_quote')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($service, 'height_quote')));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($service, 'quantity_quote')));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($service, 'weight')));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($service, 'unit_price')));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($service, 'total')));
                    $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                    $worksheet->setCellValue("U{$counter}", 'Service');
                    $worksheet->setCellValue("V{$counter}", $service->saleDetails ? CHtml::encode($service->total) : "");
                    $worksheet->setCellValue("W{$counter}", $service->saleDetails ? CHtml::encode($service->saleDetails[0]->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : "");
                    $worksheet->setCellValue("X{$counter}", $service->saleDetails ? CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($service->saleDetails[0]->saleHeader->date))) : "");
                    $worksheet->setCellValue("Y{$counter}", CHtml::encode((CHtml::value($header, 'is_confirmed') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("Z{$counter}", CHtml::encode(CHtml::value($header, 'time_created')));
                    $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                    $counter++;
                }
            } else {
                foreach ($header->quotationDetailProducts as $detail) {
                    $worksheet->setCellValue("A{$counter}", $number);
                    $number++;
                    $worksheet->setCellValue("B{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                    $worksheet->setCellValue("C{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.company'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'employeeIdSales.name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.name'));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'product_name_request')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'length_request')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'width_request')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'height_request')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_request')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'product_name_quote')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'length_quote')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'width_quote')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'height_quote')));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'quantity_quote')));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($detail, 'total')));
                    $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                    $worksheet->setCellValue("U{$counter}", 'Product');
                    $worksheet->setCellValue("V{$counter}", $detail->saleDetails ? CHtml::encode($detail->total) : "");
                    $worksheet->setCellValue("W{$counter}", $detail->saleDetails ? CHtml::encode($detail->saleDetails[0]->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)) : "");
                    $worksheet->setCellValue("X{$counter}", $detail->saleDetails ? CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->saleDetails[0]->saleHeader->date))) : "");
                    $worksheet->setCellValue("Y{$counter}", CHtml::encode((CHtml::value($header, 'is_confirmed') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("Z{$counter}", CHtml::encode(CHtml::value($header, 'time_created')));
                    $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                    $counter++;
                }
            }
        }
        $worksheet->getStyle("A{$counter}:AA{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:AA{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("Q{$counter}:S{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("Q{$counter}", 'Total Penawaran');
        $worksheet->setCellValue("R{$counter}", 'Rp');
        $worksheet->setCellValue("S{$counter}", Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($quotationSummary->dataProvider))));

        $counter++;

        for ($col = 'A'; $col !== 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan C3 by Order Penawaran.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
