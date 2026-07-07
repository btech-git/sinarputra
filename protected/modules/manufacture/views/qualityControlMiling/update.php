<?php
$this->breadcrumbs = array(
	'Quality Control' => array( 'admin' ),
	'Create',
);
?>
<h1>Revisi Quality Control Miling</h1>

<?php echo $this->renderPartial('_form', array( 
    'qualityControl' => $qualityControl,
)); ?>