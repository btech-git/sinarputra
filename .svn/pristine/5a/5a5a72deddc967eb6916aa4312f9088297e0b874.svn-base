<?php

class SaleOmzetCustomerDetailController extends Controller {

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
		
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $saleOmzetCustomerSummary = new SaleOmzetCustomerSummary($customer->search());
        $saleOmzetCustomerSummary->setupLoading();
        $saleOmzetCustomerSummary->setupPaging($pageSize, $currentPage);
        $saleOmzetCustomerSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
        );
        $saleOmzetCustomerSummary->setupFilter($filters);
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleOmzetCustomerSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'customer' => $customer,
            'saleOmzetCustomerSummary' => $saleOmzetCustomerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerName' => $customerName,
        ));
    }

    protected function saveToExcel($saleOmzetCustomerSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Penjualan By Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penjualan By Customer');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        //$worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Omzet Per Customer Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->mergeCells('A4:L4');

        $worksheet->getStyle("A6:L6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:L6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:L6')->getFont()->setBold(true);

        $worksheet->setCellValue('A6', 'Customer');
        $worksheet->setCellValue('B6', 'Customer Code');
        $worksheet->setCellValue('C6', 'Area');
        $worksheet->setCellValue('D6', 'SE');
        $worksheet->setCellValue('E6', 'No SPK');
        $worksheet->setCellValue('F6', 'Steel Application');
        $worksheet->setCellValue('G6', 'Steel Grade');
        $worksheet->setCellValue('H6', 'Ukuran');
        $worksheet->setCellValue('I6', 'Quantity');
        $worksheet->setCellValue('J6', 'Berat');
        $worksheet->setCellValue('K6', 'Harga');
        $worksheet->setCellValue('L6', 'Jumlah');
        
        $counter = 7;

        foreach ($saleOmzetCustomerSummary->dataProvider->data as $header) {
            foreach ($header->saleInvoiceHeaders as $sale) {
                foreach ($sale->saleInvoiceDetails as $detail) {
                        $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'company')));
                        $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'code')));
                        $worksheet->setCellValue("C{$counter}");
                        $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($sale, 'employeeIdSalesman.name')));
                        $worksheet->setCellValue("E{$counter}", CHtml::encode($sale->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)));
                        $worksheet->setCellValue("F{$counter}");
                        $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'grade_name')));
                        $worksheet->setCellValue("H{$counter}", 
                            CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetail.height_request'))) . " X " .
                            CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetail.width_request'))) . " X " . 
                            CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'workOrderCuttingDetail.length_request')))
                        );  
                        $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))));  
                        $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'weight'))));  
                        $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'unit_price')));  
                        $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'total')));  

                        $counter ++;
//                        } else {
//                            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'company')));
//                            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'code')));
//                            $worksheet->setCellValue("C{$counter}");
//                            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($sale, 'employeeIdSalesman.name')));
//                            $worksheet->setCellValue("E{$counter}");
//                            $worksheet->setCellValue("F{$counter}");
//                            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.product_name_request')));
//                            $worksheet->setCellValue("H{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.length_request'))));  
//                            $worksheet->setCellValue("I{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.quantity_request'))));  
//                            $worksheet->setCellValue("J{$counter}", CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quotationDetailProduct.weight'))));  
//                            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.unit_price')));  
//                            $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'quotationDetailProduct.total')));  
//
//                            $counter ++;
//                        }
                    }
                }
        }


        $counter++;

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Omzet Per Customer Detail.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}

