<?php

class PurchaseController extends Controller {

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

        $purchaseSummary = new PurchaseSummary($purchaseHeader->search());
        $purchaseSummary->setupLoading();
        $purchaseSummary->setupPaging($pageSize, $currentPage);
        $purchaseSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
            'status' => $status
        );
        $purchaseSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchaseHeader' => $purchaseHeader,
            'purchaseSummary' => $purchaseSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
            'status' => $status
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

    protected function saveToExcel($purchaseSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Order Pembelian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Order Pembelian');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');
        $worksheet->getStyle('A1:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Sistem');
        $worksheet->setCellValue('A2', 'Laporan Order Pembelian');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:R4');
        $worksheet->mergeCells('A5:R5');

        $worksheet->getStyle("A6:R6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:R6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:R6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Pembelian#');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('D6', 'Catatan');
        $worksheet->setCellValue('E6', 'Nama Barang');
        $worksheet->setCellValue('F6', 'Panjang');
        $worksheet->setCellValue('G6', 'Lebar');
        $worksheet->setCellValue('H6', 'Tinggi');
        $worksheet->setCellValue('I6', 'Quantity');
        $worksheet->setCellValue('J6', 'Satuan');
        $worksheet->setCellValue('K6', 'Harga Satuan');
        $worksheet->setCellValue('L6', 'Total');
        $worksheet->setCellValue('M6', 'Sub Total');
        $worksheet->setCellValue('N6', 'Disc');
        $worksheet->setCellValue('O6', 'Total Before Tax');
        $worksheet->setCellValue('P6', 'PPN 10%');
        $worksheet->setCellValue('Q6', 'Grand Total');
        $worksheet->setCellValue('R6', 'User');

        $counter = 7;

        foreach ($purchaseSummary->dataProvider->data as $header) {

            if ($header->is_service == 1) {
                foreach ($header->purchaseDetailServices as $service) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header,'supplier.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header,'note')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($service,'name')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($service,'length_final')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($service,'width_final')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($service,'height_final')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($service,'quantity')));
                    //				$worksheet->setCellValue("F{$counter}", Yii::app()->numberFormatter->format('#,##0', ($detail->receiveDetails == null) ? "0" : $detail->receiveDetails[0]->quantity));
                    //				$worksheet->setCellValue("G{$counter}", $detail->product->unit->name);

                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($service,'purchaseHeader.currency.code')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($service,'amount')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($service,'total')));
                    $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->serviceSubTotal));
                    $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->discount));
                    $worksheet->setCellValue("O{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->serviceTax));
                    $worksheet->setCellValue("P{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->calculatedTax));
                    $worksheet->setCellValue("Q{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->grandTotal));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));

                    $counter++;
                }
            } else {
                foreach ($header->purchaseDetails as $detail) {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date))));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode($header->getCodeNumber($header::CN_CONSTANT)));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header,'supplier.company')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header,'note')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail,'product_name')). ' '. CHtml::value($detail,'productCategory.name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail,'length')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail,'width')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail,'height')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail,'quantity')));
                   
                    //              $worksheet->setCellValue("F{$counter}", Yii::app()->numberFormatter->format('#,##0', ($detail->receiveDetails == null) ? "0" : $detail->receiveDetails[0]->quantity));
                    //              $worksheet->setCellValue("G{$counter}", $detail->product->unit->name);

                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail,'purchaseHeader.currency.code')));
                    $worksheet->setCellValue("K{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $detail->unit_price));
                    $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $detail->total));
                    $worksheet->setCellValue("M{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->subTotal));
                    $worksheet->setCellValue("N{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->discount));
                    $worksheet->setCellValue("O{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->totalBeforeTax));
                    $worksheet->setCellValue("P{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->calculatedTax));
                    $worksheet->setCellValue("Q{$counter}", Yii::app()->numberFormatter->format('#,##0.00', $header->grandTotal));
                    $worksheet->setCellValue("R{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));
                    $counter++;
                }
            }


            /*$worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("K{$counter}", 'Sub Total '. $header->currency->code);
            //$worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header,'currency.code')));

            if ($header->is_service == 1) {
                $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->serviceSubTotal));
            } else {
                $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->subTotal));
            }

            $counter++;


            if ($header->is_service == 1) {
                $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("K{$counter}", 'Service Tax');
                $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->serviceTax));

                $counter++;
            }


            if ($header->is_service == 1) {
                $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("K{$counter}", 'Total Service');
                $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->totalService));

                $counter++;
            }


            $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("K{$counter}", 'Disc ' . $header->discount . '%'. $header->currency->code);
            $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->discount));

            $counter++;

            $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("K{$counter}", 'Total Before Tax '. $header->currency->code);
            $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->totalBeforeTax));
            $counter++;


            $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("K{$counter}", 'PPN ' . '% '. $header->currency->code);
            $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->calculatedTax));

            $counter++;

            $worksheet->getStyle("J{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("K{$counter}", 'Grand Total '. $header->currency->code);
            $worksheet->setCellValue("L{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->grandTotal));
            $counter++;*/
        }
        $worksheet->getStyle(   "A{$counter}:R{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:R{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("P{$counter}:Q{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("P{$counter}", 'Total Pembelian ');
        $worksheet->setCellValue("Q{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::encode($this->reportGrandTotal($purchaseSummary->dataProvider))));


        $counter++;

        for ($col = 'A'; $col !== 'L'; $col++) {
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
