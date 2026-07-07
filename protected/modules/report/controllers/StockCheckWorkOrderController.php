<?php

class StockCheckWorkOrderController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockCheck'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $workOrderCuttingDetailMaterial = Search::bind(new WorkOrderCuttingDetailMaterial('search'), isset($_GET['WorkOrderCuttingDetailMaterial']) ? $_GET['WorkOrderCuttingDetailMaterial'] : array());
        $productName     = (isset($_GET['ProductName'])) ? $_GET['ProductName'] : '';
        $productCategoryId = (isset($_GET['ProductCategoryId'])) ? $_GET['ProductCategoryId'] : '';
       
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
    
        $stockCheckSummary = new StockCheckSummary($workOrderCuttingDetailMaterial->searchProcessedStock());
        $stockCheckSummary->setupLoading();
        $stockCheckSummary->setupPaging($pageSize, $currentPage);
        $stockCheckSummary->setupSorting();
        $filters = array(
            'productName' => $productName,
            'productCategoryId' => $productCategoryId,
        );
        $stockCheckSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($stockCheckSummary);
        }

        $this->render('summary', array(
            'workOrderCuttingDetailMaterial' => $workOrderCuttingDetailMaterial,
            'stockCheckSummary' => $stockCheckSummary,
            'currentSort' => $currentSort,
            'productCategoryId' => $productCategoryId,
            'productName' => $productName,
        ));
    }

    protected function saveToExcel($stockCheckSummary) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Stok Sisa Potong');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Stok Sisa Potong');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        
        $worksheet->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Stok Sisa Potong');

        $worksheet->getStyle("A5:M5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:M5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:M5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'Serial Number');
        $worksheet->setCellValue('B5', 'GRADE');
        $worksheet->setCellValue('C5', 'Kategori');
        $worksheet->setCellValue('D5', 'Tebal');
        $worksheet->setCellValue('E5', 'Lebar');
        $worksheet->setCellValue('F5', 'Panjang');
        $worksheet->setCellValue('G5', 'Berat');
        $worksheet->setCellValue('H5', 'HRC');
        $worksheet->setCellValue('I5', 'Number Heat');
        $worksheet->setCellValue('J5', 'Name');
        $worksheet->setCellValue('K5', 'User');
        $worksheet->setCellValue('L5', 'Tanggal Terima');
        $worksheet->setCellValue('M5', 'Tanggal Keluar');

        $counter = 6;

        foreach ($stockCheckSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'serialConstant'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'product_name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'productCategory.name'));
            $worksheet->setCellValue("D{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->height));
            $worksheet->setCellValue("E{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->width));
            $worksheet->setCellValue("F{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->length));
            $worksheet->setCellValue("G{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->weight));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'receiveDetail.hardness_scale'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'receiveDetail.number_heat'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'location.name'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'workOrderCuttingDetail.workOrderCuttingHeader.admin.name'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'receiveDetail.receiveHeader.date'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'workOrderCuttingDetail.workOrderCuttingHeader.date'));

            $counter++;
        }

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Stok Sisa Potong.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }


}
