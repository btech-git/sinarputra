<?php

class WorkOrderReplacementController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('workOrderReplacementReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $workOrderReplacementHeader = Search::bind(new WorkOrderReplacementHeader('search'), isset($_GET['WorkOrderReplacementHeader']) ? $_GET['WorkOrderReplacementHeader'] : array());
        $saleId = isset($_GET['SaleId']) ? $_GET['SaleId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $workOrderReplacementSummary = new WorkOrderReplacementSummary($workOrderReplacementHeader->search());
        $workOrderReplacementSummary->setupLoading();
        $workOrderReplacementSummary->setupPaging($pageSize, $currentPage);
        $workOrderReplacementSummary->setupSorting();
        $workOrderReplacementSummary->setupFilter($startDate, $endDate, $saleId);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($workOrderReplacementSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'workOrderReplacementHeader' => $workOrderReplacementHeader,
            'workOrderReplacementSummary' => $workOrderReplacementSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'saleId' => $saleId,
        ));
    }

    protected function saveToExcel($workOrderReplacementSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Nobleman');
        $documentProperties->setTitle('Laporan SPK Replacement');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK');

        $worksheet->mergeCells('A1:U1');
        $worksheet->mergeCells('A2:U2');
        $worksheet->mergeCells('A3:U3');
        $worksheet->getStyle('A1:U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:U3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan SPK Replacement');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:U4');
        $worksheet->mergeCells('F5:I5');
        $worksheet->mergeCells('J5:M5');

        $worksheet->getStyle("A6:U6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:U5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:U6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'SPK Replacement #');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'Penjualan#');
        $worksheet->setCellValue('E6', 'Catatan');
        $worksheet->setCellValue('F5', 'Permintaan');
        $worksheet->setCellValue('F6', 'GRADE');
        $worksheet->setCellValue('G6', 'Panjang');
        $worksheet->setCellValue('H6', 'Lebar');
        $worksheet->setCellValue('I6', 'Tinggi');
        $worksheet->setCellValue('J5', 'Penawaran');
        $worksheet->setCellValue('J6', 'GRADE');
        $worksheet->setCellValue('K6', 'Panjang');
        $worksheet->setCellValue('L6', 'Lebar');
        $worksheet->setCellValue('M6', 'Tinggi');
        $worksheet->setCellValue('N6', 'Quantity');
        $worksheet->setCellValue('O6', 'Berat');
        $worksheet->setCellValue('P6', 'M');
        $worksheet->setCellValue('Q6', 'G');
        $worksheet->setCellValue('R6', 'FH');
        $worksheet->setCellValue('S6', 'ANNL');
        $worksheet->setCellValue('T6', 'SM');
        $worksheet->setCellValue('U6', 'User');

        $counter = 7;

        foreach ($workOrderReplacementSummary->dataProvider->data as $header) {

            if ($header->workOrderCuttingHeader->saleHeader->is_service == 1) :
                foreach ($header->workOrderReplacementDetails as $service) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($header->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($service, 'product_name')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_request'))));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_request'))));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_request'))));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($service, 'product_name')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_quote'))));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_quote'))));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_quote'))));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity'))));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($service, 'weight'))));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode((CHtml::value($service, 'is_miling') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode((CHtml::value($service, 'is_grinding') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode((CHtml::value($service, 'is_hardness') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode((CHtml::value($service, 'is_annelying') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("T{$counter}", CHtml::encode((CHtml::value($service, 'is_sidemiling') == 1) ? "Yes" : "No"));
                    //$worksheet->setCellValue("U{$counter}", CHtml::encode((CHtml::value($service, 'is_external_order') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

                    $counter++;

                }
            else:
                foreach ($header->workOrderReplacementDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode($header->workOrderCuttingHeader->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.product_name_request')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request'))));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request'))));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.product_name_quote')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote'))));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote'))));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote'))));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($detail, 'weight'))));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode((CHtml::value($detail, 'is_miling') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode((CHtml::value($detail, 'is_grinding') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode((CHtml::value($detail, 'is_hardness') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode((CHtml::value($detail, 'is_annelying') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("T{$counter}", CHtml::encode((CHtml::value($detail, 'is_sidemiling') == 1) ? "Yes" : "No"));
                    //$worksheet->setCellValue("U{$counter}", CHtml::encode((CHtml::value($detail, 'is_external_order') == 1) ? "Yes" : "No"));
                    $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));
                    $counter++;
                
                }
            endif;
        }


        for ($col = 'A'; $col !== 'T'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan SPK Replacement.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
