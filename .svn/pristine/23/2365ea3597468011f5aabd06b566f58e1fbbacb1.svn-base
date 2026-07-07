<?php

class SalePaymentController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('salePaymentReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $workOrderCuttingHeader = Search::bind(new WorkOrderCuttingHeader('search'), isset($_GET['WorkOrderCuttingHeader']) ? $_GET['WorkOrderCuttingHeader'] : array());
        $saleId = isset($_GET['SaleId']) ? $_GET['SaleId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
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
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Nobleman');
        $documentProperties->setTitle('Laporan SPK Cutting');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        $worksheet->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'PT SINAR PUTRA MELINDO');
        $worksheet->setCellValue('A2', 'Rekap Laporan SPK');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:J4');
        $worksheet->mergeCells('A5:J5');
        //$worksheet->mergeCells('F5:I5');
        //$worksheet->mergeCells('J5:M5');

        $worksheet->getStyle("A6:J6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:J6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:J6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'NO');
        //$worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'SPK');
        $worksheet->setCellValue('E6', 'Customer');
        //$worksheet->setCellValue('D6', 'Penjualan#');
        //$worksheet->setCellValue('E6', 'Catatan');
        //$worksheet->setCellValue('F5', 'Permintaan');
        $worksheet->setCellValue('C6', 'TIPE MATERIAL');
        /*$worksheet->setCellValue('G6', 'Panjang');
        $worksheet->setCellValue('H6', 'Lebar');
        $worksheet->setCellValue('I6', 'Tinggi');
        $worksheet->setCellValue('J5', 'Penawaran');
        $worksheet->setCellValue('J6', 'GRADE');
        $worksheet->setCellValue('K6', 'Panjang');
        $worksheet->setCellValue('L6', 'Lebar');
        $worksheet->setCellValue('M6', 'Tinggi');*/
        $worksheet->setCellValue('D6', 'Quantity');
        //$worksheet->setCellValue('O6', 'Berat');
        $worksheet->setCellValue('F6', 'M');
        $worksheet->setCellValue('G6', 'G');
        $worksheet->setCellValue('H6', 'FH');
        $worksheet->setCellValue('I6', 'ANNL');
        $worksheet->setCellValue('J6', 'SM');
        //$worksheet->setCellValue('U6', 'Order Luar');

        $counter = 7;
        $number = 1;

        foreach ($workOrderCuttingSummary->dataProvider->data as $header) {

            if ($header->saleHeader->is_service == 1) :
                foreach ($header->workOrderCuttingDetails as $service) {
                    $worksheet->setCellValue("A{$counter}", $number);
                    $number++;
                    //$worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')));
                    //$worksheet->setCellValue("D{$counter}", CHtml::encode($header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)));
                    //$worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($service, 'note')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($service, 'saleDetail.quotationDetailService.product_name')));
                    //$worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_request'))));
                    //$worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_request'))));
                    //$worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_request'))));
                    //$worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($service, 'saleDetail.quotationDetailService.product_name')));
                    //$worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_quote'))));
                    //$worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_quote'))));
                    //$worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_quote'))));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity'))));
                    //$worksheet->setCellValue("O{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($service, 'weight'))));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_miling') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_grinding') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_hardness') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_annelying') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_sidemiling') == 1) ? "Yes" : ""));
                    //$worksheet->setCellValue("U{$counter}", CHtml::encode((CHtml::value($service, 'is_external_order') == 1) ? "Yes" : "No"));
                    $counter++;

                }
            else:
                foreach ($header->workOrderCuttingDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", $number);
                    $number++;
                    //$worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')));
                    //$worksheet->setCellValue("D{$counter}", CHtml::encode($header->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)));
                    //$worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'note')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_request')));
                    //$worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))));
                    //$worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request'))));
                    //$worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request'))));
                    //$worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_quote')));
                    //$worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote'))));
                    //$worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote'))));
                    //$worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote'))));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))));
                    //$worksheet->setCellValue("O{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($detail, 'weight'))));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_miling') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_grinding') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_hardness') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_annelying') == 1) ? "Yes" : ""));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_sidemiling') == 1) ? "Yes" : ""));
                    //$worksheet->setCellValue("U{$counter}", CHtml::encode((CHtml::value($detail, 'is_external_order') == 1) ? "Yes" : "No"));
                    $counter++;
                
                }
            endif;
        }

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan SPK Cutting.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
