<?php
$this->breadcrumbs = array(
    'PPC Miling' => array('admin'),
    'Update',
);
?>

<h1>Update Production and Planning Control (PPC) Miling</h1>
<?php
$this->renderPartial('_form', array(
    'model' => $model,
    'workOrderCutting' => $workOrderCutting,
    'workOrderReplacement' => $workOrderReplacement,
));
?>