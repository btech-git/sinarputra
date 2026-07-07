<?php
//$model as a WorkOrderMachiningHeader model

$this->breadcrumbs = array(
    'PPC' => array('workOrderList'),
    'View',
);
?>

<style>
    table
    {
        margin-bottom: 0px;
    }
</style>

<h1>Production and Planning Control (PPC) Cutting / <?php echo $this->action->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'PPC Cutting #',
            'value' => CHtml::encode($model->getCodeNumber(ProductionPlanningCuttingHeader::CN_CONSTANT)),
        ),
        array(
            'label' => 'Tanggal',
            'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $model->date),
        ),
        array(
            'label' => 'SPK #',
            'value' => !empty($model->workOrderCuttingHeader) ? CHtml::encode($model->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT)) : 'N/A',
        ),
        array(
            'label' => 'SPK Replacement #',
            'value' => empty($model->workOrderCuttingHeader) ? CHtml::encode($model->workOrderReplacementHeader->getCodeNumber(WorkOrderReplacementHeader::CN_CONSTANT)) : 'N/A',
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
    'id' => 'purchase-detail-grid',
    'dataProvider' => $detailsDataProvider,
    'htmlOptions' => array(
        'margin' => '0px'
    ),
    'columns' =>
    array(
        array(
            'header' => 'Job Number',
            'value' => 'empty($data->workOrderCuttingDetail) ? CHtml::value($data, "workOrderReplacementDetail.job_number") : CHtml::value($data, "workOrderCuttingDetail.job_number")',
        ),
        array(
            'header' => 'Item',
            'value' => 'empty($data->workOrderCuttingDetail) ? CHtml::value($data, "workOrderReplacementDetail.product_name") : CHtml::value($data, "workOrderCuttingDetail.product_name")',
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
            'header' => 'Quantity SPK',
            'value' => 'CHtml::encode(CHtml::value($data, "workOrderCuttingDetail.quantity"))',
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
            'header' => 'Mesin',
            'value' => '$data->machine->fullSpecification',
        ),
        array(
            'header' => 'Group',
            'value' => '$data->job_group',
        ),
        array(
            'header' => 'Tanggal Proses',
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->planning_date)',
        ),
        array(
            'header' => 'Urgent',
            'value' => 'empty($data->workOrderCuttingDetail) ? "" : $data->workOrderCuttingDetail->urgentStatus',
        ),
    ),
)); ?>
<br />

<div id="link">
    <?php echo CHtml::link('Create', array('workOrderList')); ?>
    <?php echo CHtml::link('Manage', array('admin')); ?>
    <?php echo CHtml::link('Print SPK', array('memo', 'id' => $model->id), array('target' => '_blank')); ?>
</div>
