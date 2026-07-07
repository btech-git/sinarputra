<?php

$this->breadcrumbs = array(
    'Quality Control Miling' => array('productionMilingList'),
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
    'data' => $qualityControl,
    'attributes' => array(
        array(
            'label' => 'QC Miling #',
            'value' => CHtml::encode($qualityControl->getCodeNumber(QualityControlMilingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $qualityControl->date),
        ),
        array(
            'label' => 'Production #',
            'value' => CHtml::encode($qualityControl->productionMilingHeader->getCodeNumber(ProductionMilingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Customer',
            'value' => $qualityControl->productionMilingHeader->productionPlanningMilingHeader->workOrderCuttingHeader->saleHeader->customer->company,
        ),
        array(
            'label' => 'Catatan',
            'value' => $qualityControl->note,
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
            'header' => 'Tbl / Dmtr RAW',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.height_quote"))',
        ),
        array(
            'header' => 'Lbr RAW',
            'value' => '$data->workOrderCuttingDetail->width_quote',
        ),
        array(
            'header' => 'Pjg RAW',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.length_quote"))',
        ),
        array(
            'header' => 'Tbl / Dmtr FINISH',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.height_request"))',
        ),
        array(
            'header' => 'Lbr FINISH',
            'value' => '$data->workOrderCuttingDetail->width_request',
        ),
        array(
            'header' => 'Pjg FINISH',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.length_request"))',
        ),
        array(
            'header' => 'Berat',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.weight"))',
        ),
        array(
            'header' => 'Quantity SPK',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.quantity"))',
        ),
        array(
            'header' => 'Total Quantity QC',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.totalQuantityMilingQualityControl"))',
        ),
        array(
            'header' => 'Sisa Quantity QC',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.quantityMilingQualityControlRemaining"))',
        ),
        array(
            'header' => 'M',
            'value' => 'CHtml::encode(CHtml::value($data, "milingStatus"))',
        ),
        array(
            'header' => 'SM',
            'value' => 'CHtml::encode(CHtml::value($data, "sidemilStatus"))',
        ),
            array(
                'header' => 'Tol. T',
                'value' => 'CHtml::value($data, "sidemiling_height_tolerance")',
            ),
            array(
                'header' => 'Tol. L',
                'value' => 'CHtml::value($data, "sidemiling_width_tolerance")' ,
            ),
            array(
                'header' => 'Tol. P',
                'value' => 'CHtml::value($data, "sidemiling_length_tolerance")',
            ),
        array(
            'header' => 'G',
            'value' => 'CHtml::encode(CHtml::value($data, "grindingStatus"))',
        ),
            array(
                'header' => 'Tol. T',
                'value' => 'CHtml::value($data, "grinding_height_tolerance")',
            ),
            array(
                'header' => 'Tol. L',
                'value' => 'CHtml::value($data, "grinding_width_tolerance")',
            ),
            array(
                'header' => 'Tol. P',
                'value' => 'CHtml::value($data, "grinding_length_tolerance")',
            ),
        array(
            'header' => 'HT',
            'value' => 'CHtml::encode(CHtml::value($data, "hardenessStatus"))',
        ),
        array(
            'header' => 'NTD',
            'value' => 'CHtml::encode(CHtml::value($data, "annelyingStatus"))',
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
    <?php echo CHtml::link('Create', array('productionMilingList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
</div>
