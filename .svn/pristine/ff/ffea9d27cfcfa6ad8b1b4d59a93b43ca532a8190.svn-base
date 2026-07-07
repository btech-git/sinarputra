<?php

$this->breadcrumbs = array(
    'Production Miling' => array('productionPlanningList'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1>Production Miling / <?php echo $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Production Miling #',
            'value' => CHtml::encode($model->getCodeNumber(ProductionMilingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        'time',
        array(
            'label' => 'PPC #',
            'value' => CHtml::encode($model->productionPlanningMilingHeader->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Customer',
            'value' => CHtml::encode(CHtml::value($model, 'productionPlanningMilingHeader.workOrderCuttingHeader.saleHeader.customer.company')),
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
    'id' => 'production-miling-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' =>
    array(           
        array(
            'header' => 'Job Number',
            'value' => 'CHtml::value($data, "productionPlanningMilingDetail.workOrderCuttingDetail.job_number")',
        ),
        array(
            'header' => 'Item',
            'value' => 'CHtml::value($data, "productionPlanningMilingDetail.workOrderCuttingDetail.product_name")',
        ),
        array(
            'header' => 'Tbl / Dmtr RAW',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "height_quote")), 2)',
        ),
        array(
            'header' => 'Lbr RAW',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "width_quote")), 2)',
        ),
        array(
            'header' => 'Pjg RAW',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "length_quote")), 2)',
        ),
        array(
            'header' => 'Tbl / Dmtr FINISH',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "height_request")), 2)',
        ),
        array(
            'header' => 'Lbr FINISH',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "width_request")), 2)',
        ),
        array(
            'header' => 'Pjg FINISH',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "length_request")), 2)',
        ),
        array(
            'header' => 'Quantity',
            'value' => 'CHtml::encode(CHtml::value($data, "quantity"))',
        ),
        array(
            'header' => 'Quantity SPK',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.quantity"))',
        ),
        array(
            'header' => 'Total Qty Miling',
            'value' => 'CHtml::encode(CHtml::value($data, "productionPlanningMilingDetail.totalQuantityMilingProduction"))',
        ),
        array(
            'header' => 'Sisa Qty Miling',
            'value' => 'CHtml::encode(CHtml::value($data, "productionPlanningMilingDetail.quantityMilingProductionRemaining"))',
        ),
        array(
            'header' => 'Berat',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 4)',
        ),
        array(
            'header' => 'Mesin Facemil',
            'value' => '($data->machineIdFacemil !== null) ? $data->machineIdFacemil->fullSpecification : ""',
        ),
        array(
            'header' => 'Operator Facemil',
            'value' => '($data->employeeIdFacemil !== null) ? $data->employeeIdFacemil->nameAndGroup : ""',
        ),
        array(
            'header' => 'Mesin Sidemil',
            'value' => '($data->machineIdSidemil !== null) ? $data->machineIdSidemil->fullSpecification : ""',
        ),
        array(
            'header' => 'Operator Sidemil',
            'value' => '($data->employeeIdSidemil !== null) ? $data->employeeIdSidemil->nameAndGroup : ""',
        ),
        array(
            'header' => 'Mesin Grinding',
            'value' => '($data->machineIdGrinding !== null) ? $data->machineIdGrinding->fullSpecification : ""',
        ),
        array(
            'header' => 'Operator Grinding',
            'value' => '($data->employeeIdGrinding !== null) ? $data->employeeIdGrinding->nameAndGroup: ""',
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

<div id="link">
    <?php echo CHtml::link('Create', array('productionPlanningList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>
