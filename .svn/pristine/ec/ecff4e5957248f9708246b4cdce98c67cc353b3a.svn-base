<?php

$this->breadcrumbs = array(
    'Quality Control' => array('productionCuttingList'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'QC Cutting #',
            'value' => CHtml::encode($model->getCodeNumber(QualityControlCuttingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'SPK #',
            'value' => (!empty($model->workOrderCuttingHeader)) ? CHtml::encode($model->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : 'N/A',
        ),
        array(
            'label' => 'Customer',
            'value' => (!empty($model->workOrderCuttingHeader)) ? CHtml::encode($model->workOrderCuttingHeader->saleHeader->customer->company) : 'N/A',
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
        'workOrderCuttingDetail.job_number: Job Number',
        'workOrderCuttingDetail.product_name: GRADE',
        array(
            'header' => 'Tbl / Dmtr',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.height_quote"))',
        ),
        array(
            'header' => 'Lbr',
            'value' => '$data->workOrderCuttingDetail->width_quote',
        ),
        array(
            'header' => 'Pjg',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.length_quote"))',
        ),
        array(
            'header' => 'Berat',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.weight"))',
        ),
        array(
            'header' => 'Quantity QC',
            'value' => 'CHtml::encode(CHtml::value($data, "quantity"))',
        ),
        array(
            'header' => 'Quantity Potong',
            'value' => 'CHtml::encode(CHtml::value($data, "productionCuttingDetail.quantity"))',
        ),
        array(
            'header' => 'Total Quantity QC',
            'value' => 'CHtml::encode(CHtml::value($data, "productionCuttingDetail.totalQuantityCuttingControl"))',
        ),
        array(
            'header' => 'Sisa Quantity QC',
            'value' => 'CHtml::encode(CHtml::value($data, "productionCuttingDetail.quantityCuttingControlRemaining"))',
        ),
        array(
            'header' => 'PIC',
            'name' => 'employee_id',
            'value' => '$data->employee->name',
        ),
        
        array(
            'header' => 'Tanggal QC',
            'name' => 'control_date',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->control_date)',
        ),
        array(
            'header' => 'Hasil QC',
            'name' => 'control_result',
            'value' => 'CHtml::encode(CHtml::value($data, "control_result"))',
        ),
        'memo',
        array(
            'value' => 'CHtml::link("Label", array("label", "detailId" => $data->id))',
            'type' => 'raw',
        ),
    ),
)); ?>
<br />

<div id="link">
    <?php echo CHtml::link('Create', array('productionCuttingList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>
