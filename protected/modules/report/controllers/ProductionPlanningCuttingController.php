<?php

class ProductionPlanningCuttingController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('ppcCuttingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $productionPlanningCutting = Search::bind(new ProductionPlanningCuttingHeader('search'), isset($_GET['ProductionPlanningCuttingHeader']) ? $_GET['ProductionPlanningCuttingHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';

        $productionPlanningCuttingSummary = new ProductionPlanningCuttingSummary($productionPlanningCutting->search());
        $productionPlanningCuttingSummary->setupLoading();
        $productionPlanningCuttingSummary->setupPaging($pageSize, $currentPage);
        $productionPlanningCuttingSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $productionPlanningCuttingSummary->setupFilter($filters);
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($productionPlanningCuttingSummary, $startDate, $endDate);
        }
        
        count($productionPlanningCuttingSummary->dataProvider->data);

        $this->render('summary', array(
            'productionPlanningCutting' => $productionPlanningCutting,
            'productionPlanningCuttingSummary' => $productionPlanningCuttingSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
            'customerId' => $customerId
        ));
    }
//
//    public function actionAjaxJsonCustomer() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';
//
//            $customer = Customer::model()->findByPk($customerId);
//
//            $object = array(
//                'customer_name' => CHtml::value($customer, 'name'),
//                'customer_company' => CHtml::value($customer, 'company'),
//            );
//            echo CJSON::encode($object);
//        }
//    }

    protected function saveToExcel($productionPlanningCuttingSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Production Planning Cutting (PPC)');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        $worksheet->mergeCells('A4:S4');
        $worksheet->getStyle('A1:S4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Production Planning Cutting (PPC)');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:S4');

        $worksheet->getStyle("A6:S6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:S6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:S6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'PPC#');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'SPK#');
        $worksheet->setCellValue('E6', 'Job Number');
        $worksheet->setCellValue('F6', 'Item');
        $worksheet->setCellValue('G6', 'Tbl/Dmtr');
        $worksheet->setCellValue('H6', 'Lbr');
        $worksheet->setCellValue('I6', 'Pjg');
        $worksheet->setCellValue('J6', 'Quantity');
        $worksheet->setCellValue('K6', 'Berat');
        $worksheet->setCellValue('L6', 'Mesin');
        $worksheet->setCellValue('M6', 'Group');
        $worksheet->setCellValue('N6', 'Tanggal Proses');
        $worksheet->setCellValue('O6', 'AKTUAL FINISH');
        $worksheet->setCellValue('P6', 'Urgent');
        $worksheet->setCellValue('Q6', 'Sales');
        $worksheet->setCellValue('R6', 'Jenis Proses (Cutting/Miling)');
        $worksheet->setCellValue('S6', 'User');
        
        $counter = 7;

        foreach ($productionPlanningCuttingSummary->dataProvider->data as $header) {

                foreach ($header->productionPlanningCuttingDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
                    $worksheet->setCellValue("D{$counter}", $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : "");
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.job_number')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.product_name')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'height')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'width')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'length')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'machine.name')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'job_group')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->planning_date))));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.urgentStatus')));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.employeeIdSalesman.name')));
                    $worksheet->setCellValue("R{$counter}", 'Cutting');
                    $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));
                   
                    $counter ++;
                }
        }

        $counter ++;

        for ($col = 'A'; $col !== 'R'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Production Planning Cutting (PPC).xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}

