<?php

class ReceivableMonthlySummary extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
		$this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array('saleInvoiceHeaders');
	}
	
	public function setupPaging($pageSize, $currentPage)
	{
		$pageSize = (empty($pageSize)) ? 30 : $pageSize;
		$pageSize = ($pageSize <= 0) ? 1 : $pageSize;
		$this->dataProvider->pagination->pageSize = $pageSize;
		
		$currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
		$this->dataProvider->pagination->currentPage = $currentPage;
	}
	
	public function setupSorting()
	{
		$this->dataProvider->sort->attributes = array('t.company');
		$this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
		
	}
	
	public function setupFilter($filters)
	{
		$startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
		$endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
		$this->dataProvider->criteria->addBetweenCondition('saleInvoiceHeaders.date', $startDate, $endDate);
        $this->dataProvider->criteria->addCondition('saleInvoiceHeaders.grand_total - saleInvoiceHeaders.total_payment - saleInvoiceHeaders.total_return > 0');
	}
}
