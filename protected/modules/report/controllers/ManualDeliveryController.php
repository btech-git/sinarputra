<?php

class DeliveryDailyController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('deliveryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $deliveryHeader = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliverySummary = new DeliverySummary($deliveryHeader->search());
        $deliverySummary->setupLoading();
        $deliverySummary->setupPaging($pageSize, $currentPage);
        $deliverySummary->setupSorting();
        $deliverySummary->setupFilter($startDate, $endDate, $customerName);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($deliverySummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'deliveryHeader' => $deliveryHeader,
            'deliverySummary' => $deliverySummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function saveToExcel($deliverySummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Delivery Daily');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Delivery Daily Report');

        $worksheet->mergeCells('A1:AC1');
        $worksheet->mergeCells('A2:AC2');
        $worksheet->mergeCells('A3:AC3');
        $worksheet->getStyle('A1:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AC3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'PT. SINAR PUTRA METALINDO');
        $worksheet->setCellValue('A2', 'Periode : ' . $startDate . ' - ' . $endDate);
        $worksheet->setCellValue('A3', '');

        $worksheet->getStyle("A4:AC4")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A4:AC4")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A4:U4')->getFont()->setBold(true);
        $worksheet->setCellValue('A4', 'NO');
        $worksheet->setCellValue('B4', 'TGL SO');
        $worksheet->setCellValue('C4', 'TGL SPK');
        $worksheet->setCellValue('D4', 'TGL QC');
        $worksheet->setCellValue('E4', 'TGL SJ');
        $worksheet->setCellValue('F4', 'QTY SPK');
        $worksheet->setCellValue('G4', 'QTY OS PRODUKSI');
        $worksheet->setCellValue('H4', 'CUSTOMER');
        $worksheet->setCellValue('I4', 'NO DELIVERY');
        $worksheet->setCellValue('J4', 'NO QTN');
        $worksheet->setCellValue('K4', 'NO SPK');
        $worksheet->setCellValue('L4', 'Job Number');
        $worksheet->setCellValue('M4', 'NO PO');
        $worksheet->setCellValue('N4', 'Tbl');
        $worksheet->setCellValue('O4', 'Lbr');
        $worksheet->setCellValue('P4', 'Pjg');
        $worksheet->setCellValue('Q4', 'QTY');
        $worksheet->setCellValue('R4', 'Berat');
        $worksheet->setCellValue('S4', 'Sopir');
        $worksheet->setCellValue('T4', 'KET');
        $worksheet->setCellValue('U4', 'User');
        $worksheet->setCellValue('V4', 'Salesman');
        $worksheet->setCellValue('W4', 'Grade');
        $worksheet->setCellValue('X4', 'Type');
        $worksheet->setCellValue('Y4', 'Kota Tujuan');
        $worksheet->setCellValue('Z4', 'Tgl Kirim Invoice');
        $worksheet->setCellValue('AA4', 'SJ Terkirim?');
        $worksheet->setCellValue('AB4', 'Status SJ');
        $worksheet->setCellValue('AC4', 'Jam');
        $counter = 5;
        $number = 1;

        foreach ($deliverySummary->dataProvider->data as $header) {
            foreach ($header->deliveryDetails as $detail){
                $worksheet->setCellValue("A{$counter}", $number);
                $number++;
                $worksheet->setCellValue("B{$counter}", $header->workOrderCuttingHeader->saleHeader->date);
                $worksheet->setCellValue("C{$counter}", $header->workOrderCuttingHeader->date);
                $worksheet->setCellValue("D{$counter}", empty($header->quality_control_cutting_header_id) ? "0000-00-00" : Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->qualityControlCuttingHeader->date)));
                $worksheet->setCellValue("E{$counter}", $header->date);
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.quantity')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.quantityCuttingQualityControlRemaining')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode($header->getCodeNumber(DeliveryHeader::CN_CONSTANT)));
                $worksheet->setCellValue("J{$counter}", CHtml::encode($detail->workOrderCuttingDetail->saleDetail->quotation_detail_product_id == NULL) ? $detail->workOrderCuttingDetail->saleDetail->quotationDetailService->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT) : $detail->workOrderCuttingDetail->saleDetail->quotationDetailProduct->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT));
                $worksheet->setCellValue("K{$counter}", $header->workOrderCuttingHeader ? CHtml::encode($header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : '');
                $worksheet->setCellValue("L{$counter}", ($detail->work_order_cutting_detail_id != null) ? CHtml::value($detail, 'workOrderCuttingDetail.job_number') : '');
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer_order_number')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'height')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'width')));
                $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($detail, 'length')));
                $worksheet->setCellValue("Q{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($header, 'driver')));
                $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));
                $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($header, 'workOrderCuttingHeader.saleHeader.employeeIdSalesman.name')));
                $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.product_name')));
                $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.productCategory.name')));
                $worksheet->setCellValue("Y{$counter}", CHtml::encode(CHtml::value($header, 'customer_city')));
                $worksheet->setCellValue("Z{$counter}", CHtml::encode(CHtml::value($header, 'date_invoice_sent')));
                $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($header, 'deliveryConfirmation')));
                $worksheet->setCellValue("AB{$counter}", CHtml::encode(CHtml::value($header, 'delivery_status')));
                $worksheet->setCellValue("AC{$counter}", CHtml::encode(CHtml::value($detail, '')));
            
                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'AC'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Delivery Daily Report.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
