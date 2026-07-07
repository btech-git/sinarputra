<?php

class PurchaseItemDetailController extends Controller {

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
		
        $purchaseItemHeader = Search::bind(new PurchaseItemHeader('search'), isset($_GET['PurchaseItemHeader']) ? $_GET['PurchaseItemHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $purchaseItemDetailSummary = new PurchaseItemDetailSummary($purchaseItemHeader->search());
        $purchaseItemDetailSummary->setupLoading();
        $purchaseItemDetailSummary->setupPaging($pageSize, $currentPage);
        $purchaseItemDetailSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
        );
        $purchaseItemDetailSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseItemDetailSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchaseItemHeader' => $purchaseItemHeader,
            'purchaseItemDetailSummary' => $purchaseItemDetailSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            foreach ($data->purchaseItemDetails as $detail)
                $grandTotal += $detail->total;
        }

        return $grandTotal;
    }

    protected function saveToExcel($purchaseItemDetailSummary, $startDate, $endDate) {
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
        $documentProperties->setCreator('PT. Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Pembelian Penunjang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian Penunjang');

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');
        $worksheet->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:T3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Penunjang');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:T4');
        $worksheet->mergeCells('A5:T5');

        $worksheet->getStyle("A6:T6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:T6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:T6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Pembelian #');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('E6', 'Nama Barang');
        $worksheet->setCellValue('F6', 'Deskripsi');
        $worksheet->setCellValue('G6', 'Kategori');
        $worksheet->setCellValue('H6', 'Qty PO');
        $worksheet->setCellValue('I6', 'Qty Terima');
        $worksheet->setCellValue('J6', 'Outstanding');
        $worksheet->setCellValue('K6', 'Satuan');
        $worksheet->setCellValue('L6', 'Harga Satuan');
        $worksheet->setCellValue('M6', 'Discount');
        $worksheet->setCellValue('N6', 'DPP');
        $worksheet->setCellValue('O6', 'PPN');
        $worksheet->setCellValue('P6', 'Total');
        $worksheet->setCellValue('Q6', 'Catatan');
        $worksheet->setCellValue('R6', 'Tgl Dibutuhkan');
        $worksheet->setCellValue('S6', 'Tgl Terima');
        $worksheet->setCellValue('T6', 'User');

        $counter = 7;

        foreach ($purchaseItemDetailSummary->dataProvider->data as $header) {
            foreach ($header->purchaseItemDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", $header->date);
                $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header,'supplier.company'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($detail,'item.name'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($detail,'item.description'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($detail,'item.itemCategory.name'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail,'quantity'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail,'totalReceived'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail,'remainingQuantity'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail,'item.unit.name'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'unit_price'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'reportDiscountItem'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($detail, 'reportTotalAfterDiscountItem'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($detail, 'reportTaxItem'));
                $worksheet->setCellValue("P{$counter}", CHtml::value($detail, 'reportTotalAfterTaxItem'));
                $worksheet->setCellValue("Q{$counter}", CHtml::value($header,'note'));
                $worksheet->setCellValue("R{$counter}", $header->estimate_receive_date);
                $worksheet->setCellValue("S{$counter}", empty($header->receiveItemHeaders) ? '' : $header->receiveItemHeaders[0]->date);
                $worksheet->setCellValue("T{$counter}", CHtml::value($header,'admin.name'));
                $counter++;
            }

        }
        $worksheet->getStyle("A{$counter}:T{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:T{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("J{$counter}:T{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("L{$counter}", 'Total Pembelian ');
        $worksheet->setCellValue("P{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::encode($this->reportGrandTotal($purchaseItemDetailSummary->dataProvider))));

        $counter++;

        for ($col = 'A'; $col !== 'T'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Order Pembelian.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}