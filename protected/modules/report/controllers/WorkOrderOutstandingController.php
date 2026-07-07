<?php

class WorkOrderOutstandingController extends Controller {

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
		
        $workOrderHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $workOrderSummary = new WorkOrderCuttingOutstandingSummary($workOrderHeader->search());
        $workOrderSummary->setupLoading();
        $workOrderSummary->setupPaging($pageSize, $currentPage);
        $workOrderSummary->setupSorting();
        $workOrderSummary->setupFilter($startDate, $endDate);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($workOrderSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'workOrderHeader' => $workOrderHeader,
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
        $documentProperties->setTitle('Laporan SPK Outstanding');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Monitoring Stok');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        $worksheet->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Monitoring Stok');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->getStyle("A5:S5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:S5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:S5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $worksheet->getStyle('A5:S5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'NO');
        $worksheet->setCellValue('B5', 'Nama Perusahaan');
        $worksheet->setCellValue('C5', 'SO #');
        $worksheet->setCellValue('D5', 'PO Customer #');
        $worksheet->setCellValue('E5', 'Tgl SO');
        $worksheet->setCellValue('F5', 'Tgl Req Kirim');
        $worksheet->setCellValue('G5', 'SPK #');
        $worksheet->setCellValue('H5', 'Tgl SPK');
        $worksheet->setCellValue('I5', 'Qty Order');
        $worksheet->setCellValue('J5', 'Tgl PPC');
        $worksheet->setCellValue('K5', 'Qty PPC');
        $worksheet->setCellValue('L5', 'Qty Output Cutting');
        $worksheet->setCellValue('M5', 'Qty QC Cutting');
        $worksheet->setCellValue('N5', 'Qty Output Miling');
        $worksheet->setCellValue('O5', 'Qty QC Miling');
        $worksheet->setCellValue('P5', 'Tgl QC');
        $worksheet->setCellValue('Q5', 'Qty Delivery');
        $worksheet->setCellValue('R5', 'Tgl Delivery');
        $worksheet->setCellValue('S5', 'Value');

        $counter = 6;
        $number = 1;

        foreach ($workOrderSummary->dataProvider->data as $header) {
            if ($header->quantityDeliveryRemaining > 0) {
                $worksheet->setCellValue("A{$counter}", $number);
                $number++;
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')));
                $worksheet->setCellValue("C{$counter}", ($header->saleHeader == NULL) ? "" : $header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'saleHeader.customer_order_number'));
                $worksheet->setCellValue("E{$counter}", $header->saleHeader->date);
                $worksheet->setCellValue("F{$counter}", $header->saleHeader->estimate_delivery_date);
                $worksheet->setCellValue("G{$counter}", $header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                $worksheet->setCellValue("H{$counter}", $header->date);
                $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'totalQuantityDetail')) ;
                $worksheet->setCellValue("J{$counter}", empty($header->productionPlanningCuttingHeaders) ? " " : $header->productionPlanningCuttingHeaders[0]->date);
                $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'totalQuantityProductionPlanning'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'totalQuantityProduction'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'totalQuantityQualityControlCutting'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'totalQuantityProductionMiling'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'totalQuantityQualityControlMiling'));
                $worksheet->setCellValue("P{$counter}", empty($header->qualityControlCuttingHeaders) ? " " : $header->qualityControlCuttingHeaders[0]->date);
                $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'totalQuantityDelivered'));
                $worksheet->setCellValue("R{$counter}", empty($header->deliveryHeaders) ? " " : $header->deliveryHeaders[0]->date);
                $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'saleHeader.grandTotalTransaction'));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'S'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Monitoring Stok.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
