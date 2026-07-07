<?php
$this->breadcrumbs = array(
    'Production Miling' => array('admin'),
    'Update',
);
?>

<h1>Update Production Miling</h1>
<?php
$this->renderPartial('_form', array(
    'model' => $model,
));
?>