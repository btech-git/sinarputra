<?php

class ProductionMilingSummaryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('poMilingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $productionMiling = Search::bind(new ProductionMilingHeader('search'), isset($_GET['ProductionMilingHeader']) ? $_GET['ProductionMilingHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';

        $productionMilingSummary = new ProductionMilingSummary($productionMiling->search());
        $productionMilingSummary->setupLoading();
        $productionMilingSummary->setupPaging($pageSize, $currentPage);
        $productionMilingSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $productionMilingSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($productionMilingSummary, $startDate, $endDate);
        }

        count($productionMilingSummary->dataProvider->data);

        $this->render('summary', array(
            'productionMiling' => $productionMiling,
            'productionMilingSummary' => $productionMilingSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
            'customerId' => $customerId
        ));
    }

    protected function saveToExcel($productionMilingSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('BloomingTech');
        $documentProperties->setTitle('Laporan Production Miling');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Production Miling');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');

        $worksheet->getStyle('A1:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:W3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Production Miling');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:W4');

        $worksheet->getStyle("A6:W6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:W6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:W6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tanggal Produksi');
        $worksheet->setCellValue('B6', 'Jam Produksi');
        $worksheet->setCellValue('C6', 'Output Miling #');
        $worksheet->setCellValue('D6', 'PPCM#');
        $worksheet->setCellValue('E6', 'SPK#');
        $worksheet->setCellValue('F6', 'Customer');
        $worksheet->setCellValue('G6', 'Job Number');
        $worksheet->setCellValue('H6', 'Item');
        $worksheet->setCellValue('I6', 'Tbl/Dmtr');
        $worksheet->setCellValue('J6', 'Lbr');
        $worksheet->setCellValue('K6', 'Pjg');
        $worksheet->setCellValue('L6', 'Quantity Proses');
        $worksheet->setCellValue('M6', 'Quantity SPK');
        $worksheet->setCellValue('N6', 'Sisa Quantity Miling');
        $worksheet->setCellValue('O6', 'Berat');
        $worksheet->setCellValue('P6', 'Mesin');
        $worksheet->setCellValue('Q6', 'GROUP');
        $worksheet->setCellValue('R6', 'Operator');
        $worksheet->setCellValue('S6', 'Jam Mulai');
        $worksheet->setCellValue('T6', 'Jam Selesai');
        $worksheet->setCellValue('U6', 'Urgent');
        $worksheet->setCellValue('V6', 'Jenis Proses');
        $worksheet->setCellValue('W6', 'User Admin');

        $counter = 7;

        foreach ($productionMilingSummary->dataProvider->data as $header) {
            foreach ($header->productionMilingDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->date));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->time));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getCodeNumber(ProductionMilingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($header->productionPlanningMilingHeader->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($header->productionPlanningMilingHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.workOrderCuttingHeader.saleHeader.customer.company')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.job_number')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.product_name')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'height_request')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'width_request')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'length_request')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'totalQuantityMilingControl')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.quantity')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'quantityMilingControlRemaining')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'machineIdFacemil.name')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'job_group_facemil')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'employeeIdFacemil.nameAndGroup')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($detail, 'production_time_start')));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($detail, 'production_time_end')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningMilingDetail.workOrderCuttingDetail.urgentStatus')));
                $worksheet->setCellValue("V{$counter}", CHtml::encode((CHtml::value($detail, 'machineIdFacemil') == NULL) ? "" : " Facemil") .
                        CHtml::encode((CHtml::value($detail, 'machineIdSidemil') == NULL) ? "" : " Sidemil") .
                        CHtml::encode((CHtml::value($detail, 'machineIdGrinding') == NULL) ? "" : " Grinding")
                        //CHtml::encode((CHtml::value($service, 'is_hardness') == 1) ? "FH" : "") .
                        //CHtml::encode((CHtml::value($service, 'is_annelying') == 1) ? "ANNL" : "") .
                        //CHtml::encode((CHtml::value($service, 'is_sidemiling') == 1) ? "SM" : "")
                );
                $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                $counter ++;
            }
        }

        $counter ++;

        for ($col = 'A'; $col !== 'W'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Production Miling.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
