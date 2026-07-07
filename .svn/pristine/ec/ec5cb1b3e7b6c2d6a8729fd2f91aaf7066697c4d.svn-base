<?php

class StockCheckController extends Controller {

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
		
        $receiveDetail = Search::bind(new ReceiveDetail('search'), isset($_GET['ReceiveDetail']) ? $_GET['ReceiveDetail'] : array());
        $productCategoryId = (isset($_GET['ProductCategoryId'])) ? $_GET['ProductCategoryId'] : '';
        $productName     = (isset($_GET['ProductName'])) ? $_GET['ProductName'] : '';

        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $stockCheckSummary = new StockCheckSummary($receiveDetail->searchNotSelectedInCuttingDetailMaterial());
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
            'receiveDetail' => $receiveDetail,
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
        $documentProperties->setTitle('Laporan Stok Lembaran');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Stok Lembaran');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        
        $worksheet->getStyle('A1:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N3')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Stok Lembaran');
    
        $worksheet->getStyle("A5:N5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:N5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:N5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Serial Number');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'GRADE');
        $worksheet->setCellValue('D5', 'Kategori');
        $worksheet->setCellValue('E5', 'Tebal');
        $worksheet->setCellValue('F5', 'Lebar');
        $worksheet->setCellValue('G5', 'Panjang');
        $worksheet->setCellValue('H5', 'Berat');
        $worksheet->setCellValue('I5', 'Berat Packing');
        $worksheet->setCellValue('J5', 'HRC');
        $worksheet->setCellValue('K5', 'Number Heat');
        $worksheet->setCellValue('L5', 'Lokasi');
        $worksheet->setCellValue('M5', 'User');
        $worksheet->setCellValue('N5', 'Tanggal Terima');

        $counter = 6;

        foreach ($stockCheckSummary->dataProvider->data as $receiveDetail) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($receiveDetail, 'serialConstant'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($receiveDetail, 'product.code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($receiveDetail, 'product_name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($receiveDetail, 'productCategory.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($receiveDetail, 'height'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($receiveDetail, 'width'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($receiveDetail, 'length'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($receiveDetail, 'weight'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($receiveDetail, 'weight_packing'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($receiveDetail,'hardness_scale'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($receiveDetail,'number_heat'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($receiveDetail, 'location.name'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($receiveDetail, 'receiveHeader.admin.name'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($receiveDetail, 'receiveHeader.date'));

            $counter++;
        }

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Stok Lembaran.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
