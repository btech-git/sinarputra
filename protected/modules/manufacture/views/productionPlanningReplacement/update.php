<?php
$this->breadcrumbs = array(
    'Job Order' => array('admin'),
    'Update',
);
?>

<h1>Update Production and Planning Control (PPC)</h1>
<?php
$this->renderPartial('_form', array(
    'model' => $model,
//    'workOrderCuttingHeader' => $workOrderCuttingHeader,
//    'workOrderCuttingHeaderDataProvider' => $workOrderCuttingHeaderDataProvider,
//    'customerId' => $customerId,
));
?>