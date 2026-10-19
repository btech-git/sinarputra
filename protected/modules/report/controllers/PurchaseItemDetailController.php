<?php

class PurchaseItemDetailController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseReport'))) {
                $this->redirect(array('/site/login')); 
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $purchaseItemHeader = Search::bind(new PurchaseItemHeader('search'), isset($_GET['PurchaseItemHeader']) ? $_GET['PurchaseItemHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
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
            foreach ($data->purchaseItemDetails as $detail) {
                $grandTotal += $detail->total;
            }
        }

        return $grandTotal;
    }

    protected function saveToExcel($purchaseItemDetailSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Pembelian Penunjang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian Penunjang');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        
        $worksheet->getStyle('A1:S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Penunjang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:S5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:S5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Pembelian #');
        $worksheet->setCellValue('C5', 'Supplier');
        $worksheet->setCellValue('D5', 'Nama Barang');
        $worksheet->setCellValue('E5', 'Deskripsi');
        $worksheet->setCellValue('F5', 'Kategori');
        $worksheet->setCellValue('G5', 'Qty PO');
        $worksheet->setCellValue('H5', 'Qty Terima');
        $worksheet->setCellValue('I5', 'Outstanding');
        $worksheet->setCellValue('J5', 'Satuan');
        $worksheet->setCellValue('K5', 'Harga Satuan');
        $worksheet->setCellValue('L5', 'Discount');
        $worksheet->setCellValue('M5', 'DPP');
        $worksheet->setCellValue('N5', 'PPN');
        $worksheet->setCellValue('O5', 'Total');
        $worksheet->setCellValue('P5', 'Catatan');
        $worksheet->setCellValue('Q5', 'Tgl Dibutuhkan');
        $worksheet->setCellValue('R5', 'Tgl Terima');
        $worksheet->setCellValue('S5', 'User');

        $counter = 6;

        foreach ($purchaseItemDetailSummary->dataProvider->data as $header) {
            foreach ($header->purchaseItemDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", $header->date);
                $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(PurchaseItemHeader::CN_CONSTANT));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.company'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($detail, 'item.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($detail, 'item.description'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($detail, 'item.itemCategory.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($detail, 'quantity'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($detail, 'totalReceived'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'remainingQuantity'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail,'item.unit.name'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'unit_price'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'discount_amount'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'reportTotalAfterDiscountItem'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($detail, 'reportTaxItem'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($detail, 'reportTotalAfterTaxItem'));
                $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'estimate_receive_date'));
                $worksheet->setCellValue("R{$counter}", empty($header->receiveItemHeaders) ? '' : $header->receiveItemHeaders[0]->date);
                $worksheet->setCellValue("S{$counter}", CHtml::value($header,'admin.name'));
                $counter++;
            }

        }
        
        $worksheet->getStyle("A{$counter}:S{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:S{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("J{$counter}:S{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        
        $worksheet->setCellValue("N{$counter}", 'Total Pembelian ');
        $worksheet->setCellValue("O{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::encode($this->reportGrandTotal($purchaseItemDetailSummary->dataProvider))));

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian Penunjang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}