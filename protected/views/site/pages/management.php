<?php
$this->pageTitle = Yii::app()->name . ' - Management';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Modul Manejemen</h1>

<div class="form">

    <?php
    if (Yii::app()->user->checkAccess('purchaseEdit') ||
            Yii::app()->user->checkAccess('purchaseItemEdit') ||
            Yii::app()->user->checkAccess('purchaseReturnEdit') ||
            Yii::app()->user->checkAccess('receiveItemEdit') ||
            Yii::app()->user->checkAccess('receiveEdit')
    ):
        ?>


        <fieldset>
            <legend>Pembelian</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('purchaseEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Order Pembelian', array('/transaction/purchase/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseItemEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Item Pembelian', array('/transaction/purchaseItem/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('receiveEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Penerimaan Barang', array('/transaction/receive/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('receiveItemEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Penerimaan Item', array('/transaction/receiveItem/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseReturnEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Retur Pembelian', array('/transaction/purchaseReturn/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>

    <?php endif; ?>


    <?php
    if (Yii::app()->user->checkAccess('quotationEdit') ||
            Yii::app()->user->checkAccess('saleEdit') ||
            Yii::app()->user->checkAccess('deliveryEdit') ||
            Yii::app()->user->checkAccess('quotationReturnEdit')
    ):
        ?>

        <fieldset>
            <legend>Penjualan</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('quotationEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Penawaran', array('/transaction/quotation/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('saleEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Sale', array('/transaction/sale/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('deliveryEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pengiriman Barang', array('/transaction/delivery/admin')); ?></li>
                    <br class="clear" />
                    <li style="width: 50%"><?php echo CHtml::link('Pengiriman Barang (Partial)', array('/transaction/deliveryPartial/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('quotationReturnEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Quotation Return', array('/transaction/quotationReturn/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>

    <?php endif; ?>


    <?php
    if (Yii::app()->user->checkAccess('purchaseInvoiceEdit') ||
            Yii::app()->user->checkAccess('purchaseReceiptEdit') ||
            Yii::app()->user->checkAccess('purchasePaymentEdit') ||
            Yii::app()->user->checkAccess('saleInvoiceEdit') ||
            Yii::app()->user->checkAccess('saleReceiptEdit') ||
            Yii::app()->user->checkAccess('salePaymentEdit')
    ):
        ?>

        <fieldset>
            <legend>Finance</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('purchaseInvoiceEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Invoice Pembelian', array('/transaction/purchaseInvoice/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchaseReceiptEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Tanda Terima Pembelian', array('/transaction/purchaseReceipt/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('purchasePaymentEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pembayaran Pembelian', array('/transaction/purchasePayment/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('saleInvoiceEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Faktur Penjualan', array('/transaction/saleInvoice/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('saleReceiptEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Tanda Terima Penjualan', array('/transaction/saleReceipt/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('salePaymentEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pelunasan Penjualan', array('/transaction/salePayment/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>

    <?php endif; ?>


    <?php
    if (Yii::app()->user->checkAccess('depositEdit') ||
            Yii::app()->user->checkAccess('expenseEdit') ||
            Yii::app()->user->checkAccess('adjustmentCreate')
    ):
        ?>
        <fieldset>
            <legend>Accounting</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('expenseEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pengeluaran Kas / Bank', array('/transaction/expense/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('depositEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Pemasukan Kas / Bank', array('/transaction/deposit/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('adjustmentEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Jurnal Penyesuaian', array('/transaction/journalVoucher/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
            </ul>
        </fieldset>

    <?php endif; ?>


    <?php
    if (Yii::app()->user->checkAccess('workOrderEdit') ||
            Yii::app()->user->checkAccess('jobOrderEdit') ||
            Yii::app()->user->checkAccess('cuttingEdit')
    ):
        ?>


        <fieldset>
            <legend>Potong</legend>
            <ul style="display: table-cell; width: 800px">
                <?php if (Yii::app()->user->checkAccess('workOrderEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('SPK Potong', array('/transaction/workOrderCutting/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
                <?php if (Yii::app()->user->checkAccess('jobOrderEdit')): ?>
                    <li style="width: 50%"><?php echo CHtml::link('Job Order PPIC', array('/transaction/jobOrder/admin')); ?></li>
                    <br class="clear" />
                <?php endif; ?>
               
                    <li style="width: 50%"><?php echo CHtml::link('Hasil Potong', array('/transaction/cutting/admin')); ?></li>
                    <br class="clear" />

            </ul>
        </fieldset>

    <?php endif; ?>
</div>
