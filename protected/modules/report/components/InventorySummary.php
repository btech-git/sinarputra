<?php

class InventorySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//		$this->dataProvider->criteria->select = 't.*, 
//			(SUM(CASE WHEN saleDetails.is_inactive = 0 THEN purchaseDetails.quantity ELSE 0	END) 
//			- SUM(CASE WHEN receiveDetails.is_inactive = 0 THEN receiveDetails.quantity ELSE 0 END))
//			AS remaining_quantity';	//sum quantity if is_inactive = 0
//		$this->dataProvider->criteria->join = '
//			LEFT JOIN '. saleDetail::model()->tableName(). ' purchaseDetails ON purchaseDetails.purchase_header_id = t.id
//			LEFT JOIN '. ReceiveDetail::model()->tableName(). ' receiveDetails ON receiveDetails.purchase_detail_id = purchaseDetails.id
//			LEFT JOIN '. Supplier::model()->tableName(). ' supplier ON supplier.id = t.supplier_id
//		';
        $this->dataProvider->criteria->join = 'LEFT JOIN ' . Customer::model()->tableName() . ' customer ON customer.id = t.customer_id';
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.date', 'customer.company');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.customer_id', $filters['customerId']);
    }

    public function reportGrandTotal() {
        $grandTotal = 0.00;

        foreach ($this->dataProvider->data as $data)
            $grandTotal += $data->grandTotalTransaction;

        return $grandTotal;
    }

}
