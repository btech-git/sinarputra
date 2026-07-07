<?php

class DeliveryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('deliveryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $deliveryHeader = Search::bind(new DeliveryHeader('search'), isset($_GET['DeliveryHeader']) ? $_GET['DeliveryHeader'] : array());
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $deliverySummary = new DeliverySummary($deliveryHeader->search());
        $deliverySummary->setupLoading();
        $deliverySummary->setupPaging($pageSize, $currentPage);
        $deliverySummary->setupSorting();
        $deliverySummary->setupFilter($startDate, $endDate, $customerId);
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($deliverySummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'deliveryHeader' => $deliveryHeader,
            'deliverySummary' => $deliverySummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'customerId' => $customerId,
        ));
    }

    protected function saveToExcel($deliverySummary, $startDate, $endDate) {
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
        $documentProperties->setCreator('Sinar Putra System');
        $documentProperties->setTitle('Laporan Pengiriman Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sinar Putra System');
        $worksheet->setTitle('Laporan Pengiriman Barang');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        $worksheet->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Penawaran');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:O4');

        $worksheet->getStyle("A6:O6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:O6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:O6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Pengiriman#');
        $worksheet->setCellValue('C6', 'Customer');
        $worksheet->setCellValue('D6', 'Warehouse');
        $worksheet->setCellValue('E6', 'SPK#');
        $worksheet->setCellValue('F6', 'Catatan');
        $worksheet->setCellValue('G6', 'Job Order');
        $worksheet->setCellValue('H6', 'GRADE');
        $worksheet->setCellValue('I6', 'Kategori');
        $worksheet->setCellValue('J6', 'Tbl/Dmtr');
        $worksheet->setCellValue('K6', 'Lbr/Dmtr');
        $worksheet->setCellValue('L6', 'Panjang');
        $worksheet->setCellValue('M6', 'Berat');
        $worksheet->setCellValue('N6', 'Quantity');
        $worksheet->setCellValue('O6', 'User');
    

        $counter = 7;

        foreach ($deliverySummary->dataProvider->data as $header) {

                foreach ($header->deliveryDetails as $detail) {
                    if($detail->work_order_cutting_detail_id == NULL){
                        $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                        $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                        $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company'));
                        $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'warehouse.name'));
                        $worksheet->setCellValue("E{$counter}", $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                        $worksheet->setCellValue("F{$counter}", $header->note);
                        $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.job_number')));
                        $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.product_name_quote')));
                        $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailProduct.productCategory.name')));
                        $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));

                    }else{
                        $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
                        $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
                        $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'workOrderCuttingHeader.saleHeader.customer.company'));
                        $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'warehouse.name'));
                        $worksheet->setCellValue("E{$counter}", $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
                        $worksheet->setCellValue("F{$counter}", $header->note);
                        $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailService.job_number')));
                        $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailService.product_name')));
                        $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($detail, 'workOrderCuttingDetail.saleDetail.quotationDetailService.productCategory.name')));
                        $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header,'admin.name')));

                    }
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($detail, 'height')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'width')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'length')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'weight')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'quantity')));
                        
                    $counter++;
                }
            }

        $counter++;

        for ($col = 'A'; $col !== 'N'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Pengiriman Barang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
