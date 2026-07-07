<?php

class WorkOrderCuttingDetailMaterialController extends Controller {

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

        if (isset($_POST['SaveToExcel'])) 
            $this->saveToExcel($workOrderCuttingSummary, $startDate, $endDate);

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
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Material Awal SPK');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Material Awal SPK');

        $worksheet->mergeCells('A1:AC1');
        $worksheet->mergeCells('A2:AC2');
        $worksheet->mergeCells('A3:AC3');
        $worksheet->getStyle('A1:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AC3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Penggunaan Material Awal SPK');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:AC4');

        $worksheet->getStyle('A5:AC5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->mergeCells('G5:I5');
        $worksheet->mergeCells('J5:L5');
        $worksheet->mergeCells('Q5:S5');
        $worksheet->mergeCells('T5:W5');
    
        $worksheet->getStyle("A5:AC6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AC6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AC6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Tgl SPK');
        $worksheet->setCellValue('B6', 'NO SPK');
        $worksheet->setCellValue('C6', 'CUSTOMER');
        $worksheet->setCellValue('D6', 'SALES');
        $worksheet->setCellValue('E6', 'Jenis SO');
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
        $worksheet->setCellValue('P6', 'Jenis SPK');
        $worksheet->setCellValue('Q5', 'Awal');
        $worksheet->setCellValue('Q6', 'T');
        $worksheet->setCellValue('R6', 'L');
        $worksheet->setCellValue('S6', 'P');
        $worksheet->setCellValue('T6', 'Berat');
        $worksheet->setCellValue('U5', 'Sipot');
        $worksheet->setCellValue('U6', 'T');
        $worksheet->setCellValue('V6', 'L');
        $worksheet->setCellValue('W6', 'P');
        $worksheet->setCellValue('X6', 'Berat');
        $worksheet->setCellValue('Y6', 'NO REFF');
        $worksheet->setCellValue('Z6', 'Jam');
        $worksheet->setCellValue('AA6', 'User');
        $worksheet->setCellValue('AB6', 'Type');
        $worksheet->setCellValue('AC6', 'Tgl Kirim');
        $worksheet->setCellValue('AD6', 'Lembaran / Batangan ?');
        $counter = 7;

        foreach ($workOrderCuttingSummary->dataProvider->data as $header) {
            foreach ($header->workOrderCuttingDetails as $detail) {
                foreach ($detail->workOrderCuttingDetailMaterials as $material) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer.employee.name')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'saleDetail.quotationDetailProduct.product_name_quote')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'productCategory.name')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'height_request')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'width_request')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'length_request')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'height_quote')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'width_quote')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'length_quote')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($material, 'quantity')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode((CHtml::value($detail, 'is_cut') == 1) ? "C" : "") .
                            CHtml::encode((CHtml::value($detail, 'is_miling') == 1) ? "M" : "") 
                            //CHtml::encode((CHtml::value($detail, 'is_grinding') == 1) ? "G" : "") .
                            //CHtml::encode((CHtml::value($detail, 'is_hardness') == 1) ? "FH" : "") .
                            //CHtml::encode((CHtml::value($detail, 'is_annelying') == 1) ? "ANNL" : "") .
                            //CHtml::encode((CHtml::value($detail, 'is_sidemiling') == 1) ? "SM" : "")
                    );
                    $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($material, 'product_name')));
                    $initialMaterial = empty($material->work_order_cutting_detail_material_id) ? $material->receiveDetail : $material->workOrderCuttingDetailMaterial;
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($initialMaterial, 'height')));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($initialMaterial, 'width')));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($initialMaterial, 'length')));
                    $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($initialMaterial, 'weight')));
                    $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($material, 'height')));
                    $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($material, 'width')));
                    $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($material, 'length')));
                    $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($material, 'weight')));
                    $worksheet->setCellValue("Y{$counter}", CHtml::encode(CHtml::value($header, 'saleHeader.customer_order_number')));
                    $worksheet->setCellValue("Z{$counter}", CHtml::encode(CHtml::value($header, 'time_created')));
                    $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));
                    $worksheet->setCellValue("AB{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderStatus')));
                    $worksheet->setCellValue("AC{$counter}", CHtml::encode($header->saleHeader->estimate_delivery_date));
                    $worksheet->setCellValue("AD{$counter}", CHtml::encode($header->saleHeader->originalMaterialStatus));

                    $counter++;
                }
            }
        }

        for ($col = 'A'; $col !== 'AC'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Penggunaan Material Awal SPK.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
