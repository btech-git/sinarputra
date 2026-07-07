<?php
//$model as a WorkOrderMachiningHeader model

$this->breadcrumbs = array(
    'Production Cutting' => array('workOrderList'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1>Production Cutting / <?php echo $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Production Cutting #',
            'value' => CHtml::encode($model->getCodeNumber(ProductionCuttingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        'time',
        array(
            'label' => 'PPC #',
            'value' => $model->productionPlanningCuttingHeader ? CHtml::encode($model->productionPlanningCuttingHeader->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)) : 'N/A',
        ),
        array(
            'label' => 'SPK #',
            'value' => !empty($model->productionPlanningCuttingHeader->workOrderCuttingHeader) ? CHtml::encode($model->productionPlanningCuttingHeader->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : 'N/A',
        ),
        array(
            'label' => 'SPK Replacement #',
            'value' => empty($model->productionPlanningCuttingHeader->workOrderCuttingHeader) ? CHtml::encode($model->productionPlanningCuttingHeader->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)) : 'N/A',
        ),
        array(
            'label' => 'Customer',
            'value' => $model->productionPlanningCuttingHeader->workOrderCuttingHeader ? CHtml::encode($model->productionPlanningCuttingHeader->workOrderCuttingHeader->saleHeader->customer->company) : 'N/A',
        ),
        array(
            'label' => 'Catatan',
            'value' => $model->note,
        ),
    ),
));
?>
<br />

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'purchase-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' =>
    array(
        array(
            'header' => 'Job Number',
            'value' => '($data->productionPlanningCuttingDetail->work_order_cutting_detail_id == null) ? CHtml::value($data, "productionPlanningCuttingDetail.workOrderReplacementDetail.job_number") : CHtml::value($data, "productionPlanningCuttingDetail.workOrderCuttingDetail.job_number")',
        ),
        array(
            'header' => 'Item',
            'value' => '($data->productionPlanningCuttingDetail->work_order_cutting_detail_id == null) ? CHtml::value($data, "productionPlanningCuttingDetail.workOrderReplacementDetail.product_name") : CHtml::value($data, "productionPlanningCuttingDetail.workOrderCuttingDetail.product_name")',
        ),
        array(
            'header' => 'Tbl / Dmtr',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "height")), 2)',
        ),
        array(
            'header' => 'Lbr',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "width")), 2)',
        ),
        array(
            'header' => 'Pjg',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "length")), 2)',
        ),
        array(
            'header' => 'Quantity PPC',
            'value' => 'CHtml::encode(CHtml::value($data, "productionPlanningCuttingDetail.quantity"))',
        ),
        array(
            'header' => 'Total Qty Potong',
            'value' => 'CHtml::encode(CHtml::value($data, "productionPlanningCuttingDetail.totalQuantityCuttingProduction"))',
        ),
        array(
            'header' => 'Sisa Qty Potong',
            'value' => 'CHtml::encode(CHtml::value($data, "productionPlanningCuttingDetail.quantityCuttingProductionRemaining"))',
        ),
        array(
            'header' => 'Berat',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 4)',
        ),
        array(
            'header' => 'Mesin',
            'value' => '$data->machine->fullSpecification',
        ),
        array(
            'header' => 'Operator',
            'value' => '$data->employee->nameAndGroup',
        ),
        array(
            'header' => 'Jam Mulai',
            'value' => '$data->production_time_start',
        ),
        array(
            'header' => 'Jam Selesai',
            'value' => '$data->production_time_end',
        ),
    ),
)); ?>

<br />

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quality-control-header-grid',
    'dataProvider' => $qualityControlsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' =>
    array(
        array(
            'header' => 'QC #',
            'value' => '$data->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT)'
        ),
        array(
            'header' => 'Tanggal',
            'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->date)',
        ),
        array(
            'header' => 'Quantity',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "totalQuantity")), 0)',
            'htmlOptions' => array('style' => 'text-align: center'),
        ),
    ),
)); ?>

<br />

<div id="link">
    <?php echo CHtml::link('Create', array('productionPlanningList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>
