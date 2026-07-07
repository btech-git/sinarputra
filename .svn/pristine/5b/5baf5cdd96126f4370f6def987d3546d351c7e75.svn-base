<?php Yii::app()->clientScript->registerCss('memo', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
'); ?>


<?php

$this->renderPartial('memoHeader', array(
    'model' => $model,
    'salesman' => $salesman,
));
?>

<?php $count = count($model->workOrderCuttingDetails); ?>

<?php $pageSize = 3; ?>

<?php $this->renderPartial('memoDetail', array(
    'model' => $model,
)); ?>

<?php $this->renderPartial('memoFooter', array(
    'model' => $model
)); ?>