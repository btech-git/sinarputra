<?php

class DeliveryManualController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('deliveryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $deliveryManualHeader = Search::bind(new ManualDeliveryHeader('search'), isset($_GET['ManualDeliveryHeader']) ? $_GET['ManualDeliveryHeader'] : array());
        
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliveryManualSummary = new DeliveryManualSummary($deliveryManualHeader->search());
        $deliveryManualSummary->setupLoading();
        $deliveryManualSummary->setupPaging($pageSize, $currentPage);
        $deliveryManualSummary->setupSorting();
        $deliveryManualSummary->setupFilter($startDate, $endDate, $customerName);
        
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($deliveryManualSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'deliveryManualHeader' => $deliveryManualHeader,
            'deliveryManualSummary' => $deliveryManualSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function saveToExcel($deliveryManualSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Pengiriman Manual');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sinar Putra Metalindo');
        $worksheet->setTitle('Pengiriman Manual');

        $worksheet->mergeCells('A1:V1');
        $worksheet->mergeCells('A2:V2');
        $worksheet->mergeCells('A3:V3');
        
        $worksheet->getStyle('A1:V5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'PT Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Pengiriman Manual');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->getStyle("A5:V5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:V5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Pengiriman #');
        $worksheet->setCellValue('C5', 'SPK #');
        $worksheet->setCellValue('D5', 'PO #');
        $worksheet->setCellValue('E5', 'Customer');
        $worksheet->setCellValue('F5', 'Gudang');
        $worksheet->setCellValue('G5', 'Sopir');
        $worksheet->setCellValue('H5', 'Pembuat');
        $worksheet->setCellValue('I5', 'Catatan');
        $worksheet->setCellValue('J5', 'Waktu Input');
        $worksheet->setCellValue('K5', 'GRADE');
        $worksheet->setCellValue('L5', 'Kategori');
        $worksheet->setCellValue('M5', 'Tbl/Dmtr');
        $worksheet->setCellValue('N5', 'Lbr/Dmtr');
        $worksheet->setCellValue('O5', 'Panjang');
        $worksheet->setCellValue('P5', 'Berat');
        $worksheet->setCellValue('Q5', 'Quantity');
        $worksheet->setCellValue('R5', 'M');
        $worksheet->setCellValue('S5', 'SM');
        $worksheet->setCellValue('T5', 'G');
        $worksheet->setCellValue('U5', 'HT');
        $worksheet->setCellValue('V5', 'NTD');

        $counter = 6;

        foreach ($deliveryManualSummary->dataProvider->data as $header) {
            foreach ($header->manualDeliveryDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'date'));
                $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(ManualDeliveryHeader::CN_CONSTANT));
                $worksheet->setCellValue("C{$counter}", $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : '');
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer_order_number'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'warehouse.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'driver'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'admin.username'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'created_datetime'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'grade_name'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'productCategory.name'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'height'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($detail, 'width'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($detail, 'length'));
                $worksheet->setCellValue("P{$counter}", CHtml::value($detail, 'weight'));
                $worksheet->setCellValue("Q{$counter}", CHtml::value($detail, 'quantity'));
                $worksheet->setCellValue("R{$counter}", $detail->is_miling == 1 ? "Yes" : "");
                $worksheet->setCellValue("S{$counter}", $detail->is_sidemiling == 1 ? "Yes" : "");
                $worksheet->setCellValue("T{$counter}", $detail->is_grinding == 1 ? "Yes" : "");
                $worksheet->setCellValue("U{$counter}", $detail->is_hardness == 1 ? "Yes" : "");
                $worksheet->setCellValue("V{$counter}", $detail->is_annelying == 1 ? "Yes" : "");

                $counter++;
            }
        }

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Pengiriman Manual.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
