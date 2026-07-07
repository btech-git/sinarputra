<?php

class PurchaseInvoiceController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseInvoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $purchaseInvoice = Search::bind(new PurchaseInvoice('search'), isset($_GET['PurchaseInvoice']) ? $_GET['PurchaseInvoice'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $purchaseInvoiceSummary = new PurchaseInvoiceSummary($purchaseInvoice->search());
        $purchaseInvoiceSummary->setupLoading();
        $purchaseInvoiceSummary->setupPaging($pageSize, $currentPage);
        $purchaseInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
        );
        $purchaseInvoiceSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseInvoiceSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchaseInvoice' => $purchaseInvoice,
            'purchaseInvoiceSummary' => $purchaseInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

    protected function saveToExcel($purchaseInvoiceSummary, $startDate, $endDate) {
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
        $documentProperties->setCreator('Nobleman');
        $documentProperties->setTitle('Laporan Faktur Pembelian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Pembelian');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        $worksheet->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Sistem');
        $worksheet->setCellValue('A2', 'Laporan Faktur Pembelian');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:O4');
        $worksheet->mergeCells('A5:O5');

        $worksheet->getStyle("A6:O6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:O6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:O6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur#');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('D6', 'Employee');
        $worksheet->setCellValue('E6', 'Penerimaan#');
        $worksheet->setCellValue('F6', 'Catatan');
        $worksheet->setCellValue('G6', 'GRADE');
        $worksheet->setCellValue('H6', 'Tbl/Dmtr');
        $worksheet->setCellValue('I6', 'Lbr/Dmtr');
        $worksheet->setCellValue('J6', 'Pjg/Dmtr');
        $worksheet->setCellValue('K6', 'Berat');
        $worksheet->setCellValue('L6', 'Quantity');
        $worksheet->setCellValue('M6', 'Harga Satuan');
        $worksheet->setCellValue('N6', 'Total');
        $worksheet->setCellValue('O6', 'User');

        $counter = 7;

        foreach ($purchaseInvoiceSummary->dataProvider->data as $header) {


            if ($header->receiveHeader->purchaseHeader->is_service == 0) {
                foreach ($header->receiveHeader->purchaseHeader->purchaseDetails as $purchaseDetail) {

                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header,'receiveHeader.purchaseHeader.supplier.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header,'employee.name')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode($header->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header,'note')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'product_name')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'height')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'width')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'length')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'weight')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'quantity')));
                        if ($header->receiveHeader->purchaseHeader->is_tax == 0){
                            $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetail->unit_price));
                            $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetail->total));
                        }else{
                            $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetail->unitPriceTax));
                            $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetail->totalTax));
                        }
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header,'receiveHeader.admin.name')));

                $counter++;
                }

            }else{
                foreach ($header->receiveHeader->purchaseHeader->purchaseDetailServices as $purchaseDetailService) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header,'receiveHeader.purchaseHeader.supplier.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header,'employee.name')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode($header->receiveHeader->getCodeNumber(ReceiveHeader::CN_CONSTANT)));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header,'note')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($purchaseDetailService,'product_name')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($purchaseDetailService,'height_final')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'width_final')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($purchaseDetailService,'length_final')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($purchaseDetailService,'weight')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($purchaseDetail,'quantity')));
                        if ($header->receiveHeader->purchaseHeader->is_tax == 0){
                            $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetailService->amount));
                            $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetailService->totalService));
                        }else{
                            $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetailService->amountTax));
                            $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseDetailService->totalServiceTax));
                        }
                    $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header,'receiveHeader.admin.name')));
                 $counter++;
                }
            }

        }

        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("L{$counter}:N{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("L{$counter}", 'Total Pembelian');
        $worksheet->setCellValue("M{$counter}", 'Rp');
        $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0', ceil($this->reportGrandTotal($purchaseInvoiceSummary->dataProvider))));

        $counter++;

        for ($col = 'A'; $col !== 'L'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Faktur Pembelian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }


}
