<?php

class SaleBySalesmanController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $employee = Search::bind(new Employee('search'), isset($_GET['Employee']) ? $_GET['Employee'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $employeeName = (isset($_GET['EmployeeName'])) ? $_GET['EmployeeName'] : '';
  
        $saleBySalesmanSummary = new SaleBySalesmanSummary($employee->search());
        
        $saleBySalesmanSummary->setupLoading();
        $saleBySalesmanSummary->setupPaging($pageSize, $currentPage);
        $saleBySalesmanSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'employeeName' => $employeeName,
        );
        $saleBySalesmanSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleBySalesmanSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'employee' => $employee,
            'saleBySalesmanSummary' => $saleBySalesmanSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'employeeName' => $employeeName,
        ));
    }

    protected function saveToExcel($saleBySalesmanSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinarputra');
        $documentProperties->setTitle('Laporan Penjualan By Salesman');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penjualan By Customer');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan C3 By Salesman');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:G4');

        $worksheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:G6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:G6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Salesman');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Penjualan');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Quantity');
        $worksheet->setCellValue('F6', 'Total');
        $worksheet->setCellValue('G6', 'User');
        
        $counter = 7;

        $grandTotalQuantity = 0;
        $grandTotal = 0;

        foreach ($saleBySalesmanSummary->dataProvider->data as $header) {

            $subTotal = 0;
            $subTotalQuantity = 0;

                foreach ($header->saleHeaders as $saleHeader) {
                    if ($saleHeader->date >= $startDate && $saleHeader->date <= $endDate) {
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                        $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($saleHeader->date))));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode($saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT)));
                        $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($saleHeader, 'customer.company')));
                        $worksheet->setCellValue("E{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('###00', CHtml::value($saleHeader, 'totalQuantity'))));
                        $worksheet->setCellValue("F{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('###00', CHtml::value($saleHeader, 'grandTotalTransaction'))));
                         $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($saleHeader,'admin.name')));

                        $subTotalQuantity += $saleHeader->totalQuantity;
                        $subTotal += $saleHeader->grandTotalTransaction;

                        $counter ++;

                    }
                }

                $grandTotalQuantity += $subTotalQuantity;
                $grandTotal += $subTotal;

                //$worksheet->getStyle("E{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$worksheet->getStyle("E{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                //$worksheet->setCellValue("D{$counter}", 'Total');
                //$worksheet->setCellValue("E{$counter}", Yii::app()->numberFormatter->format('###0',$subTotalQuantity));
                //$worksheet->setCellValue("F{$counter}", Yii::app()->numberFormatter->format('###0',$subTotal));


                //$counter++;

        }

        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("D{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("D{$counter}", 'Grand Total');
        $worksheet->setCellValue("E{$counter}", Yii::app()->numberFormatter->format('#,##0',$grandTotalQuantity));
        $worksheet->setCellValue("F{$counter}", Yii::app()->numberFormatter->format('#,##0',$grandTotal));


        $counter++;

        for ($col = 'A'; $col !== 'F'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan C3 By Salesman.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }


}

