<?php $this->breadcrumbs = array(
    'Purchase Invoice' => array('admin'),
    'Create',
); ?>

<h1>Purchase Invoice Create</h1>

<?php $this->renderPartial('_form', array(
    'model' => $model,
    'receiveHeader' => $receiveHeader,
    'receiveItemHeader' => $receiveItemHeader,
)); ?>