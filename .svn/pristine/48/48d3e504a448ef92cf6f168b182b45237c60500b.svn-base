<?php

class WorkOrderCuttingDetailController extends Controller {

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
		
        $workOrderCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : array());
        $saleId = isset($_GET['SaleId']) ? $_GET['SaleId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
    
        $workOrderCuttingSummary = new WorkOrderCuttingSummary($workOrderCuttingHeader->search());
        $workOrderCuttingSummary->setupLoading();
        $workOrderCuttingSummary->setupPaging($pageSize, $currentPage);
        $workOrderCuttingSummary->setupSorting();
        $workOrderCuttingSummary->setupFilter($startDate, $endDate, $saleId);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($workOrderCuttingSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'workOrderCuttingHeader' => $workOrderCuttingHeader,
            'workOrderCuttingSummary' => $workOrderCuttingSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'saleId' => $saleId,
            
        ));
    }

    protected function saveToExcel($workOrderCuttingSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan SPK Cutting Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK Cutting Detail');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');
        $worksheet->getStyle('A1:W3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:W3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan SPK Cutting Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:W4');

        $worksheet->mergeCells('G5:I5');
        $worksheet->mergeCells('J5:L5');
    
        $worksheet->getStyle("A5:W6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:W6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:W6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tgl SPK');
        $worksheet->setCellValue('B6', 'NO SPK');
        $worksheet->setCellValue('C6', 'CUSTOMER');
        $worksheet->setCellValue('D6', 'SALES');
        $worksheet->setCellValue('E6', 'JENIS');
        $worksheet->setCellValue('F6', 'TIPE');
        $worksheet->setCellValue('G5', 'Permintaan');
        $worksheet->setCellValue('G6', 'T');
        $worksheet->setCellValue('H6', 'L');
        $worksheet->setCellValue('I6', 'P');
        $worksheet->setCellValue('J5', 'Penawaran');
        $worksheet->setCellValue('J6', 'T');
        $worksheet->setCellValue('K6', 'L');
        $worksheet->setCellValue('L6', 'P');
        $worksheet->setCellValue('M6', 'Quantity');
        $worksheet->setCellValue('N6', 'Berat');
        $worksheet->setCellValue('O6', 'TYPE PROSES');
        $worksheet->setCellValue('P6', 'S/N');
        $worksheet->setCellValue('Q6', 'NO REFF');
        $worksheet->setCellValue('R6', 'Jam');
        $worksheet->setCellValue('S6', 'User Input');
        $worksheet->setCellValue('T6', 'Material Handling');
        $worksheet->setCellValue('U6', 'Type');
        $worksheet->setCellValue('V6', 'Tgl Kirim');
        $worksheet->setCellValue('W6', 'Lembaran / Batangan ?');
        $counter = 7;

        foreach ($workOrderCuttingSummary->dataProvider->data as $header) {
            if ($header->saleHeader->is_service == 1) :
                foreach ($header->workOrderCuttingDetails as $service) {
                    $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                    $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'saleHeader.customer.company'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'saleHeader.customer.employee.name'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($service, 'product_name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($service, 'productCategory.name'));
                    $worksheet->setCellValue("G{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_request')));
                    $worksheet->setCellValue("H{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_request')));
                    $worksheet->setCellValue("I{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_request')));
                    $worksheet->setCellValue("J{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_quote')));
                    $worksheet->setCellValue("K{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_quote')));
                    $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_quote')));
                    $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity')));
                    $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($service, 'weight')));
                    $isMiling = CHtml::value($service, 'saleDetail.quotationDetailService.is_miling') == 1 ? "M " : "";
                    $isGrinding = CHtml::value($service, 'saleDetail.quotationDetailService.is_grinding') == 1 ? "G " : "" ;
                    $isHardness = CHtml::value($service, 'saleDetail.quotationDetailService.is_hardness') == 1 ? "FH " : "";
                    $isAnnelying = CHtml::value($service, 'saleDetail.quotationDetailService.is_annelying') == 1 ? "ANNL " : "";
                    $isSidemiling = CHtml::value($service, 'saleDetail.quotationDetailService.is_sidemiling') == 1 ? "SM " : ""; 
                    $worksheet->setCellValue("O{$counter}", $isMiling . $isGrinding . $isHardness . $isAnnelying . $isSidemiling);
                    $worksheet->setCellValue("P{$counter}", CHtml::value($service, 'serialConstant'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'saleHeader.customer_order_number'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'time_created'));
                    $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'admin.name'));
                    $employee = Employee::model()->resetScope()->findByPk($service->employee_id);
                    $worksheet->setCellValue("T{$counter}", CHtml::value($employee, 'name'));
                    $worksheet->setCellValue("U{$counter}", CHtml::value($service, 'workOrderStatus'));
                    if (empty($service->deliveryDetails)){
                        $worksheet->setCellValue("V{$counter}", "");
                    } else {
                        $worksheet->setCellValue("V{$counter}", $header->saleHeader->estimate_delivery_date);
                    }
                    $worksheet->setCellValue("W{$counter}", CHtml::value($header, 'saleHeader.originalMaterialStatus'));
                    
                    $counter++;
                }
            else:
                foreach ($header->workOrderCuttingDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                    $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'saleHeader.customer.company'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'saleHeader.customer.employee.name'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_quote'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($detail, 'productCategory.name'));
                    $worksheet->setCellValue("G{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request')));
                    $worksheet->setCellValue("H{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request')));
                    $worksheet->setCellValue("I{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request')));
                    $worksheet->setCellValue("J{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote')));
                    $worksheet->setCellValue("K{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote')));
                    $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote')));
                    $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity')));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($detail, 'weight'));
                    $isCut = CHtml::value($detail, 'is_cut') == 1 ? "C " : "";
                    $isMiling = CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_miling') == 1 ? "M " : "";
                    $isGrinding = CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_grinding') == 1 ? "G " : "" ;
                    $isHardness = CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_hardness') == 1 ? "FH " : "";
                    $isAnnelying = CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_annelying') == 1 ? "ANNL " : "";
                    $isSidemiling = CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_sidemiling') == 1 ? "SM " : ""; 
                    $worksheet->setCellValue("O{$counter}", $isCut . $isMiling . $isGrinding . $isHardness . $isAnnelying . $isSidemiling);
                    $worksheet->setCellValue("P{$counter}", CHtml::value($detail, 'serialConstant'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'saleHeader.customer_order_number'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'time_created'));
                    $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'admin.name'));
                    $worksheet->setCellValue("T{$counter}", CHtml::value($detail, 'employee.name'));
                    $worksheet->setCellValue("U{$counter}", CHtml::value($detail, 'workOrderStatus'));
                    if (empty($detail->deliveryDetails)) {
                        $worksheet->setCellValue("V{$counter}", "");
                    } else {
                        $worksheet->setCellValue("V{$counter}", $header->saleHeader->estimate_delivery_date);
                    }
                    $worksheet->setCellValue("W{$counter}", CHtml::value($header, 'saleHeader.originalMaterialStatus'));

                    $counter++;
                }
            endif;
        }


        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan SPK Cutting Detail.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
