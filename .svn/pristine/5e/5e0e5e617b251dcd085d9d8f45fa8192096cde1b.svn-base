<?php
$this->pageTitle = Yii::app()->name . ' - Inventory';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Halaman Inventory</h1>
<div class="form">
    <?php if (Yii::app()->user->checkAccess('workOrderCreate') || Yii::app()->user->checkAccess('workOrderReplacementCreate') || Yii::app()->user->checkAccess('receiveCreate') || Yii::app()->user->checkAccess('stockCheck') || Yii::app()->user->checkAccess('inventoryCreateMaster')
    ):
    ?>
        <fieldset>
            <legend>Transaction</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('workOrderCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('SPK Potong', array('/manufacture/workOrderCutting/saleOrderList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('workOrderReplacementCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('SPK Replacement', array('/manufacture/workOrderReplacement/qualityControlList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('receiveCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Incoming Material', array('/transaction/receive/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('stockCheck')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Cek Stok', array('/transaction/stockCheck/summary')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('inventoryCreateMaster')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Supplier Material', array('/admin/supplier/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Product Category', array('/admin/productCategory/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Location', array('/admin/location/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Material', array('/admin/item/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>
    <?php endif; ?>
</div>

