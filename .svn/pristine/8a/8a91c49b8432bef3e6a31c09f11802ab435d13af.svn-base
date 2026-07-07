<?php

class ExpenseController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('expenseReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
		set_time_limit(0);
		ini_set('memory_limit', '1024M');
		
        $expenseHeader = Search::bind(new ExpenseHeader('search'), isset($_GET['ExpenseHeader']) ? $_GET['ExpenseHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $number = (isset($_GET['Number'])) ? $_GET['Number'] : '';

        $expenseSummary = new ExpenseSummary($expenseHeader->search());
        $expenseSummary->setupLoading();
        $expenseSummary->setupPaging($pageSize, $currentPage);
        $expenseSummary->setupSorting();
        $expenseSummary->setupFilter($startDate, $endDate);

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($expenseSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'expenseHeader' => $expenseHeader,
            'expenseSummary' => $expenseSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'number' => $number
        ));
    }

    protected function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

    protected function saveToExcel($expenseSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Pengeluaran Kas Bank');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sinar Putra System');
        $worksheet->setTitle('Laporan Pengeluaran Kas Bank');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra System');
        $worksheet->setCellValue('A2', 'Laporan Pengeluaran Kas / Bank');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->mergeCells('A4:I4');

        $worksheet->getStyle("A6:I6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:I6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:I6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Pengeluaran#');
        $worksheet->setCellValue('C6', 'Catatan');
        $worksheet->setCellValue('D6', 'Nama Akun');
        $worksheet->setCellValue('E6', 'Total');
        $worksheet->setCellValue('F6', 'Nama Akun');
        $worksheet->setCellValue('G6', 'Jumah');
        $worksheet->setCellValue('H6', 'Keterangan');
        $worksheet->setCellValue('I6', 'User');

        $counter = 7;

        foreach ($expenseSummary->dataProvider->data as $header) {

            $worksheet->setCellValue("A{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->date)));
            $worksheet->setCellValue("B{$counter}", $header->getCodeNumber(ExpenseHeader::CN_CONSTANT));
            $worksheet->setCellValue("C{$counter}", $header->note);
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'account.name'));
            $worksheet->setCellValue("E{$counter}", Yii::app()->numberFormatter->format('#,##0', $header->grandTotal));

            $counter++;

                foreach ($header->expenseDetails as $detail) {
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($detail, 'account.name')));
                    $worksheet->setCellValue("G{$counter}", Yii::app()->numberFormatter->format('#,##0', $detail->amount));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));


                    $counter++;
                }
        }

        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("E{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("E{$counter}", 'Total');
        $worksheet->setCellValue("F{$counter}", 'Rp');
        $worksheet->setCellValue("G{$counter}", Yii::app()->numberFormatter->format('#,##0', CHtml::encode($this->reportGrandTotal($expenseSummary->dataProvider))));

        $counter++;

        for ($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Pengeluaran Kas Bank.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
