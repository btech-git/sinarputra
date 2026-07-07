<?php

class WorkOrderReplacementDetailController extends Controller {

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
//        $saleId = isset($_GET['SaleId']) ? $_GET['SaleId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
    
        $workOrderReplacementSummary = new WorkOrderReplacementSummary($workOrderReplacementHeader->search());
        $workOrderReplacementSummary->setupLoading();
        $workOrderReplacementSummary->setupPaging($pageSize, $currentPage);
        $workOrderReplacementSummary->setupSorting();
        $workOrderReplacementSummary->setupFilter($startDate, $endDate);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($workOrderReplacementSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'workOrderReplacementHeader' => $workOrderReplacementHeader,
            'workOrderReplacementSummary' => $workOrderReplacementSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
//            'saleId' => $saleId,
            
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
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan SPK Replacement Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK Replacement Detail');

        $worksheet->mergeCells('A1:V1');
        $worksheet->mergeCells('A2:V2');
        $worksheet->mergeCells('A3:V3');
        $worksheet->getStyle('A1:V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan SPK Replacement Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:V4');

        $worksheet->mergeCells('F5:H5');
        $worksheet->mergeCells('I5:K5');
    
        $worksheet->getStyle("A5:V6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:V6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:V6')->getFont()->setBold(true);

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
        $worksheet->setCellValue('N6', 'NO PO/ACC PO');
        $worksheet->setCellValue('O6', 'Proses');
        $worksheet->setCellValue('P6', 'Tgl Finish');
        $worksheet->setCellValue('Q6', 'Tgl SLA');
        $worksheet->setCellValue('R6', 'Keterangan NG');
        $worksheet->setCellValue('S6', 'Operator');
        $worksheet->setCellValue('T6', 'User');
        $worksheet->setCellValue('U6', 'Harga');
        $worksheet->setCellValue('V6', 'Catatan NG');

        $counter = 7;

        foreach ($workOrderReplacementSummary->dataProvider->data as $header) {
            $qualityControlHeader = (empty($header->quality_control_cutting_header_id)) ? $header->qualityControlMilingHeader : $header->qualityControlCuttingHeader;
            foreach ($header->workOrderReplacementDetails as $detail) {
                $qualityControlDetail = empty($detail->quality_control_cutting_detail_id) ? $detail->qualityControlMilingDetail : $detail->qualityControlCuttingDetail;
                $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'product_name')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'productCategory.name')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_request'))));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_request'))));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_request'))));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'height_quote'))));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'width_quote'))));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'length_quote'))));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'weightRequest')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer_order_number')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode((CHtml::value($detail, 'is_cut') == 1) ? "C" : "") .
                        CHtml::encode((CHtml::value($detail, 'is_miling') == 1) ? "M" : "") .
                        CHtml::encode((CHtml::value($detail, 'is_grinding') == 1) ? "G" : "") .
                        CHtml::encode((CHtml::value($detail, 'is_hardness') == 1) ? "FH" : "") .
                        CHtml::encode((CHtml::value($detail, 'is_annelying') == 1) ? "ANNL" : "") .
                        CHtml::encode((CHtml::value($detail, 'is_sidemiling') == 1) ? "SM" : ""));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($qualityControlHeader->date))));
//                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->qualityControlHeader->productionCuttingHeader->productionPlanningCuttingHeader->date))));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($qualityControlDetail, 'memo')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($qualityControlDetail, 'employee.name')));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.unit_price')));
                $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($qualityControlDetail, 'qualityControlCuttingHeader.note')));
                $counter++;
            }
        }


        for ($col = 'A'; $col !== 'Q'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan SPK Replacement Detail.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
