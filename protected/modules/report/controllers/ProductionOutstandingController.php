<?php

class ProductionOutstandingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('workOrderReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $workOrderCuttingDetail = Search::bind(new WorkOrderCuttingDetail('search'), isset($_GET['WorkOrderCuttingDetail']) ? $_GET['WorkOrderCuttingDetail'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $workOrderSummary = new ProductionOutstandingSummary($workOrderCuttingDetail->search());
        $workOrderSummary->setupLoading();
        $workOrderSummary->setupPaging($pageSize, $currentPage);
        $workOrderSummary->setupSorting();
        $workOrderSummary->setupFilter($startDate, $endDate);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($workOrderSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'workOrderCuttingDetail' => $workOrderCuttingDetail,
            'workOrderSummary' => $workOrderSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function saveToExcel($workOrderSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('PERENCANAAN PROSES PRODUKSI');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('PERENCANAAN PROSES PRODUKSI');

        $worksheet->mergeCells('A1:X1');
        $worksheet->mergeCells('A2:X2');
        $worksheet->mergeCells('A3:X3');
        $worksheet->getStyle('A1:X3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:X3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'PERENCANAAN PROSES PRODUKSI');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->getStyle("A5:X5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:X5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:X5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $worksheet->getStyle('A5:T5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'NO');
        $worksheet->setCellValue('B5', 'Tgl SPK');
        $worksheet->setCellValue('C5', 'SPK #');
        $worksheet->setCellValue('D5', 'Tgl SO');
        $worksheet->setCellValue('E5', 'Quotation #');
        $worksheet->setCellValue('F5', 'Customer');
        $worksheet->setCellValue('G5', 'Jenis');
        $worksheet->setCellValue('H5', 'T');
        $worksheet->setCellValue('I5', 'L');
        $worksheet->setCellValue('J5', 'P');
        $worksheet->setCellValue('K5', 'T');
        $worksheet->setCellValue('L5', 'L');
        $worksheet->setCellValue('M5', 'P');
        $worksheet->setCellValue('N5', 'Qty');
        $worksheet->setCellValue('O5', 'Berat');
        $worksheet->setCellValue('P5', 'Jenis Proses');
        $worksheet->setCellValue('Q5', 'M');
        $worksheet->setCellValue('R5', 'SM');
        $worksheet->setCellValue('S5', 'G');
        $worksheet->setCellValue('T5', 'HT');
        $worksheet->setCellValue('U5', 'NTD');
        $worksheet->setCellValue('V5', 'Tanggal Kirim');
        $worksheet->setCellValue('W5', 'Sales');
        $worksheet->setCellValue('X5', 'Catatan');

        $counter = 6;
        $number = 1;

        foreach ($workOrderSummary->dataProvider->data as $header) {
            if ($header->quantityCuttingQualityControlRemaining > 0) {
                $worksheet->setCellValue("A{$counter}", $number);
                $number++;
                $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->workOrderCuttingHeader->date))));
                $worksheet->setCellValue("C{$counter}", $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->workOrderCuttingHeader->saleHeader->date))));
                $worksheet->setCellValue("E{$counter}", ($header->saleDetail->quotationDetailProduct == NULL) ? $header->saleDetail->quotationDetailService->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT) : $header->saleDetail->quotationDetailProduct->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'product_name')) ;
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'height_request'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'width_request'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'length_request'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'height_quote'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'width_quote'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'length_quote'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'quantity'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'weight'));
                $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'workOrderCuttingHeader.note'));
                $worksheet->setCellValue("Q{$counter}", ((int)$header->is_miling == 1) ? "Yes" : "");
                $worksheet->setCellValue("R{$counter}", ((int)$header->is_sidemiling == 1) ? "Yes" : "");
                $worksheet->setCellValue("S{$counter}", ((int)$header->is_grinding == 1) ? "Yes" : "");
                $worksheet->setCellValue("T{$counter}", ((int)$header->is_hardness == 1) ? "Yes" : "");
                $worksheet->setCellValue("U{$counter}", ((int)$header->is_annelying == 1) ? "Yes" : "");
                $worksheet->setCellValue("V{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.estimate_delivery_date'))));
                $worksheet->setCellValue("W{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.employeeIdSalesman.name'));
                $worksheet->setCellValue("X{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.note'));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'X'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="PERENCANAAN PROSES PRODUKSI.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
