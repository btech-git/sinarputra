<?php

class DeliveryBackupController extends Controller {

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
		
        $deliveryBackupHeader = Search::bind(new DeliveryBackupHeader('search'), isset($_GET['DeliveryBackupHeader']) ? $_GET['DeliveryBackupHeader'] : array());

        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliveryBackupSummary = new DeliveryBackupSummary($deliveryBackupHeader->search());
        $deliveryBackupSummary->setupLoading();
        $deliveryBackupSummary->setupPaging($pageSize, $currentPage);
        $deliveryBackupSummary->setupSorting();
        $deliveryBackupSummary->setupFilter($startDate, $endDate, $customerName);
        
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($deliveryBackupSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'deliveryBackupSummary' => $deliveryBackupSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function saveToExcel($deliveryBackupSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Pengiriman Manual 2');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sinar Putra Metalindo');
        $worksheet->setTitle('Pengiriman Manual 2');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');
        
        $worksheet->getStyle('A1:W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:W5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'PT Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Pengiriman Manual 2');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:W5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:W5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Pengiriman #');
        $worksheet->setCellValue('C5', 'PO #');
        $worksheet->setCellValue('D5', 'SPK #');
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
        $worksheet->setCellValue('W5', 'COA');

        $counter = 6;

        foreach ($deliveryBackupSummary->dataProvider->data as $header) {
            foreach ($header->deliveryBackupDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_date'));
                $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(DeliveryBackupHeader::CN_CONSTANT));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'purchase_order_number'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'work_order_number'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.company'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'warehouse.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'employeeIdDriver.name'));
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
                $worksheet->setCellValue("W{$counter}", $detail->is_coating == 1 ? "Yes" : "");

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
        header('Content-Disposition: attachment;filename="Pengiriman Manual 2.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
