<?php

class WorkOrderCuttingInventoryDetailController extends Controller {

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
        $documentProperties->setCreator('Sinarputra');
        $documentProperties->setTitle('Laporan SPK Cutting Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK Cutting Detail');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');
        $worksheet->getStyle('A1:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan SPK Cutting Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:Q4');

        $worksheet->mergeCells('F5:H5');
        $worksheet->mergeCells('I5:K5');
    
        $worksheet->getStyle("A5:Q6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:Q6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:Q6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tgl SPK');
        $worksheet->setCellValue('B6', 'NO SPK');
        $worksheet->setCellValue('C6', 'CUSTOMER');
        $worksheet->setCellValue('D6', 'JENIS');
        $worksheet->setCellValue('E6', 'TIPE');
        $worksheet->setCellValue('F5', 'Permintaan');
        $worksheet->setCellValue('F6', 'T');
        $worksheet->setCellValue('G6', 'L');
        $worksheet->setCellValue('H6', 'P');
        $worksheet->setCellValue('I5', 'Penawaran');
        $worksheet->setCellValue('I6', 'T');
        $worksheet->setCellValue('J6', 'L');
        $worksheet->setCellValue('K6', 'P');
        $worksheet->setCellValue('L6', 'PCS');
        $worksheet->setCellValue('M6', 'KGS');
        $worksheet->setCellValue('N6', 'NO REFF');
        $worksheet->setCellValue('O6', 'Proses');
        $worksheet->setCellValue('P6', 'Plan Finish');
        $worksheet->setCellValue('Q6', 'Plan SLA');

        $counter = 7;

        foreach ($workOrderCuttingSummary->dataProvider->data as $header) {


            if ($header->saleHeader->is_service == 1) :
                foreach ($header->workOrderCuttingDetails as $service) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($service, 'saleDetail.quotationDetailService.product_name')));
                    $worksheet->setCellValue("E{$counter}");
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_request'))));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_request'))));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_request'))));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'height_quote'))));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'width_quote'))));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'length_quote'))));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'quantity'))));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($service, 'weight'))));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer_order_number')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_miling') == 1) ? "M" : "") .
                            CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_grinding') == 1) ? "G" : "") .
                            CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_hardness') == 1) ? "FH" : "") .
                            CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_annelying') == 1) ? "ANNL" : "") .
                            CHtml::encode((CHtml::value($service, 'saleDetail.quotationDetailService.is_sidemiling') == 1) ? "SM" : "")
                    );
                    $worksheet->setCellValue("P{$counter}"/*, $service->planFinish*/);
                    $worksheet->setCellValue("Q{$counter}"/*, $service->planFinish > 0 ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($service, 'planSla'))) : ''*/);
                    $counter++;
                }
            else:
                foreach ($header->workOrderCuttingDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_quote')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.productCategory.name')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request'))));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request'))));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote'))));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote'))));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote'))));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'saleDetail.quantity'))));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.000', CHtml::value($detail, 'weight'))));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer_order_number')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode((CHtml::value($detail, 'is_cut') == 1) ? "C" : "") .
                            CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_miling') == 1) ? "M" : "") .
                            CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_grinding') == 1) ? "G" : "") .
                            CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_hardness') == 1) ? "FH" : "") .
                            CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_annelying') == 1) ? "ANNL" : "") .
                            CHtml::encode((CHtml::value($detail, 'saleDetail.quotationDetailProduct.is_sidemiling') == 1) ? "SM" : ""));
                    $worksheet->setCellValue("P{$counter}"/*, $detail->planFinish*/);
                    $worksheet->setCellValue("Q{$counter}"/*, $detail->planFinish > 0 ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'planSla'))) : ''*/);
                    $counter++;
                }
            endif;
        }


        for ($col = 'A'; $col !== 'O'; $col++) {
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
