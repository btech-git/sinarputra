<?php

class QualityControlCuttingSummaryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('qcCuttingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $qualityControlCutting = Search::bind(new QualityControlCuttingHeader('search'), isset($_GET['QualityControlCuttingHeader']) ? $_GET['QualityControlCuttingHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';

        $qualityControlCuttingSummary = new QualityControlCuttingSummary($qualityControlCutting->search());
        $qualityControlCuttingSummary->setupLoading();
        $qualityControlCuttingSummary->setupPaging($pageSize, $currentPage);
        $qualityControlCuttingSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $qualityControlCuttingSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($qualityControlCuttingSummary, $startDate, $endDate);
        }
        
        count($qualityControlCuttingSummary->dataProvider->data);

        $this->render('summary', array(
            'qualityControlCutting' => $qualityControlCutting,
            'qualityControlCuttingSummary' => $qualityControlCuttingSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
            'customerId' => $customerId
        ));
    }

    protected function saveToExcel($qualityControlCuttingSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinarputra');
        $documentProperties->setTitle('Quality Control Cutting');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Quality Control Cutting');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Quality Control Cutting (Summary)');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:E4');

        $worksheet->getStyle("A6:E6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:E6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:E6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'QCC#');
        $worksheet->setCellValue('B6', 'Tanggal QC Cutting');
        $worksheet->setCellValue('C6', 'SPK#');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Production Cutting #');
        
        $counter = 7;

        foreach ($qualityControlCuttingSummary->dataProvider->data as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT)));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode($header->productionCuttingHeader->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)));
 
            $counter ++;

        }

        $counter ++;

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Quality Control Cutting (Summary).xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}

