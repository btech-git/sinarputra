<?php

class GeneralLedgerController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('finance'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $accountId = (isset($_GET['AccountId'])) ? $_GET['AccountId'] : '';

        $account = Search::bind(new Account('search'), isset($_GET['Account']) ? $_GET['Account'] : array());
        $accountDataProvider = $account->search();
        $accountDataProvider->criteria->compare('t.is_inactive', 0);
        $accountDataProvider->pagination->pageVar = 'page_dialog';

        $generalLedgerReport = JournalAccounting::getGeneralLedgerReport($startDate, $endDate, $accountId);
        
        $ledgerBeginningBalances = JournalAccounting::getLedgerBeginningBalances($startDate);
        $ledgerBeginningBalanceData = array();
        foreach ($ledgerBeginningBalances as $ledgerBeginningBalance) {
            $ledgerBeginningBalanceData[$ledgerBeginningBalance['account_id']] = $ledgerBeginningBalance['beginning_balance'];
        }
        
        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($generalLedgerReport, $ledgerBeginningBalanceData, $startDate, $endDate);
        }

        $this->render('summary', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'account' => $account,
            'accountId' => $accountId,
            'accountDataProvider' => $accountDataProvider,
            'generalLedgerReport' => $generalLedgerReport,
            'ledgerBeginningBalanceData' => $ledgerBeginningBalanceData,
        ));
    }

    public function actionAjaxJsonCoa() {
        if (Yii::app()->request->isAjaxRequest) {
            $accountId = (isset($_POST['AccountId'])) ? $_POST['AccountId'] : '';
            $account = Account::model()->findByPk($accountId);

            $object = array(
                'coa_name' => CHtml::value($account, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($generalLedgerReport, $ledgerBeginningBalanceData, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
		
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Buku Besar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Buku Besar');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G3')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Buku Besar');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:G6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:G6')->getFont()->setBold(true);

        $worksheet->mergeCells('A5:D5');
        $worksheet->mergeCells('E5:G5');
        $worksheet->setCellValue('A5', 'Akun');
        $worksheet->setCellValue('E5', 'Saldo Awal');
        $worksheet->setCellValue('A6', 'Transaksi #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Memo');
        $worksheet->setCellValue('D6', 'Remarks');
        $worksheet->setCellValue('E6', 'Debit');
        $worksheet->setCellValue('F6', 'Credit');
        $worksheet->setCellValue('G6', 'Saldo');
    
        $counter = 8;

        foreach ($generalLedgerReport as $i => $dataItem) {
            $worksheet->mergeCells("A{$counter}:D{$counter}");
            $worksheet->mergeCells("E{$counter}:G{$counter}");
            
            $beginningBalance = isset($ledgerBeginningBalanceData[$dataItem['account_id']]) ? $ledgerBeginningBalanceData[$dataItem['account_id']] : '0.00';
            $totalDebit = '0.00';
            $totalCredit = '0.00';
            $generalLedgerReportData = JournalAccounting::model()->findAll(array(
                'condition' => 'account_id = :account_id AND date BETWEEN :start_date AND :end_date', 
                'params' => array(
                    ':account_id' => $dataItem['account_id'],
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                ),
            ));
            
            $worksheet->setCellValue("A{$counter}", $dataItem['account_code'] . ' - ' . $dataItem['account_name']);
            $worksheet->setCellValue("E{$counter}", $beginningBalance);
            $counter++;
            
            if (!empty($generalLedgerReportData)) {
                $currentBalance = $beginningBalance;
                foreach ($generalLedgerReportData as $generalLedgerRow) {
                    $debitAmount = $generalLedgerRow['debit'];
                    $creditAmount = $generalLedgerRow['credit']; 
                    $currentBalance += $debitAmount - $creditAmount;
                    $worksheet->setCellValue("A{$counter}", $generalLedgerRow['transaction_number']);
                    $worksheet->setCellValue("B{$counter}", $generalLedgerRow['date']);
                    $worksheet->setCellValue("C{$counter}", $generalLedgerRow['transaction_subject']);
                    $worksheet->setCellValue("D{$counter}", $generalLedgerRow['note']);
                    $worksheet->setCellValue("E{$counter}", $debitAmount);
                    $worksheet->setCellValue("F{$counter}", $creditAmount);
                    $worksheet->setCellValue("G{$counter}", $currentBalance);

                    $totalDebit += $debitAmount;
                    $totalCredit += $creditAmount;
                    
                    $counter++;
                }
            }
            $worksheet->mergeCells("A{$counter}:D{$counter}");
            $worksheet->getStyle("D{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            
            $worksheet->setCellValue("D{$counter}", 'TOTAL');
            $worksheet->setCellValue("E{$counter}", $totalDebit);
            $worksheet->setCellValue("F{$counter}", $totalCredit);
            
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="laporan_buku_besar.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
