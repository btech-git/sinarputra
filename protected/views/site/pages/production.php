<?php
$this->pageTitle = Yii::app()->name . ' - Production';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Halaman Produksi & QC</h1>
<div class="form">
    <?php if (Yii::app()->user->checkAccess('ppcCuttingCreate') || Yii::app()->user->checkAccess('poCuttingCreate') || Yii::app()->user->checkAccess('qcCuttingCreate') || Yii::app()->user->checkAccess('ppcMilingCreate') || Yii::app()->user->checkAccess('poMilingCreate') || Yii::app()->user->checkAccess('qcMilingCreate')): ?>
        <fieldset>
            <legend>Produksi Potong</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('ppcCuttingCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Production and Planning Control (PPC)', array('/manufacture/productionPlanningCutting/workOrderList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('poCuttingCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Production Output', array('/manufacture/productionCutting/productionPlanningList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('qcCuttingCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Quality Control', array('/manufacture/qualityControlCutting/workOrderList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Produksi Miling</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('ppcMilingCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Production and Planning Control (PPC)', array('/manufacture/productionPlanningMiling/workOrderList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('poMilingCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Production Output', array('/manufacture/productionMiling/productionPlanningList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('qcMilingCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Quality Control', array('/manufacture/qualityControlMiling/productionMilingList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>
    <?php endif; ?>
    <br/>
    <?php if (Yii::app()->user->checkAccess('productionCreateMaster')): ?>
        <fieldset>
            <legend>Production</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('productionCreateMaster')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Employee Production', array('*')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Machine', array('/admin/machine/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>
    <?php endif; ?>
</div>
