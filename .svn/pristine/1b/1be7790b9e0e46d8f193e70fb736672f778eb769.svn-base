<?php
$this->pageTitle = Yii::app()->name . ' - Finance / Accounting';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Halaman Finance / Accounting</h1>

<div class="form">
    <?php if (
        Yii::app()->user->checkAccess('deliveryCreate') || 
        Yii::app()->user->checkAccess('saleInvoiceCreate') || 
        Yii::app()->user->checkAccess('saleReceiptCreate') || 
        Yii::app()->user->checkAccess('salePaymentCreate')
    ): ?>

        <fieldset>
            <legend>Sales</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('deliveryCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Delivery Note', array('/transaction/delivery/workOrderList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('saleInvoiceCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Invoice', array('/accounting/saleInvoice/workOrderList')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Invoice Penunjang', array('/transaction/materialInvoice/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('saleReceiptCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Tanda Terima Penjualan', array('/accounting/saleReceipt/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('salePaymentCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pelunasan', array('/accounting/salePayment/create')); ?></li>
                    <li style="width: 50%"><?php echo CHtml::link('Pelunasan Penunjang', array('/transaction/materialPayment/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>

            </ul>
        </fieldset>
    <?php endif; ?>
    <br/>
    <?php if (
        Yii::app()->user->checkAccess('purchaseCreate') || 
        Yii::app()->user->checkAccess('purchaseItemCreate') || 
        Yii::app()->user->checkAccess('receiveItemCreate') ||
        Yii::app()->user->checkAccess('purchaseInvoiceCreate') ||
        Yii::app()->user->checkAccess('purchaseReceiptCreate') ||
        Yii::app()->user->checkAccess('purchasePaymentCreate') ||
        Yii::app()->user->checkAccess('purchaseCreateMaster')
    ): ?>

        <fieldset>
            <legend>Purchase</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('purchaseCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Purchasing Order Material', array('/transaction/purchase/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseItemCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('PO Barang Penunjang', array('/transaction/purchaseItem/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('receiveItemCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Penerimaan Barang Penunjang', array('/transaction/receiveItem/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseInvoiceCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Invoice', array('/accounting/purchaseInvoice/receiveList')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseReceiptCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Tanda Terima Pembelian', array('/accounting/purchaseReceipt/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchasePaymentCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pelunasan', array('/accounting/purchasePayment/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseCreateMaster')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Item', array('/admin/item/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Supplier Non Material', array('*')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Item Category', array('/admin/itemCategory/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>
    <?php endif; ?>
    <br/>
    <?php if (
        Yii::app()->user->checkAccess('accountingCre') || 
        Yii::app()->user->checkAccess('purchaseItemCreate') || 
        Yii::app()->user->checkAccess('receiveItemCreate') ||
        Yii::app()->user->checkAccess('purchaseInvoiceCreate') ||
        Yii::app()->user->checkAccess('purchaseReceiptCreate') ||
        Yii::app()->user->checkAccess('purchasePaymentCreate') ||
        Yii::app()->user->checkAccess('purchaseCreateMaster')
    ): ?>
        <fieldset>
            <legend>Accounting</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('accountingCreateMaster')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Customer', array('/admin/customer/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Supplier', array('/admin/supplier/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Gudang', array('/admin/warehouse/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('eFakturCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('e-Faktur', array('/accounting/saleInvoice/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('depositCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pengeluaran Kas / Bank', array('/accounting/expense/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('expenseCreate')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Penerimaan Kas / Bank', array('/accounting/deposit/create')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>
    <?php endif; ?>
</div>