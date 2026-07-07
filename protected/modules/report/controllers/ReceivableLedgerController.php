<?php

class ReceivableLedgerController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('receivableJournalReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $customerCompany = (isset($_GET['CustomerCompany'])) ? $_GET['CustomerCompany'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 5000;
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        if (isset($_GET['ResetFilter'])) {
            $customerId = '';
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
            $pageSize = 50000;
            $currentPage = '';
            $currentSort = '';

        }
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->compare('t.is_inactive', 0);
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $receivableLedgerSummary = new ReceivableLedgerSummary($customer->search());
        $receivableLedgerSummary->setupLoading();
        $receivableLedgerSummary->setupPaging($pageSize, $currentPage);
        $receivableLedgerSummary->setupSorting();
        $receivableLedgerSummary->setupFilter($startDate, $endDate, $customerCompany);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcel($receivableLedgerSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
            ));
        }
        
        $this->render('summary', array(
            'customer' => $customer,
            'customerCompany' => $customerCompany,
            'customerDataProvider' => $customerDataProvider,
            'receivableLedgerSummary' => $receivableLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }


    protected function saveToExcel($receivableLedgerSummary, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT Sinar Putra Metalindo');
        $documentProperties->setTitle('Buku Besar Piutang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Buku Besar Piutang');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'PT Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Buku Besar Piutang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Transaksi #');
        $worksheet->setCellValue('C5', 'Keterangan');
        $worksheet->setCellValue('D5', 'Memo');
        $worksheet->setCellValue('E5', 'Debit');
        $worksheet->setCellValue('F5', 'Kredit');
        $worksheet->setCellValue('G5', 'Saldo');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        foreach ($receivableLedgerSummary->data as $header) {
            $worksheet->mergeCells("A{$counter}:F{$counter}");
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'code')) . ' - ' . CHtml::encode(CHtml::value($header, 'name')) . ' - ' . CHtml::encode(CHtml::value($header, 'company')));
            $saldo = $header->getBeginningBalanceReceivable($startDate);
            $worksheet->setCellValue("G{$counter}", CHtml::encode($saldo));

            $counter++;

            $receivableData = $header->getReceivableLedgerReport($startDate, $endDate);
            $totalDebit = '0.00'; 
            $totalCredit = '0.00';

            foreach ($receivableData as $receivableRow) {
                $debit = $receivableRow['debit'];
                $credit = $receivableRow['credit']; 
                $saldo += $debit - $credit;

                $worksheet->setCellValue("A{$counter}", CHtml::encode($receivableRow['transaction_date']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($receivableRow['transaction_number']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($receivableRow['note']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($receivableRow['memo']));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($debit));
                $worksheet->setCellValue("F{$counter}", CHtml::encode($credit));
                $worksheet->setCellValue("G{$counter}", CHtml::encode($saldo));

                $totalDebit += $debit;
                $totalCredit += $credit;

                $counter++;
            }

            $worksheet->mergeCells("A{$counter}:D{$counter}");
            $worksheet->setCellValue("A{$counter}", "Total");
            $worksheet->setCellValue("E{$counter}", CHtml::encode($totalDebit));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($totalCredit));
            $counter++;$counter++;
        }
            
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="buku_besar_piutang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}