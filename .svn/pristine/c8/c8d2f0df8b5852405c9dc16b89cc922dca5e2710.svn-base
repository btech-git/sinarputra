<?php

$this->breadcrumbs = array(
    'PPC Miling' => array('workOrderList'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1>Production and Planning Control (PPC) Miling / <?php echo $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'PPC Miling #',
            'value' => CHtml::encode($model->getCodeNumber(ProductionPlanningMilingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'SPK #',
            'value' => !empty($model->workOrderCuttingHeader) ? CHtml::encode($model->workOrderCuttingHeader->getCodeNumber(workOrderCuttingHeader::CN_CONSTANT)) : "N/A",
        ),
        array(
            'label' => 'SPK Replacement#',
            'value' => empty($model->workOrderCuttingHeader) ? CHtml::encode($model->workOrderReplacementHeader->getCodeNumber(workOrderReplacementHeader::CN_CONSTANT)) : "N/A",
        ),
        array(
            'label' => 'Customer',
            'value' => CHtml::encode(CHtml::value($model, 'customer.company')),
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
    'id' => 'production-planning-miling-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' =>
    array(     
        array(
            'header' => 'GRADE',
            'value' => 'empty($data->workOrderCuttingDetail) ? CHtml::value($data, "workOrderReplacementDetail.product_name") : CHtml::value($data, "workOrderCuttingDetail.product_name")',
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
            'header' => 'Berat',
            'value' => 'number_format(CHtml::encode(CHtml::value($data, "weight")), 4)',
        ),
        array(
            'header' => 'Mesin Facemil',
            'value' => '($data->machineIdFacemil !== null) ? $data->machineIdFacemil->fullSpecification : ""',
        ),
        array(
            'header' => 'Group Facemil',
            'value' => '$data->job_group_facemil',
        ),
        array(
            'header' => 'Tanggal Proses Facemil',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->planning_date_facemil)',
        ),
        array(
            'header' => 'Mesin Sidemil',
            'value' => '($data->machineIdSidemil !== null) ? $data->machineIdSidemil->fullSpecification : ""',
        ),
        array(
            'header' => 'Group Sidemil',
            'value' => '$data->job_group_sidemil',
        ),
        array(
            'header' => 'Tanggal Proses Sidemil',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->planning_date_sidemil)',
        ),
        array(
            'header' => 'Mesin Grinding',
            'value' => '($data->machineIdGrinding !== null) ? $data->machineIdGrinding->fullSpecification : ""',
        ),
        array(
            'header' => 'Group Grinding',
            'value' => '$data->job_group_grinding',
        ),
        array(
            'header' => 'Tanggal Proses Grinding',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->planning_date_grinding)',
        ),
    ),
)); ?>
<br />

<div id="link">
    <?php echo CHtml::link('Create', array('workOrderList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php //echo CHtml::link('Print Miling', array('memo', 'id' => $model->id), array('target' => '_blank')); ?>
    <?php //echo CHtml::link('Print Milling', array('memoMilling', 'id' => $model->id), array('target' => '_blank')); ?>
</div>
