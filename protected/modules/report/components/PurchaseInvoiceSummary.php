<?php

class PurchaseInvoiceSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'receiveHeader',
            'receiveItemHeader',
            'supplier:resetScope',
        );
//        $this->dataProvider->criteria->select = 't.*';
//        $this->dataProvider->criteria->join = '
//			LEFT JOIN ' . ReceiveHeader::model()->tableName() . ' receiveHeader ON receiveHeader.id = t.receive_header_id
//			LEFT JOIN ' . PurchaseHeader::model()->tableName() . ' purchaseHeader ON purchaseHeader.id = receiveHeader.purchase_header_id
//                        LEFT JOIN ' . Supplier::model()->tableName() . ' supplier ON supplier.id = purchaseHeader.supplier_id
//		';
//        $this->dataProvider->criteria->condition = 't.receive_header_id IS NOT NULL';
//        $this->dataProvider->criteria->group = 't.id';
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.date', 'supplier.company');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('supplier.company', $filters['supplierName'], TRUE);
    }

    public function reportGrandTotal() {
        $grandTotal = 0.00;

        foreach ($this->dataProvider->data as $data)
            $grandTotal += $data->grandTotal;

        return $grandTotal;
    }

}
