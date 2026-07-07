<?php

class ProductionPlanningMilingSummaryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('ppcMilingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $productionPlanningMiling = Search::bind(new ProductionPlanningMilingHeader('search'), isset($_GET['ProductionPlanningMilingHeader']) ? $_GET['ProductionPlanningMilingHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';

        $productionPlanningMilingSummary = new ProductionPlanningMilingSummary($productionPlanningMiling->search());
        $productionPlanningMilingSummary->setupLoading();
        $productionPlanningMilingSummary->setupPaging($pageSize, $currentPage);
        $productionPlanningMilingSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $productionPlanningMilingSummary->setupFilter($filters);


        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($productionPlanningMilingSummary, $startDate, $endDate);
        }
        
        count($productionPlanningMilingSummary->dataProvider->data);

        $this->render('summary', array(
            'productionPlanningMiling' => $productionPlanningMiling,
            'productionPlanningMilingSummary' => $productionPlanningMilingSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
            'customerId' => $customerId
        ));
    }

    protected function saveToExcel($productionPlanningMilingSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Production Planning Miling');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK');

        $worksheet->mergeCells('A1:AB1');
        $worksheet->mergeCells('A2:AB2');
        $worksheet->mergeCells('A3:AB3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:AB4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AB3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Production Planning Miling');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:AB4');
        $worksheet->mergeCells('F5:H5');
        $worksheet->mergeCells('I5:K5');

        $worksheet->getStyle("A5:AB6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AB6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:AB6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'PPCM#');
        $worksheet->setCellValue('C6', 'SPK#');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Item');
        $worksheet->setCellValue('F5', 'Permintaan');
        $worksheet->setCellValue('F6', 'Tbl/Dmtr');
        $worksheet->setCellValue('G6', 'Lbr');
        $worksheet->setCellValue('H6', 'Pjg');
        $worksheet->setCellValue('I5', 'Penawaran');
        $worksheet->setCellValue('I6', 'Tbl/Dmtr');
        $worksheet->setCellValue('J6', 'Lbr');
        $worksheet->setCellValue('K6', 'Pjg');
        $worksheet->setCellValue('L6', 'M');
        $worksheet->setCellValue('M6', 'SM');
        $worksheet->setCellValue('N6', 'G');
        $worksheet->setCellValue('O6', 'HT');
        $worksheet->setCellValue('P6', 'NTD');
        $worksheet->setCellValue('Q6', 'Quantity');
        $worksheet->setCellValue('R6', 'Berat');
        $worksheet->setCellValue('S6', 'Mesin');
        $worksheet->setCellValue('T6', 'Group');
        $worksheet->setCellValue('U6', 'Tanggal Proses');
        $worksheet->setCellValue('V6', 'AKTUAL FINISH');
        $worksheet->setCellValue('W6', 'Urgent');
        $worksheet->setCellValue('X6', 'Sales');
        $worksheet->setCellValue('Y6', 'Jenis Proses');
        $worksheet->setCellValue('Z6', 'Job Number');
        $worksheet->setCellValue('AA6', 'User Admin');
        $worksheet->setCellValue('AB6', 'Jam');
        
        $counter = 7;

        foreach ($productionPlanningMilingSummary->dataProvider->data as $header) {
            foreach ($header->productionPlanningMilingDetails as $detail) {
                $workOrderCuttingDetail = CHtml::value($detail, 'workOrderCuttingDetail');
                
                $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("C{$counter}", $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : "");
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.product_name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'height_request')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'width_request')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'length_request')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'height_quote')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'width_quote')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'length_quote')));
                $worksheet->setCellValue("L{$counter}", ($workOrderCuttingDetail->is_miling == 0) ? "" : "V");
                $worksheet->setCellValue("M{$counter}", ($workOrderCuttingDetail->is_sidemiling == 0) ? "" : "V");
                $worksheet->setCellValue("N{$counter}", ($workOrderCuttingDetail->is_grinding == 0) ? "" : "V");
                $worksheet->setCellValue("O{$counter}", ($workOrderCuttingDetail->is_hardness == 0) ? "" : "V");
                $worksheet->setCellValue("P{$counter}", ($workOrderCuttingDetail->is_annelying == 0) ? "" : "V");
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($detail, 'machineIdFacemil.name')));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($detail, 'job_group_facemil')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->planning_date_facemil))));
                $worksheet->setCellValue("V{$counter}");
                $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.urgentStatus')));
                $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.employeeIdSalesman.name')));
                $worksheet->setCellValue("Y{$counter}", CHtml::encode((CHtml::value($detail, 'machineIdFacemil') == NULL) ? "" : " Facemil") .
                    CHtml::encode((CHtml::value($detail, 'machineIdSidemil') == NULL) ? "" : " Sidemil") .
                    CHtml::encode((CHtml::value($detail, 'machineIdGrinding') == NULL) ? "" : " Grinding") 
                );
                $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                $counter ++;

            }
        }

        $counter ++;

        for ($col = 'A'; $col !== 'AB'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Production Planning Miling.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}

