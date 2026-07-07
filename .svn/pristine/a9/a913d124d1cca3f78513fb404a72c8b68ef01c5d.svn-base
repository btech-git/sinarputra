<?php

class ProductionCuttingSummaryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('poCuttingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $productionCutting = Search::bind(new ProductionCuttingHeader('search'), isset($_GET['ProductionCuttingHeader']) ? $_GET['ProductionCuttingHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';

        $productionCuttingSummary = new ProductionCuttingSummary($productionCutting->search());
        $productionCuttingSummary->setupLoading();
        $productionCuttingSummary->setupPaging($pageSize, $currentPage);
        $productionCuttingSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $productionCuttingSummary->setupFilter($filters);
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($productionCuttingSummary, $startDate, $endDate);
        }
        
        count($productionCuttingSummary->dataProvider->data);

        $this->render('summary', array(
            'productionCutting' => $productionCutting,
            'productionCuttingSummary' => $productionCuttingSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
            'customerId' => $customerId
        ));
    }

    protected function saveToExcel($productionCuttingSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Production Cutting (Summary)');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Production Cutting Summary');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Production Cutting (Summary)');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:E4');

        $worksheet->getStyle("A6:E6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:E6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:E6')->getFont()->setBold(true);

        $worksheet->setCellValue('B6', 'Production Cutting#');
        $worksheet->setCellValue('A6', 'Tanggal Production Cutting');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'PPC#');
        $worksheet->setCellValue('E6', 'User');
        
        $counter = 7;

        foreach ($productionCuttingSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'productionPlanningCuttingHeader.customer.company')));

            $worksheet->setCellValue("D{$counter}", CHtml::encode($header->productionPlanningCuttingHeader->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));


            $counter ++;

        }

        $counter ++;

        for ($col = 'A'; $col !== 'D'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Production Cutting Summary.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}

