<?php

class SaleInvoiceSamplePerYearSummary extends CComponent
{
	public $dataProvider;
	
	public function __construct($dataProvider)
	{
		$this->dataProvider = $dataProvider;
	}
	
	public function setupLoading()
	{
		$this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'saleHeaders' => array(
                'with' => array(
                    'workOrderCuttingHeaders' => array(
                        'with' => array(
                            'deliveryHeaders' => array(
                                'with' => array(
                                    'saleInvoices'
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        );
        
//		$this->dataProvider->criteria->select = 't.*';
//		$this->dataProvider->criteria->join = '
//			JOIN '. SaleHeader::model()->tableName(). ' saleHeaders ON saleHeaders.customer_id = t.id
//            JOIN '. WorkOrderCuttingHeader::model()->tableName(). ' workOrderCuttingHeaders ON workOrderCuttingHeaders.sale_header_id = saleHeaders.id    
//            JOIN ' . DeliveryHeader::model()->tableName() . ' deliveryHeaders ON deliveryHeaders.work_order_cutting_header_id = workOrderCuttingHeaders.id 
//            JOIN ' . SaleInvoice::model()->tableName() . ' saleInvoices ON saleInvoices.delivery_header_id = deliveryHeaders.id  
//        ';
//                
//                
//		$this->dataProvider->criteria->group = 't.id';
	}
	
	public function setupPaging($pageSize, $currentPage)
	{
		$pageSize = (empty($pageSize)) ? 10 : $pageSize;
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
		$this->dataProvider->criteria->compare('YEAR(saleInvoices.date)', $filters['yearChoose']);
		$this->dataProvider->criteria->compare('t.company', $filters['customerName'],TRUE);
                $this->dataProvider->criteria->compare('deliveryHeaders.is_sample', 1);
	
	}
}
