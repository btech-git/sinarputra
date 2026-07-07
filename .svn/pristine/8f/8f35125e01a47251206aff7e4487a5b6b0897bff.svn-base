<?php

class StatusReviewController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('statusReviewCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $saleHeader = Search::bind(new SaleHeader(), isset($_GET['SaleHeader']) ? $_GET['SaleHeader'] : '');
        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        
        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $saleHeaderDataProvider = $saleHeader->resetScope()->searchWithPaging();
        $saleHeaderDataProvider->criteria->with = array(
            'customer:resetScope',
        );

        $saleHeaderDataProvider->criteria->addCondition("customer.company LIKE :company");
        $saleHeaderDataProvider->criteria->params[':company'] = "%{$customerCompany}%";

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $saleHeaderDataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $saleHeaderDataProvider->criteria->order = 't.date ASC';

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($saleHeaderDataProvider, $startDate, $endDate);
        }

        $this->render('summary', array(
            'saleHeader' => $saleHeader,
            'saleHeaderDataProvider' => $saleHeaderDataProvider,
            'customerCompany' => $customerCompany,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    protected function saveToExcel($saleHeaderDataProvider, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Sinar Putra Metalindo');
        $documentProperties->setTitle('Produksi Status Review');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Produksi Status Review');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:AD3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AD3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Produksi Status Review');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:AD5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:AD6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:AD5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Tanggal Order');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', 'PO #');
        $worksheet->setCellValue('D5', 'Value');
        $worksheet->setCellValue('E5', 'SO #');
        $worksheet->setCellValue('F5', 'Tanggal Est Kirim');
        $worksheet->setCellValue('G5', 'Salesman');
        $worksheet->setCellValue('H5', 'SPK #');
        $worksheet->setCellValue('I5', 'Qty SPK');
        $worksheet->setCellValue('J5', 'QC Cutting #');
        $worksheet->setCellValue('K5', 'QC Cutting Tanggal');
        $worksheet->setCellValue('L5', 'Qty QC Cutting');
        $worksheet->setCellValue('M5', 'SJ Cutting #');
        $worksheet->setCellValue('N5', 'SJ Cutting Tanggal');
        $worksheet->setCellValue('O5', 'Qty SJ Cutting');
        $worksheet->setCellValue('P5', 'QC Miling #');
        $worksheet->setCellValue('Q5', 'QC Miling Tanggal');
        $worksheet->setCellValue('R5', 'Qty QC Miling');
        $worksheet->setCellValue('S5', 'SJ Miling #');
        $worksheet->setCellValue('T5', 'SJ Miling Tanggal');
        $worksheet->setCellValue('U5', 'Qty SJ Miling');

        $counter = 7;

        foreach ($saleHeaderDataProvider->data as $header) {
            $workOrderCuttingHeader = WorkOrderCuttingHeader::model()->findByAttributes(array('sale_header_id' => $header->id));
            
//            if (empty($workOrderCuttingHeader->saleInvoiceHeaders[0]) && empty($workOrderCuttingHeader->manualSaleInvoiceHeaders[0])) {
//                $worksheet->getStyle("A{$counter}:Z{$counter}")->applyFromArray(array(
//                    'fill' => array(
//                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
//                        'color' => array('rgb' => 'FF0000')
//                    )
//                ));
//            }
                
            $worksheet->setCellValue("A{$counter}", $header->date);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'customer.company'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer_order_number'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'grandTotalTransaction'));
            $worksheet->setCellValue("E{$counter}", $header->getCodeNumber(SaleHeader::CN_CONSTANT));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'estimate_delivery_date'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'employeeIdSalesman.name'));
            if (!empty($workOrderCuttingHeader)) {
                $worksheet->setCellValue("H{$counter}", $workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                $worksheet->setCellValue("I{$counter}", $workOrderCuttingHeader->getTotalQuantityDetail());
                
                if (!empty($workOrderCuttingHeader->qualityControlCuttingHeaders)) {
                    foreach ($workOrderCuttingHeader->qualityControlCuttingHeaders as $qualityControl) {
                        $worksheet->setCellValue("J{$counter}", $qualityControl->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT));
                        $worksheet->setCellValue("K{$counter}", CHtml::value($qualityControl, 'date'));
                        $worksheet->setCellValue("L{$counter}", CHtml::value($qualityControl, 'totalQuantity'));

                        if (!empty($qualityControl->deliveryHeaders)) {
                            foreach ($qualityControl->deliveryHeaders as $deliveryHeader) {
                                $worksheet->setCellValue("M{$counter}", $deliveryHeader->getCodeNumber(DeliveryHeader::CN_CONSTANT));
                                $worksheet->setCellValue("N{$counter}", CHtml::value($deliveryHeader, 'date'));
                                $worksheet->setCellValue("O{$counter}", CHtml::value($deliveryHeader, 'totalQuantity'));
                            }
                        }
                        $counter++;

                    }
                }
                
                if (!empty($workOrderCuttingHeader->qualityControlMilingHeaders)) {
                    foreach ($workOrderCuttingHeader->qualityControlMilingHeaders as $qualityControl) {
                        $worksheet->setCellValue("J{$counter}", $qualityControl->getCodeNumber(QualityControlMilingHeader::CN_CONSTANT));
                        $worksheet->setCellValue("K{$counter}", CHtml::value($qualityControl, 'date'));
                        $worksheet->setCellValue("L{$counter}", CHtml::value($qualityControl, 'totalQuantity'));

                        if (!empty($qualityControl->deliveryHeaders)) {
                            foreach ($qualityControl->deliveryHeaders as $deliveryHeader) {
                                $worksheet->setCellValue("M{$counter}", $deliveryHeader->getCodeNumber(DeliveryHeader::CN_CONSTANT));
                                $worksheet->setCellValue("N{$counter}", CHtml::value($deliveryHeader, 'date'));
                                $worksheet->setCellValue("O{$counter}", CHtml::value($deliveryHeader, 'totalQuantity'));
                            }
                        }
                        $counter++;

                    }
                }
            }
            $counter++;
            
        }

        for ($col = 'A'; $col !== 'AE'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="produksi_status_review.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}