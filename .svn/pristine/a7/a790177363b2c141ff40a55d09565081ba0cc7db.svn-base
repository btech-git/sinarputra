<?php

class PurchaseBySupplierController extends Controller {

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
		
        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';

        $purchaseBySupplierSummary = new PurchaseBySupplierSummary($supplier->search());
        $purchaseBySupplierSummary->setupLoading();
        $purchaseBySupplierSummary->setupPaging($pageSize, $currentPage);
        $purchaseBySupplierSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
        );
        $purchaseBySupplierSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseBySupplierSummary, $startDate, $endDate);
        }


        $this->render('summary', array(
            'supplier' => $supplier,
            'purchaseBySupplierSummary' => $purchaseBySupplierSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
        ));
    }

     protected function saveToExcel($purchaseBySupplierSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Pembelian By Supplier');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian By Supplier');

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');
        $worksheet->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:T3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Sistem');
        $worksheet->setCellValue('A2', 'Laporan Pembelian By Supplier');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:T4');
        $worksheet->mergeCells('A5:T5');

        $worksheet->getStyle("A6:T6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:T6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:T6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'NO');
        $worksheet->setCellValue('B6', 'Supplier');
        $worksheet->setCellValue('C6', 'Tanggal');
        $worksheet->setCellValue('D6', 'Pembelian #');
        $worksheet->setCellValue('E6', 'Sub Total');
        $worksheet->setCellValue('F6', 'Tgl PO');
        $worksheet->setCellValue('G6', 'No PO Supplier');
        $worksheet->setCellValue('H6', 'Category / Jenis');
        $worksheet->setCellValue('I6', 'Nama Barang');
        $worksheet->setCellValue('J6', 'Ukuran');
        $worksheet->setCellValue('K6', 'Qty');
        $worksheet->setCellValue('L6', 'Kg');
        $worksheet->setCellValue('M6', 'Harga');
        $worksheet->setCellValue('N6', 'Jumlah');
        $worksheet->setCellValue('O6', 'Diskon');
        $worksheet->setCellValue('P6', 'DPP');
        $worksheet->setCellValue('Q6', 'PPN');
        $worksheet->setCellValue('R6', 'Total');
        $worksheet->setCellValue('S6', 'Keterangan');
        $worksheet->setCellValue('T6', 'User');
       

        $counter = 7;

        $number = 1;


        $grand = 0;

        foreach ($purchaseBySupplierSummary->dataProvider->data as $header) {        

            $grandTotal = 0;

                foreach ($header->purchaseHeaders as $purchaseHeader){
                        $worksheet->setCellValue("A{$counter}", $number);
                        $number++;
                        $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header,'company')));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseHeader->date))));
                        $worksheet->setCellValue("D{$counter}", CHtml::encode($purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)));
                        $worksheet->setCellValue("E{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseHeader->subTotal));
                        $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($purchaseHeader->date))));
                        $worksheet->setCellValue("G{$counter}", CHtml::encode($purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT)));

                        foreach ($purchaseHeader->purchaseDetails as $detail){
                        $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail,'productCategory.name')));
                        $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail,'product_name')));
                        $worksheet->setCellValue("J{$counter}", Yii::app()->numberFormatter->format('#,##0', $detail->length));
                        $worksheet->setCellValue("K{$counter}", Yii::app()->numberFormatter->format('#,##0', $detail->quantity));
                        $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $detail->weight));
                        $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0', $detail->unit_price));
                        }
                        $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseHeader->totalBeforeTax));
                        $worksheet->setCellValue("O{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseHeader->discount));
                        $worksheet->setCellValue("P{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseHeader->downpayment));
                        $worksheet->setCellValue("Q{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseHeader->calculatedTax));
                        $worksheet->setCellValue("R{$counter}", Yii::app()->numberFormatter->format('#,##0', $purchaseHeader->grandTotal));
                        $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($purchaseHeader,'note')));
                        $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($purchaseHeader,'admin.name')));


                        $counter++;
                        
        
                        $grandTotal += $purchaseHeader->grandTotal;
                    
                }

                //$worksheet->getStyle("D{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$worksheet->getStyle("C{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                //$worksheet->setCellValue("C{$counter}", 'Total');
                //$worksheet->setCellValue("D{$counter}", Yii::app()->numberFormatter->format('#,##0', $subTotalQuantity));
                //$worksheet->setCellValue("E{$counter}", Yii::app()->numberFormatter->format('#,##0', $subTotal));

                $grand += $grandTotal;

        }


        $worksheet->getStyle("A{$counter}:T{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:T{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("Q{$counter}:R{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("Q{$counter}", 'Grand Total');
        //$worksheet->setCellValue("D{$counter}", Yii::app()->numberFormatter->format('#,##0',$grandTotalQuantity));
        $worksheet->setCellValue("R{$counter}", Yii::app()->numberFormatter->format('#,##0',$grand));


        $counter++;

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Pembelian By Supplier.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }


}

