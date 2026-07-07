<?php

class ProductionCuttingController extends Controller {

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

        if (isset($_POST['SaveToExcel']))
            $this->saveToExcel($productionCuttingSummary, $startDate, $endDate);

        count($productionCuttingSummary->dataProvider->data);

        $this->render('summary', array(
            'productionCutting' => $productionCuttingSummary,
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
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Production Cutting');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Production Cutting');

        $worksheet->mergeCells('A1:U1');
        $worksheet->mergeCells('A2:U2');
        $worksheet->mergeCells('A3:U3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:U4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:U3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Production Cutting');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:U4');

        $worksheet->getStyle("A6:U6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:U6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:U6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tanggal Produksi');
        $worksheet->setCellValue('B6', 'Jam Produksi');
        $worksheet->setCellValue('C6', 'Production Cutting#');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'PPC#');
        $worksheet->setCellValue('F6', 'Job Number');
        $worksheet->setCellValue('G6', 'Item');
        $worksheet->setCellValue('H6', 'Tbl/Dmtr');
        $worksheet->setCellValue('I6', 'Lbr');
        $worksheet->setCellValue('J6', 'Pjg');
        $worksheet->setCellValue('K6', 'Quantity SPK');
        $worksheet->setCellValue('L6', 'Quantity Potong');
        $worksheet->setCellValue('M6', 'Sisa Quantity Potong');
        $worksheet->setCellValue('N6', 'Berat');
        $worksheet->setCellValue('O6', 'Mesin');
        $worksheet->setCellValue('P6', 'GROUP');
        $worksheet->setCellValue('Q6', 'Operator');
        $worksheet->setCellValue('R6', 'Jam Mulai');
        $worksheet->setCellValue('S6', 'Jam Selesai');
        $worksheet->setCellValue('T6', 'Jenis Proses (Cutting/Miling)');
        $worksheet->setCellValue('U6', 'User');

        $counter = 7;

        foreach ($productionCuttingSummary->dataProvider->data as $header) {
            foreach ($header->productionCuttingDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->date));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->time));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'productionPlanningCuttingHeader.customer.company')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($header->productionPlanningCuttingHeader->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.job_number')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'productionPlanningCuttingDetail.workOrderCuttingDetail.product_name')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'height')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'width')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'length')));

                $runningQuantity = isset($runningQuantities[$detail->production_planning_cutting_detail_id]) ? $runningQuantities[$detail->production_planning_cutting_detail_id] : CHtml::encode(CHtml::value($detail, 'productionPlanningCuttingDetail.quantity'));
                $worksheet->setCellValue("K{$counter}", $runningQuantity);
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $quantityRemaining = $runningQuantity - CHtml::value($detail, 'quantity');
                $worksheet->setCellValue("M{$counter}", $quantityRemaining);
                $runningQuantities[$detail->production_planning_cutting_detail_id] = $quantityRemaining;

                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'machine.name')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'job_group')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'employee.nameAndGroup')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'production_time_start')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($detail, 'production_time_end')));
                $worksheet->setCellValue("T{$counter}", 'Cutting');
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                $counter ++;
            }
        }

        $counter ++;

        for ($col = 'A'; $col !== 'U'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Production Cutting.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}