<?php

class StockCheckWorkOrderSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
       
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 30 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {

        $this->dataProvider->sort->defaultOrder = 't.product_category_id ASC';
    }

    public function setupFilter($productCategoryId) {

        $this->dataProvider->criteria->compare('t.product_category_id', $productCategoryId);
        //$this->dataProvider->criteria->compare('t.product_name', $productName);
        //$this->dataProvider->criteria->compare('t.size', $filters['size'], TRUE);
        //$this->dataProvider->criteria->compare('t.brand_id', $filters['brandId']);
        
    }

}
