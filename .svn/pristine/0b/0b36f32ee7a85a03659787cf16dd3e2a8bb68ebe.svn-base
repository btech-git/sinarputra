<?php

class PurchaseReceiptSupplierController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseReceiptReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $purchaseReceiptSupplierSummary = new PurchaseReceiptSupplierSummary($supplier->search());
        $purchaseReceiptSupplierSummary->setupLoading();
        $purchaseReceiptSupplierSummary->setupPaging($pageSize, $currentPage);
        $purchaseReceiptSupplierSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
        );
        $purchaseReceiptSupplierSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseReceiptSupplierSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'supplier' => $supplier,
            'purchaseReceiptSupplierSummary' => $purchaseReceiptSupplierSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
        ));
    }

    protected function saveToExcel($purchaseReceiptSupplierSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Hutang Supplier');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Hutang Supplier');

        $worksheet->mergeCells('A1:AA1');
        $worksheet->mergeCells('A2:AA2');
        $worksheet->mergeCells('A3:AA3');
        $worksheet->getStyle('A1:AA3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AA3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Hutang Suplier');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:AA4');

        $worksheet->getStyle("A6:AA6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:AA6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A6:AA6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Invoice No');
        $worksheet->setCellValue('C6', 'Tanggal');
        $worksheet->setCellValue('D6', 'Amount');
        $worksheet->setCellValue('E6', 'Estimate Receive');
        $worksheet->setCellValue('F6', 'Supplier');
        $worksheet->setCellValue('G6', 'No Dokumen');
        $worksheet->setCellValue('H6', 'No Faktur Pajak');
        $worksheet->setCellValue('I6', 'PO #');
        $worksheet->setCellValue('J6', 'Tanggal PO');
        $worksheet->setCellValue('K6', 'Kelengkapan SJ (OK/NG)');
        $worksheet->setCellValue('L6', 'Status PO (Open/Close)');
        $worksheet->setCellValue('M6', 'Tgl Tanda Terima');
        $worksheet->setCellValue('N6', 'Tgl Jatuh Tempo');
        $worksheet->setCellValue('O6', 'Curr');
        $worksheet->setCellValue('P6', 'DPP');
        $worksheet->setCellValue('Q6', 'DISC');
        $worksheet->setCellValue('R6', 'VAT 10%');
        $worksheet->setCellValue('S6', 'Prepaid PPh');
        $worksheet->setCellValue('T6', 'Total Payment');
        $worksheet->setCellValue('U6', 'Memo');
        $worksheet->setCellValue('V6', 'Tanggal Pembayaran');
        $worksheet->setCellValue('W6', 'Via');
        $worksheet->setCellValue('X6', 'Status (Open/Close)');
        $worksheet->setCellValue('Y6', 'Jenis Barang');
        $worksheet->setCellValue('Z6', 'Asset');
        $worksheet->setCellValue('AA6', 'Keterangan');
        $worksheet->setCellValue('AB6', 'User');

        $counter = 7;
        $number = 1;

        foreach ($purchaseReceiptSupplierSummary->dataProvider->data as $header) {
            foreach ($header->purchaseReceiptHeaders as $receipt) {
                foreach ($receipt->purchaseReceiptDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", $number);
                    $number++;
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($detail->purchaseInvoice->getCodeNumber(PurchaseInvoice::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->purchaseInvoice->date))));
                    $worksheet->setCellValue("D{$counter}", $detail->purchaseInvoice->grand_total);
                    
                    if (!empty($detail->purchaseInvoice->receiveHeader)) {
                        $worksheet->setCellValue("E{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->purchaseInvoice->receiveHeader->purchaseHeader->estimate_receive_date))));
                    } else {
                        $worksheet->setCellValue("E{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->estimate_receive_date))));
                    }
                    
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'company')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'purchaseInvoice.supplier_document_number')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'purchaseInvoice.supplier_tax_invoice_number')));
                    
                    if (!empty($detail->purchaseInvoice->receiveHeader)) {
                        $worksheet->setCellValue("I{$counter}", CHtml::encode($detail->purchaseInvoice->receiveHeader->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)));
                        $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->purchaseInvoice->receiveHeader->purchaseHeader->date))));
                        $worksheet->setCellValue("K{$counter}");
                        $worksheet->setCellValue("L{$counter}", $detail->purchaseInvoice->receiveHeader->purchaseHeader->statusOpenClose);
                    } else {
                        $worksheet->setCellValue("I{$counter}", CHtml::encode($detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->getCodeNumber(PurchaseItemHeader::CN_CONSTANT)));
                        $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->date))));
                        $worksheet->setCellValue("K{$counter}");
                        $worksheet->setCellValue("L{$counter}", $detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->statusOpenClose);
                    }
                    
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receipt->date))));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receipt->due_date))));
                    $worksheet->setCellValue("O{$counter}");
                    
                    if (!empty($detail->purchaseInvoice->receiveHeader)) {
                        $worksheet->setCellValue("P{$counter}", $detail->purchaseInvoice->receiveHeader->purchaseHeader->subTotal);
                        $worksheet->setCellValue("Q{$counter}", $detail->purchaseInvoice->receiveHeader->purchaseHeader->discountAmount);
                        $worksheet->setCellValue("R{$counter}", $detail->purchaseInvoice->receiveHeader->purchaseHeader->calculatedTax);
                        $worksheet->setCellValue("S{$counter}", $detail->purchaseInvoice->receiveHeader->purchaseHeader->calculatedTaxIncome);
                    } else {
                        $worksheet->setCellValue("P{$counter}", $detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->subTotal);
                        $worksheet->setCellValue("Q{$counter}", $detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->discount);
                        $worksheet->setCellValue("R{$counter}", $detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->calculatedTax);
                        $worksheet->setCellValue("S{$counter}", $detail->purchaseInvoice->receiveItemHeader->purchaseItemHeader->calculatedTaxIncome);
                    }
                    
                    $worksheet->setCellValue("T{$counter}", $receipt->payment_total);
                    $worksheet->setCellValue("U{$counter}", $detail->memo);
                    
                    if (!empty($receipt->purchasePaymentHeaders[0])) {
                        $worksheet->setCellValue("V{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($receipt->purchasePaymentHeaders[0]->date))));
                    } else {
                        $worksheet->setCellValue("V{$counter}", '0.00');
                    }
                    
                    $worksheet->setCellValue("W{$counter}");
                    $worksheet->setCellValue("X{$counter}");
                    $worksheet->setCellValue("Y{$counter}");
                    $worksheet->setCellValue("Z{$counter}");
                    $worksheet->setCellValue("AA{$counter}", CHtml::encode(CHtml::value($receipt, 'note')));
                    $worksheet->setCellValue("AB{$counter}", CHtml::encode(CHtml::value($receipt, 'admin.name')));

                    $counter++;
                }
            }
        }

        $counter++;

        for ($col = 'A'; $col !== 'AB'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Hutang Supplier.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}