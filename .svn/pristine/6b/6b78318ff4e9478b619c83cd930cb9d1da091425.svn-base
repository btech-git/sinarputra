<?php

class ProductionPlanningReplacementMilingSummaryController extends Controller {

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

        $productionPlanningMilingSummary = new ProductionPlanningReplacementMilingSummary($productionPlanningMiling->search());
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
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Production Planning Miling');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan PPC Replacement Miling');

        $worksheet->mergeCells('A1:V1');
        $worksheet->mergeCells('A2:V2');
        $worksheet->mergeCells('A3:V3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:V4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Production Planning Miling Replacement');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:V4');
        $worksheet->mergeCells('G5:I5');
        $worksheet->mergeCells('J5:L5');

        $worksheet->getStyle("A5:V6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:V6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:V6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'PPCC #');
        $worksheet->setCellValue('C6', 'SPK-R #');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Item');
        $worksheet->setCellValue('F6', 'Job Number');
        $worksheet->setCellValue('G5', 'Permintaan');
        $worksheet->setCellValue('G6', 'Tbl/Dmtr');
        $worksheet->setCellValue('H6', 'Lbr');
        $worksheet->setCellValue('I6', 'Pjg');
        $worksheet->setCellValue('J5', 'Penawaran');
        $worksheet->setCellValue('J6', 'Tbl/Dmtr');
        $worksheet->setCellValue('K6', 'Lbr');
        $worksheet->setCellValue('L6', 'Pjg');
        $worksheet->setCellValue('M6', 'Quantity');
        $worksheet->setCellValue('N6', 'Berat');
        $worksheet->setCellValue('O6', 'Mesin');
        $worksheet->setCellValue('P6', 'Group');
        $worksheet->setCellValue('Q6', 'Tanggal Proses');
        $worksheet->setCellValue('R6', 'Urgent');
        $worksheet->setCellValue('S6', 'Jenis Proses');
        $worksheet->setCellValue('T6', 'Operator');
        $worksheet->setCellValue('U6', 'Note NG');
        $worksheet->setCellValue('V6', 'User Admin');
        
        $counter = 7;

        foreach ($productionPlanningMilingSummary->dataProvider->data as $header) {
            foreach ($header->productionPlanningMilingDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("C{$counter}", $header->workOrderReplacementHeader ? CHtml::encode($header->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)) : "");
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.company')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderReplacementDetail.product_name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderReplacementDetail.job_number')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'height_request')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'width_request')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'length_request')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'height_quote')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'width_quote')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'length_quote')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'machineIdFacemil.name')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'job_group_facemil')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->planning_date_facemil))));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderReplacementDetail.urgentStatus')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode((CHtml::value($detail, 'machineIdFacemil') == NULL) ? "" : " Facemil") .
                        CHtml::encode((CHtml::value($detail, 'machineIdSidemil') == NULL) ? "" : " Sidemil") .
                        CHtml::encode((CHtml::value($detail, 'machineIdGrinding') == NULL) ? "" : " Grinding") 
                        //CHtml::encode((CHtml::value($service, 'is_hardness') == 1) ? "FH" : "") .
                        //CHtml::encode((CHtml::value($service, 'is_annelying') == 1) ? "ANNL" : "") .
                        //CHtml::encode((CHtml::value($service, 'is_sidemiling') == 1) ? "SM" : "")
                );
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($detail, 'productionMilingDetail.employeeIdFacemil.nameAndGroup')));
                $qualityControlDetail = empty($detail->workOrderReplacementDetail->quality_control_cutting_detail_id) ? $detail->workOrderReplacementDetail->qualityControlMilingDetail : $detail->workOrderReplacementDetail->qualityControlCuttingDetail;
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($qualityControlDetail, 'memo')));
                $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                $counter ++;

            }
        }

        $counter ++;

        for ($col = 'A'; $col !== 'O'; $col++) {
            $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Production Planning Miling Replacement.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}

