<?php
$this->pageTitle = Yii::app()->name . ' - Customer Care Center';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Halaman Customer Care Center</h1>
<div class="form">
    <?php
    if (Yii::app()->user->checkAccess('saleCreate') || Yii::app()->user->checkAccess('quotationCreate') || Yii::app()->user->checkAccess('statusReviewCreate')
    ):
        ?>
        <fieldset>
            <legend>Transaction</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('quotationCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Quotation Order', array('/transaction/quotation/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('saleCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Customer Order', array('/transaction/sale/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('statusReviewCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Status Review', array('/transaction/statusReview/summary')); ?></li>
                <?php endif; ?>

            </ul>
        </fieldset>      
    <?php endif; ?>
</div>