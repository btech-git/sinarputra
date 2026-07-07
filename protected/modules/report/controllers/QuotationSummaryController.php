<?php

class QuotationSummaryController extends Controller {

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
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        $quotationSummary = new QuotationSummary($quotationHeader->resetScope()->search());
        $quotationSummary->setupLoading();
        $quotationSummary->setupPaging($pageSize, $currentPage);
        $quotationSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
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
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }
    
     public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['QuotationHeader']['customer_id'])) ? $_POST['QuotationHeader']['customer_id'] : '';

            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_company' => CHtml::value($customer, 'company'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($quotationSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Order Penawaran');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Order Penawaran');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        $worksheet->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Status Quotation (Total)');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:O4');
        $worksheet->mergeCells('A5:O5');

        $worksheet->getStyle("A6:O6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:O6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:N6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'No Quotation');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Sales');
        $worksheet->setCellValue('F6', 'Contact');
        $worksheet->setCellValue('G6', 'Value QTN');
        $worksheet->setCellValue('H6', 'QTY QTN');
        $worksheet->setCellValue('I6', 'Value PO');
        $worksheet->setCellValue('J6', 'QTY PO');
        $worksheet->setCellValue('K6', 'User');
        $worksheet->setCellValue('L6', 'Jam');
        $worksheet->setCellValue('M6', 'Status');
        $worksheet->setCellValue('N6', 'Tipe');
        $worksheet->setCellValue('O6', 'Note');

        $counter = 7;
        $number = 1;
        foreach ($quotationSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $number);
            $number++;
            $worksheet->setCellValue("B{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
            $worksheet->setCellValue("C{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.company'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'employeeIdSales.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.name'));
            if ($header->is_service == 1) {
                $worksheet->setCellValue("G{$counter}", CHtml::encode($header->totalDetailService));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($header->totalQuantityQuoteService));
            }else {
                $worksheet->setCellValue("G{$counter}", CHtml::encode($header->totalDetailProduct));
                $worksheet->setCellValue("H{$counter}", CHtml::encode($header->totalQuantityQuoteProduct));
            }
            $worksheet->setCellValue("I{$counter}", CHtml::encode($header->totalSaleOrder));
            $worksheet->setCellValue("J{$counter}", CHtml::encode($header->totalQuantitySaleOrder));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'admin.name'));
            $worksheet->setCellValue("L{$counter}", CHtml::encode($header->time_created));
            $worksheet->setCellValue("M{$counter}", CHtml::encode($header->status));
            $worksheet->setCellValue("N{$counter}", CHtml::encode($header->transactionStatus));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'cancellationRemarkLiteral'));

            $counter++;
        }

        $counter++;
        for ($col = 'A'; $col !== 'O'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Order Penawaran.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
