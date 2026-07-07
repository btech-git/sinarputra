<?php

class WorkOrderCuttingDetailMaterialBySnController extends Controller {

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
		
        $workOrderCuttingDetailMaterial = Search::bind(new WorkOrderCuttingDetailMaterial('search'), isset($_GET['WorkOrderCuttingDetailMaterial']) ? $_GET['WorkOrderCuttingDetailMaterial'] : array());
        $serialNumber = isset($_GET['SerialNumber']) ? $_GET['SerialNumber'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
    
        $workOrderCuttingDetailMaterialSummary = new WorkOrderCuttingDetailMaterialSummary($workOrderCuttingDetailMaterial->search());
        $workOrderCuttingDetailMaterialSummary->setupLoading();
        $workOrderCuttingDetailMaterialSummary->setupPaging($pageSize, $currentPage);
        $workOrderCuttingDetailMaterialSummary->setupSorting();
        $workOrderCuttingDetailMaterialSummary->setupFilter($startDate, $endDate, $serialNumber);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($workOrderCuttingDetailMaterialSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
            'workOrderCuttingDetailMaterialSummary' => $workOrderCuttingDetailMaterialSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'serialNumber' => $serialNumber,
            
        ));
    }

    protected function saveToExcel($workOrderCuttingDetailMaterialSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinarputra');
        $documentProperties->setTitle('Laporan SPK Detail By SN');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan SPK Detail By SN');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');
        $worksheet->getStyle('A1:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan SPK Detail By SN');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:Q4');

        $worksheet->getStyle("A6:Q6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:Q6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:Q6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Item Code');
        $worksheet->setCellValue('C6', 'Grade');
        $worksheet->setCellValue('D6', 'TIPE');
        $worksheet->setCellValue('E6', 'Tebal');
        $worksheet->setCellValue('F6', 'Lebar');
        $worksheet->setCellValue('G6', 'Panjang');
        $worksheet->setCellValue('H6', 'Toleransi');
        $worksheet->setCellValue('I6', 'SPK #');
        $worksheet->setCellValue('J6', 'PCS');
        $worksheet->setCellValue('K6', 'Sisa');
        $worksheet->setCellValue('L6', 'Keterangan');
        $worksheet->setCellValue('M6', 'Customer');
        $worksheet->setCellValue('N6', 'Serial Number');
        $worksheet->setCellValue('O6', 'LOC');
        $worksheet->setCellValue('P6', 'Berat');
        $worksheet->setCellValue('Q6', 'User');

        $counter = 7;
        $number = 1;

        foreach ($workOrderCuttingDetailMaterialSummary->dataProvider->data as $header) {

                    $worksheet->setCellValue("A{$counter}", $number);
                    $number++;
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingDetail.job_number')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'product_name')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'productCategory.name')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'workOrderCuttingDetail.height_quote'))));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'workOrderCuttingDetail.width_quote'))));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'workOrderCuttingDetail.length_quote'))));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'weight_tolerance'))));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode($header->workOrderCuttingDetail->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'quantity')));
                    $worksheet->setCellValue("K{$counter}");
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingDetail.note')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingDetail.workOrderCuttingHeader.saleHeader.customer.company')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($header, 'serialConstant')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header, 'location.name')));
                    $worksheet->setCellValue("P{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($header, 'weight'))));
                    $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingDetail.workOrderCuttingHeader.admin.name')));

                    $counter++;
        }

        $counter++;


        for ($col = 'A'; $col !== 'O'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan SPK Detail By SN.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
