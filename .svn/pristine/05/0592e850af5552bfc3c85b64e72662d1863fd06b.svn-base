<?php

class StatusReviewController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('statusReviewCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $saleHeader = Search::bind(new SaleHeader(), isset($_GET['SaleHeader']) ? $_GET['SaleHeader'] : '');
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $saleHeaderDataProvider = $saleHeader->resetScope()->searchWithPaging();
        $saleHeaderDataProvider->criteria->with = array(
            'customer:resetScope',
        );

        $saleHeaderDataProvider->criteria->addCondition("customer.company LIKE :company");
        $saleHeaderDataProvider->criteria->params[':company'] = "%{$customerCompany}%";

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $saleHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $saleHeaderDataProvider->criteria->order = 't.date DESC';

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleHeaderDataProvider, $startDate, $endDate);
        }

        if (isset($_POST['ExportOutstanding'])) {
            $this->saveToExcelOutstanding($saleHeaderDataProvider, $startDate, $endDate);
        }

        $this->render('summary', array(
            'saleHeader' => $saleHeader,
            'saleHeaderDataProvider' => $saleHeaderDataProvider,
            'customerCompany' => $customerCompany,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    protected function saveToExcel($saleHeaderDataProvider, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Status Review');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Status Review');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:AD3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AD3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Status Review');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:AD5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:AD6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AD5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Tanggal Order');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', 'PO #');
        $worksheet->setCellValue('D5', 'Value');
        $worksheet->setCellValue('E5', 'SO #');
        $worksheet->setCellValue('F5', 'Tanggal Est Kirim');
        $worksheet->setCellValue('G5', 'Salesman');
        $worksheet->setCellValue('H5', 'SPK #');
        $worksheet->setCellValue('I5', 'Qty SPK');
        $worksheet->setCellValue('J5', 'Invoice #');
        $worksheet->setCellValue('K5', 'Tanggal Invoice');
        $worksheet->setCellValue('L5', 'TT #');
        $worksheet->setCellValue('M5', 'Tanggal TT');
        $worksheet->setCellValue('N5', 'Manual Invoice #');
        $worksheet->setCellValue('O5', 'Tanggal Manual Invoice');
        $worksheet->setCellValue('P5', 'Manual TT #');
        $worksheet->setCellValue('Q5', 'Tanggal TT');
        $worksheet->setCellValue('R5', 'Qty Invoice');
        $worksheet->setCellValue('S5', 'QC Cutting #');
        $worksheet->setCellValue('T5', 'QC Cutting Tanggal');
        $worksheet->setCellValue('U5', 'Qty QC Cutting');
        $worksheet->setCellValue('V5', 'SJ Cutting #');
        $worksheet->setCellValue('W5', 'SJ Cutting Tanggal');
        $worksheet->setCellValue('X5', 'Qty SJ Cutting');
        $worksheet->setCellValue('Y5', 'QC Miling #');
        $worksheet->setCellValue('Z5', 'QC Miling Tanggal');
        $worksheet->setCellValue('AA5', 'Qty QC Miling');
        $worksheet->setCellValue('AB5', 'SJ Miling #');
        $worksheet->setCellValue('AC5', 'SJ Miling Tanggal');
        $worksheet->setCellValue('AD5', 'Qty SJ Miling');

        $counter = 7;

        foreach ($saleHeaderDataProvider->data as $header) {
            $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('sale_header_id' => $header->id));
            
            if (empty($workOrderCuttingHeader->saleInvoiceHeaders[0]) && empty($workOrderCuttingHeader->manualSaleInvoiceHeaders[0])) {
                $worksheet->getStyle("A{$counter}:Z{$counter}")->applyFromArray(array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
            }
                
            $worksheet->setCellValue("A{$counter}", $header->date);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'customer.company'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer_order_number'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'grandTotalTransaction'));
            $worksheet->setCellValue("E{$counter}", $header->getCodeNumber(SaleHeader::CN_CONSTANT));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'estimate_delivery_date'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'employeeIdSalesman.name'));
            if (!empty($workOrderCuttingHeader)) {
                $worksheet->setCellValue("H{$counter}", $workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                $worksheet->setCellValue("I{$counter}", $workOrderCuttingHeader->getTotalQuantityDetail());
                $worksheet->setCellValue("J{$counter}", $workOrderCuttingHeader->getSaleInvoiceNumbers());
                $worksheet->setCellValue("K{$counter}", $workOrderCuttingHeader->getSaleInvoiceDates());
                $worksheet->setCellValue("L{$counter}", $workOrderCuttingHeader->getSaleReceiptNumbers());
                $worksheet->setCellValue("M{$counter}", $workOrderCuttingHeader->getSaleReceiptDates());
                $worksheet->setCellValue("N{$counter}", $workOrderCuttingHeader->getManualSaleInvoiceNumbers());
                $worksheet->setCellValue("O{$counter}", $workOrderCuttingHeader->getManualSaleInvoiceDates());
                $worksheet->setCellValue("P{$counter}", $workOrderCuttingHeader->getManualSaleReceiptNumbers());
                $worksheet->setCellValue("Q{$counter}", $workOrderCuttingHeader->getManualSaleReceiptDates());
                $worksheet->setCellValue("R{$counter}", $workOrderCuttingHeader->getSaleInvoiceQuantity());
                $worksheet->setCellValue("S{$counter}", $workOrderCuttingHeader->getQualityControlCuttingNumbers());
                $worksheet->setCellValue("T{$counter}", $workOrderCuttingHeader->getQualityControlCuttingDates());
                $worksheet->setCellValue("U{$counter}", $workOrderCuttingHeader->getQualityControlCuttingQuantity());
                $worksheet->setCellValue("V{$counter}", $workOrderCuttingHeader->getDeliveryCuttingNumbers());
                $worksheet->setCellValue("W{$counter}", $workOrderCuttingHeader->getDeliveryCuttingDates());
                $worksheet->setCellValue("X{$counter}", $workOrderCuttingHeader->getDeliveryCuttingQuantity());
                $worksheet->setCellValue("Y{$counter}", $workOrderCuttingHeader->getQualityControlMilingNumbers());
                $worksheet->setCellValue("Z{$counter}", $workOrderCuttingHeader->getQualityControlMilingDates());
                $worksheet->setCellValue("AA{$counter}", $workOrderCuttingHeader->getQualityControlMilingQuantity());
                $worksheet->setCellValue("AB{$counter}", $workOrderCuttingHeader->getDeliveryMilingNumbers());
                $worksheet->setCellValue("AC{$counter}", $workOrderCuttingHeader->getDeliveryMilingDates());
                $worksheet->setCellValue("AD{$counter}", $workOrderCuttingHeader->getDeliveryMilingQuantity());
            }

            $counter++;
        }

        for ($col = 'A'; $col !== 'AE'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Status Review.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelOutstanding($saleHeaderDataProvider, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Status Outstanding');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Status Outstanding');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');
        $worksheet->getStyle('A1:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Status Outstanding');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:AD5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:AD6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:AD5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A5:AD5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'Tanggal Order');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', 'PO #');
        $worksheet->setCellValue('D5', 'Value');
        $worksheet->setCellValue('E5', 'SO #');
        $worksheet->setCellValue('F5', 'Tanggal Est Kirim');
        $worksheet->setCellValue('G5', 'Salesman');
        $worksheet->setCellValue('H5', 'SPK #');
        $worksheet->setCellValue('I5', 'Qty SPK');
        $worksheet->setCellValue('J5', 'Invoice #');
        $worksheet->setCellValue('K5', 'Tanggal Invoice');
        $worksheet->setCellValue('L5', 'TT #');
        $worksheet->setCellValue('M5', 'Tanggal TT');
        $worksheet->setCellValue('N5', 'Manual Invoice #');
        $worksheet->setCellValue('O5', 'Tanggal Manual Invoice');
        $worksheet->setCellValue('P5', 'Manual TT #');
        $worksheet->setCellValue('Q5', 'Tanggal TT');
        $worksheet->setCellValue('R5', 'Qty Invoice');
        $worksheet->setCellValue('S5', 'QC Cutting #');
        $worksheet->setCellValue('T5', 'QC Cutting Tanggal');
        $worksheet->setCellValue('U5', 'Qty QC Cutting');
        $worksheet->setCellValue('V5', 'SJ Cutting #');
        $worksheet->setCellValue('W5', 'SJ Cutting Tanggal');
        $worksheet->setCellValue('X5', 'Qty SJ Cutting');
        $worksheet->setCellValue('Y5', 'QC Miling #');
        $worksheet->setCellValue('Z5', 'QC Miling Tanggal');
        $worksheet->setCellValue('AA5', 'Qty QC Miling');
        $worksheet->setCellValue('AB5', 'SJ Miling #');
        $worksheet->setCellValue('AC5', 'SJ Miling Tanggal');
        $worksheet->setCellValue('AD5', 'Qty SJ Miling');

        $counter = 7;

        foreach ($saleHeaderDataProvider->data as $header) {
            if (empty($header->workOrderCuttingHeaders[0]->saleInvoiceHeaders[0])) {
                $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('sale_header_id' => $header->id));
            
                $worksheet->setCellValue("A{$counter}", $header->date);
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'customer.company'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer_order_number'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'grandTotalTransaction'));
                $worksheet->setCellValue("E{$counter}", $header->getCodeNumber(SaleHeader::CN_CONSTANT));
                $worksheet->setCellValue("F{$counter}", $header->estimate_delivery_date);
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'employeeIdSalesman.name'));
                
                if (!empty($workOrderCuttingHeader)) {
                    $worksheet->setCellValue("H{$counter}", $workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                    $worksheet->setCellValue("I{$counter}", $workOrderCuttingHeader->getTotalQuantityDetail());
                    $worksheet->setCellValue("J{$counter}", $workOrderCuttingHeader->getSaleInvoiceNumbers());
                    $worksheet->setCellValue("K{$counter}", $workOrderCuttingHeader->getSaleInvoiceDates());
                    $worksheet->setCellValue("L{$counter}", $workOrderCuttingHeader->getSaleReceiptNumbers());
                    $worksheet->setCellValue("M{$counter}", $workOrderCuttingHeader->getSaleReceiptDates());
                    $worksheet->setCellValue("N{$counter}", $workOrderCuttingHeader->getManualSaleInvoiceNumbers());
                    $worksheet->setCellValue("O{$counter}", $workOrderCuttingHeader->getManualSaleInvoiceDates());
                    $worksheet->setCellValue("P{$counter}", $workOrderCuttingHeader->getManualSaleReceiptNumbers());
                    $worksheet->setCellValue("Q{$counter}", $workOrderCuttingHeader->getManualSaleReceiptDates());
                    $worksheet->setCellValue("R{$counter}", $workOrderCuttingHeader->getSaleInvoiceQuantity());
                    $worksheet->setCellValue("S{$counter}", $workOrderCuttingHeader->getQualityControlCuttingNumbers());
                    $worksheet->setCellValue("T{$counter}", $workOrderCuttingHeader->getQualityControlCuttingDates());
                    $worksheet->setCellValue("U{$counter}", $workOrderCuttingHeader->getQualityControlCuttingQuantity());
                    $worksheet->setCellValue("V{$counter}", $workOrderCuttingHeader->getDeliveryCuttingNumbers());
                    $worksheet->setCellValue("W{$counter}", $workOrderCuttingHeader->getDeliveryCuttingDates());
                    $worksheet->setCellValue("X{$counter}", $workOrderCuttingHeader->getDeliveryCuttingQuantity());
                    $worksheet->setCellValue("Y{$counter}", $workOrderCuttingHeader->getQualityControlMilingNumbers());
                    $worksheet->setCellValue("Z{$counter}", $workOrderCuttingHeader->getQualityControlMilingDates());
                    $worksheet->setCellValue("AA{$counter}", $workOrderCuttingHeader->getQualityControlMilingQuantity());
                    $worksheet->setCellValue("AB{$counter}", $workOrderCuttingHeader->getDeliveryMilingNumbers());
                    $worksheet->setCellValue("AC{$counter}", $workOrderCuttingHeader->getDeliveryMilingDates());
                    $worksheet->setCellValue("AD{$counter}", $workOrderCuttingHeader->getDeliveryMilingQuantity());
                }
                
                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'AE'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Status Outstanding.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}