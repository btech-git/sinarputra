<?php

class PurchaseDetailController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $purchaseHeader = Search::bind(new PurchaseHeader('search'), isset($_GET['PurchaseHeader']) ? $_GET['PurchaseHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $status = (isset($_GET['Status'])) ? $_GET['Status'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $purchaseDetailSummary = new PurchaseDetailSummary($purchaseHeader->search());
        $purchaseDetailSummary->setupLoading();
        $purchaseDetailSummary->setupPaging($pageSize, $currentPage);
        $purchaseDetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
            'status' => $status
        );
        $purchaseDetailSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseDetailSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchaseHeader' => $purchaseHeader,
            'purchaseDetailSummary' => $purchaseDetailSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
            'status' => $status
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            foreach ($data->purchaseDetails as $detail)
                $grandTotal += $detail->total;
        }

        return $grandTotal;
    }

    protected function saveToExcel($purchaseDetailSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
//        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
//        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Pembelian Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Order Pembelian');

        $worksheet->mergeCells('A1:V1');
        $worksheet->mergeCells('A2:V2');
        $worksheet->mergeCells('A3:V3');
        $worksheet->getStyle('A1:V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Sistem');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Detail');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:V4');
        $worksheet->mergeCells('A5:V5');

        $worksheet->getStyle("A6:V6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:V6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:V6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'PO #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('D6', 'Tipe');
        $worksheet->setCellValue('E6', 'Grade');
        $worksheet->setCellValue('F6', 'Kategori');
        $worksheet->setCellValue('G6', 'Tbl/Dmtr');
        $worksheet->setCellValue('H6', 'Lbr');
        $worksheet->setCellValue('I6', 'Pjg');
        $worksheet->setCellValue('J6', 'Qty PO');
        $worksheet->setCellValue('K6', 'Qty Terima');
        $worksheet->setCellValue('L6', 'Outstanding');
        $worksheet->setCellValue('M6', 'Berat');
        $worksheet->setCellValue('N6', 'Harga');
        $worksheet->setCellValue('O6', 'Discount');
        $worksheet->setCellValue('P6', 'DPP');
        $worksheet->setCellValue('Q6', 'PPN');
        $worksheet->setCellValue('R6', 'Total');
        $worksheet->setCellValue('S6', 'Tgl Dibutuhkan');
        $worksheet->setCellValue('T6', 'Tgl Received');
        $worksheet->setCellValue('U6', 'Catatan');
        $worksheet->setCellValue('V6', 'User');

        $counter = 7;

        foreach ($purchaseDetailSummary->dataProvider->data as $header) {
            if ($header->is_service == 1) {
                foreach ($header->purchaseDetailServices as $service) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($header->getCodeNumber(PurchaseHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->date));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.company'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'importStatus'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($service, 'name'));
                    $worksheet->setCellValue("F{$counter}");
                    $worksheet->setCellValue("G{$counter}", CHtml::value($service, 'height'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($service, 'width'));
                    $worksheet->setCellValue("I{$counter}", CHtml::value($service, 'length'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($service, 'quantity'));
                    $worksheet->setCellValue("K{$counter}", '0');
                    $worksheet->setCellValue("L{$counter}", '0');
                    $worksheet->setCellValue("M{$counter}", CHtml::value($service, 'weight'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($service, 'unit_price'));
                    $worksheet->setCellValue("O{$counter}", CHtml::value($service, 'reportDiscountItem'));
                    $worksheet->setCellValue("P{$counter}", CHtml::value($service, 'reportTotalAfterDiscountItem'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($service, 'reportTaxItem'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($service, 'reportTotalAfterTaxItem'));
                    $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'note'));
                    $worksheet->setCellValue("T{$counter}", CHtml::value($header,'admin.name'));

                    $counter++;
                }
            } else {
                foreach ($header->purchaseDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($header->getCodeNumber(PurchaseHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.company'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'importStatus'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($detail, 'product_name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($detail, 'productCategory.name'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($detail, 'height'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($detail, 'width'));
                    $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'length'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'quantity'));
                    $worksheet->setCellValue("K{$counter}", CHtml::value($detail,'totalReceived'));
                    $worksheet->setCellValue("L{$counter}", CHtml::value($detail,'remainingQuantity'));
                    $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'weight'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($detail, 'unit_price'));
                    $worksheet->setCellValue("O{$counter}", CHtml::value($detail, 'reportDiscountItem'));
                    $worksheet->setCellValue("P{$counter}", CHtml::value($detail, 'reportTotalAfterDiscountItem'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($detail, 'reportTaxItem'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($detail, 'reportTotalAfterTaxItem'));
                    $worksheet->setCellValue("S{$counter}", CHtml::encode($header->estimate_receive_date));
                    $worksheet->setCellValue("T{$counter}", empty($header->receiveHeaders) ? "" : CHtml::encode($header->receiveHeaders[0]->date));
                    $worksheet->setCellValue("U{$counter}", CHtml::value($header, 'note'));
                    $worksheet->setCellValue("V{$counter}", CHtml::value($header,'admin.name'));

                    $counter++;
                }
            }

        }

        $counter++;

        for ($col = 'A'; $col !== 'V'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Pembelian Detail.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
