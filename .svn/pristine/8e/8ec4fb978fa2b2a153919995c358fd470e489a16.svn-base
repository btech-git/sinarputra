<?php

class QualityControlCuttingController extends Controller {

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
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Quality Control Cutting');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:W4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:W3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Quality Control Cutting');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:W4');

        $worksheet->getStyle("A6:W6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:W6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:W6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'QCC#');
        $worksheet->setCellValue('C6', 'SPK#');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Job Number');
        $worksheet->setCellValue('F6', 'Grade');
        $worksheet->setCellValue('G6', 'Tbl/Dmtr');
        $worksheet->setCellValue('H6', 'Lbr');
        $worksheet->setCellValue('I6', 'Pjg');
        $worksheet->setCellValue('J6', 'Berat');
        $worksheet->setCellValue('K6', 'Quantity SPK');
        $worksheet->setCellValue('L6', 'Total Quantity QC');
        $worksheet->setCellValue('M6', 'Sisa Quantity QC');
        $worksheet->setCellValue('N6', 'PIC');
        $worksheet->setCellValue('O6', 'Tanggal QC');
        $worksheet->setCellValue('Q6', 'Hasil QC');
        $worksheet->setCellValue('R6', 'Note NG');
//        $worksheet->setCellValue('S6', 'Jenis Proses');
        $worksheet->setCellValue('T6', 'No PO / ACC Penawaran');
        $worksheet->setCellValue('U6', 'No QTN');
        $worksheet->setCellValue('V6', 'Type');
        $worksheet->setCellValue('W6', 'User Admin');
        
        $counter = 7;

        $runningQuantities = array(); 
        foreach ($qualityControlCuttingSummary->dataProvider->data as $header) {
            foreach ($header->qualityControlCuttingDetails as $detail) {
                $workOrderCuttingHeader = empty($header->workOrderCuttingHeader) ? '' : $header->workOrderCuttingHeader;
                $saleHeader = empty($workOrderCuttingHeader->saleHeader) ? '' : $workOrderCuttingHeader->saleHeader;
                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->date));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($saleHeader, 'customer.company')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.job_number')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.product_name')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.height_quote')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.width_quote')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.length_quote')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.weight')));
                
                $runningQuantity = isset($runningQuantities[$detail->work_order_cutting_detail_id]) ? $runningQuantities[$detail->work_order_cutting_detail_id] : CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.quantity'));
                $worksheet->setCellValue("K{$counter}", $runningQuantity);
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $quantityRemaining = $runningQuantity - CHtml::value($detail, 'quantity');
                $worksheet->setCellValue("M{$counter}", $quantityRemaining);
                $runningQuantities[$detail->work_order_cutting_detail_id] = $quantityRemaining;
                
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'employee.name')));
                $worksheet->setCellValue("O{$counter}", $detail->control_time);
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'control_result')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));
//                $worksheet->setCellValue("S{$counter}", CHtml::encode((CHtml::value($detail, 'is_cut') == 1) ? "Cutting" : "Miling"));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($saleHeader, 'customer_order_number')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(empty($saleHeader->quotationHeader) ? "" : $saleHeader->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)));
                $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.productCategory.name')));
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
        header('Content-Disposition: attachment;filename="Laporan Quality Control Cutting.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}

