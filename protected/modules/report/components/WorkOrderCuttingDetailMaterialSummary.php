<?php

class WorkOrderCuttingDetailMaterialSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'workOrderCuttingDetail' => array(
                'with' => array(
                    'workOrderCuttingHeader' => array(
                        'with' => array(
                           'saleHeader' => array(
                              'with' => array(
                                    'customer:resetScope',
                                ),
                            ),
                        ),
                    ),
                ),    
            ),
            'receiveDetail'
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('workOrderCuttingHeader.date','workOrderCuttingDetailMaterial.serial_number', 't.id', 't.cn_ordinal');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $serialNumber) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('workOrderCuttingHeader.date', $startDate, $endDate);
    	$this->dataProvider->criteria->compare('receiveDetail.serial_number', $serialNumber, TRUE);
    }

}
