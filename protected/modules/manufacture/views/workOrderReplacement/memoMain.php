<?php Yii::app()->clientScript->registerCss('memo', '
   
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }

'); ?>


<?php
$detailsCount = 0;

//if (!CHtml::value($model, 'saleHeader.is_service'))
    $detailsCount = count($model->workOrderReplacementDetails);
//else
//    $detailsCount = count($model->workOrderCuttingDetailServices);

$pages = ceil($detailsCount / 30);


for ($i = 1; $i <= $pages; $i++) {

    $counterStart = ($i - 1) * 30;
    $counterEnd = $i * 30;
    $spacing = 0;

    if ($i == $pages)
        $spacing = 1;


    $this->renderPartial('memoHeader', array(
        'model' => $model
    ));

    $this->renderPartial('memoDetail', array(
        'model' => $model,
        'counterStart' => $counterStart,
        'counterEnd' => $counterEnd,
        'spacing' => $spacing,
    ));


    if ($i == $pages) {
        $this->renderPartial('memoFooter', array(
            'model' => $model
        ));
    }
    ?>

    <div style="height: 250px">&nbsp;</div>

    <?php
}
?>

