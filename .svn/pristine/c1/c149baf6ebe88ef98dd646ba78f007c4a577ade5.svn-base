<?php

class SaleOmzetSalesByGradeController extends Controller {

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
  
        $saleOmzetSalesmanSummary = new SaleOmzetSalesmanSummary($employee->search());
        
        $saleOmzetSalesmanSummary->setupLoading();
        $saleOmzetSalesmanSummary->setupPaging($pageSize, $currentPage);
        $saleOmzetSalesmanSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'employeeName' => $employeeName,
        );
        $saleOmzetSalesmanSummary->setupFilter($filters);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleOmzetSalesmanSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'employee' => $employee,
            'saleOmzetSalesmanSummary' => $saleOmzetSalesmanSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'employeeName' => $employeeName,
        ));
    }

    protected function saveToExcel($saleOmzetSalesmanSummary, $startDate, $endDate) {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Omzet Sales By Grade');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Omzet Sales By Grade');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Omzet Per Sales By Grade Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:E4');

        $worksheet->getStyle("A6:E6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:E6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:E6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'SE Name');
        $worksheet->setCellValue('C6', 'SE Code');
        $worksheet->setCellValue('D6', 'Nama Barang');
        $worksheet->setCellValue('E6', 'Berat');
        $worksheet->setCellValue('F6', 'Total');
        
        $counter = 7;

        $number = 1;

        foreach ($saleOmzetSalesmanSummary->dataProvider->data as $header) {
            foreach ($header->saleHeaders as $sale) {
                foreach ($sale->saleDetails as $detail) {
                    if ($detail->quotation_detail_product_id == NULL) {
                        $worksheet->setCellValue("A{$counter}", $number);
                        $number++;
                        $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'code')));
                        $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailService.product_name')));
                        $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailService.weight')));
                        $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailService.total')));

                        $counter++;

                    }else{
                        $worksheet->setCellValue("A{$counter}", $number);
                        $number++;
                        $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                        $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'code')));
                        $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')));
                        $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailService.weight')));
                        $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailService.total')));

                        $counter++;
                    }
                }
            }
        }

        $counter++;

        for ($col = 'A'; $col !== 'F'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Omzet Per Sales By Grade Detail.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }


}

