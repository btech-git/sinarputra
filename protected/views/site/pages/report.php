<?php
$this->pageTitle = Yii::app()->name . ' - Report';
$this->breadcrumbs = array(
    'Sinar Putra Metalindo',
);
?>

<h1>Laporan Transaksi</h1>

<hr />

<div class="form">
    <div class="form-row">
        <div class="form-group">
            <?php if (Yii::app()->user->checkAccess('quotationReport')): ?>
                <fieldset>
                    <legend>C3</legend>
                    <ul style="display: table-cell; width: 100%">
                        <li><?php echo CHtml::link('Laporan C3 By Order Penawaran', array('/report/quotation/summary')); ?></li>
                        <br class="clear" />
                        <li><?php echo CHtml::link('Laporan Status Quotation (Total)', array('/report/quotationSummary/summary')); ?></li>
                        <br class="clear" />
                        <li><?php echo CHtml::link('Laporan C3 By Order Penjualan', array('/report/sale/summary')); ?></li>
                        <br class="clear" />  
                        <li><?php echo CHtml::link('Laporan C3 By Customer', array('/report/saleByCustomer/summary')); ?></li>
                        <br class="clear" />  
                        <li><?php echo CHtml::link('Laporan C3 By Salesman', array('/report/saleBySalesman/summary')); ?></li>
                        <br class="clear" />  
                        <li><?php echo CHtml::link('Laporan C3 Harian (PO)', array('/report/saleDaily/summary')); ?></li>
                        <br class="clear" /> 
                    </ul>
                </fieldset>
            <?php endif; ?>

            <br />

            <?php if (Yii::app()->user->checkAccess('saleMarketingReport')): ?>
                <fieldset>
                    <legend>Sales Marketing</legend>
                    <ul style="display: table-cell; width: 100%">
                        <li><?php echo CHtml::link('Laporan Omzet Per Customer General', array('/report/saleOmzetCustomer/summary')); ?></li>
                        <br class="clear" />
                        <li><?php echo CHtml::link('Laporan Omzet Per Customer Detail', array('/report/saleOmzetCustomerDetail/summary')); ?></li>
                        <br class="clear" />  
                        <li><?php echo CHtml::link('Laporan Omzet Per Sales By Grade Detail', array('/report/saleOmzetSalesByGrade/summary')); ?></li>
                        <br class="clear" />  
                        <li><?php echo CHtml::link('Laporan Omzet Per Sales General', array('/report/saleOmzetSalesman/summary')); ?></li>
                        <br class="clear" />  
                        <li><?php echo CHtml::link('Laporan Omzet Per Grade (IDR)', array('/report/saleOmzetGrade/summary')); ?></li>
                        <br class="clear" /> 
                        <li><?php echo CHtml::link('Laporan Omzet Per Grade (KG)', array('/report/saleWeightGrade/summary')); ?></li>
                        <br class="clear" /> 
                    </ul>
                </fieldset>
            <?php endif; ?>

            <br />

            <?php if (Yii::app()->user->checkAccess('workOrderReport') || Yii::app()->user->checkAccess('receiveMaterialReport')): ?>
                <fieldset>
                    <legend>Inventory</legend>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('receiveMaterialReport')): ?>
                            <li><?php echo CHtml::link('Laporan Penerimaan Material', array('/report/receiveDetail/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('workOrderReport')): ?>
                            <li><?php echo CHtml::link('Laporan SPK Cutting Detail', array('/report/workOrderCuttingDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Penggunaan Material Awal SPK', array('/report/workOrderCuttingDetailMaterial/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan SPK Replacement Detail', array('/report/workOrderReplacementDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan SPK Detail By SN', array('/report/workOrderCuttingDetailMaterialBySn/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Stok Sisa Potong', array('/report/stockCheckWorkOrder/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Stok Lembaran', array('/report/stockCheck/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Monitoring Stok', array('/report/workOrderOutstanding/summary')); ?></li>
                            <br class="clear" />
                           <!-- <li style="width: 50%"><?php //echo CHtml::link('Laporan SPK Cutting', array('/report/workOrderCutting/summary')); ?></li>
                            <br class="clear" />-->
                             <!--   <li style="width: 50%"><?php //echo CHtml::link('Laporan SPK Replacement', array('/report/workOrderReplacement/summary')); ?></li>
                                <br class="clear" />-->
                           <!-- <li style="width: 50%"><?php //echo CHtml::link('Laporan SPK Detail Inventory', array('/report/workOrderCuttingDetailMaterial/summary')); ?></li>
                            <br class="clear" />-->
                        <?php endif; ?>

                    </ul>
                </fieldset>    
            <?php endif; ?>

            <br />

            <?php if (
                Yii::app()->user->checkAccess('productionPlanningCuttingReport') || 
                Yii::app()->user->checkAccess('productionOutstandingCuttingReport') || 
                Yii::app()->user->checkAccess('productionCuttingReport') || 
                Yii::app()->user->checkAccess('productionPlanningMilingReport') || 
                Yii::app()->user->checkAccess('productionMilingReport') || 
                Yii::app()->user->checkAccess('qualityControlCuttingReport') || 
                Yii::app()->user->checkAccess('qualityControlMilingReport')
            ): ?> 
                <fieldset>
                    <legend>Production</legend>

                    <span style="text-decoration: underline"><h4>Potong</h4></span>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('productionPlanningCuttingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Produksi Cutting Planning (PPC)', array('/report/productionPlanningCuttingSummary/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Produksi and Planning Replacement (PPC-R) Cutting', array('/report/productionPlanningReplacementCutting/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('productionOutstandingCuttingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Perencanaan Proses Produksi', array('/report/productionOutstanding/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('productionCuttingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Production Cutting Output', array('/report/productionCutting/summary')); ?></li>
                            <br class="clear" />  
                        <?php endif; ?>
                    </ul>

                    <span style="text-decoration: underline"><h4>Miling</h4></span>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('productionPlanningMilingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Produksi and Planning (PPC) Milling', array('/report/productionPlanningMilingSummary/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Produksi and Planning Replacement (PPC-R) Milling', array('/report/productionPlanningReplacementMilingSummary/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('productionMilingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Production Miling Output', array('/report/productionMilingSummary/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                    </ul>

                    <span style="text-decoration: underline"><h4>Quality Control</h4></span>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('qualityControlCuttingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Quality Control Cutting', array('/report/qualityControlCutting/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                        <?php if (Yii::app()->user->checkAccess('qualityControlMilingReport')): ?>
                            <li><?php echo CHtml::link('Laporan Quality Control Miling', array('/report/qualityControlMilingSummary/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                    </ul>
                </fieldset> 
            <?php endif; ?>
        </div>

        <div class="form-group">
            <?php if (
                Yii::app()->user->checkAccess('deliveryReport') ||
                Yii::app()->user->checkAccess('saleInvoiceReport') ||
                Yii::app()->user->checkAccess('saleReceiptReport') ||
                Yii::app()->user->checkAccess('purchaseReport') ||
                Yii::app()->user->checkAccess('receiveReport') ||
                Yii::app()->user->checkAccess('purchaseInvoiceReport') ||
                Yii::app()->user->checkAccess('purchaseReceiptReport') ||
                Yii::app()->user->checkAccess('purchasePaymentReport') ||
                Yii::app()->user->checkAccess('salePaymentReport') ||
                Yii::app()->user->checkAccess('receivableCustomerReport') ||
                Yii::app()->user->checkAccess('expenseReport') ||
                Yii::app()->user->checkAccess('depositReport') ||
                Yii::app()->user->checkAccess('accountingReport')
            ): ?>
                <fieldset>
                    <legend>Finance / Accounting</legend>

                    <span style="text-decoration: underline"><h4>Sales</h4></span>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('deliveryReport')): ?>
        <!--                            <li style="width: 50%"><?php //echo CHtml::link('Laporan Pengiriman Barang', array('/report/delivery/summary')); ?></li>-->
                            <li><?php echo CHtml::link('Laporan Pengiriman', array('/report/deliveryDaily/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pengiriman Manual', array('/report/deliveryManual/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pengiriman Manual 2', array('/report/deliveryBackup/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('saleInvoiceReport')): ?>
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan', array('/report/saleInvoice/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan Manual', array('/report/manualSaleInvoice/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan Manual 2', array('/report/materialInvoice/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan Detail', array('/report/saleInvoiceDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan Manual Detail', array('/report/manualInvoiceDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan Manual 2 Detail', array('/report/materialInvoiceDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Faktur Penjualan (Sample)', array('/report/saleInvoiceSample/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Buku Penjualan', array('/report/saleInvoiceDaily/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Buku Penjualan Manual', array('/report/manualSaleInvoiceDaily/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Buku Penjualan Manual 2', array('/report/materialInvoiceDaily/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('saleReceiptReport')): ?>
                            <li><?php echo CHtml::link('Laporan Tanda Terima Penjualan', array('/report/saleReceipt/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Tanda Terima Penjualan Manual', array('/report/manualSaleReceipt/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Tanda Terima Penjualan Manual 2', array('/report/materialReceipt/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                    </ul>

                    <span style="text-decoration: underline"><h4>Purchase</h4></span>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('purchaseReport')): ?>
                            <li><?php echo CHtml::link('Laporan Order Pembelian', array('/report/purchase/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pembelian Detail', array('/report/purchaseDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pembelian By Supplier', array('/report/purchaseBySupplier/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pembelian Penunjang Detail', array('/report/purchaseItemDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Penerimaan Barang Penunjang', array('/report/receiveItem/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('receiveReport')): ?>
                            <li><?php echo CHtml::link('Laporan Penerimaan Barang', array('/report/receive/summary')); ?></li>
                            <br class="clear" /> 
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('purchaseInvoiceReport')): ?>
                            <li><?php echo CHtml::link('Laporan Faktur Pembelian', array('/report/purchaseInvoice/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                    </ul>

                    <span style="text-decoration: underline"><h4>Finance</h4></span>
                    <ul style="display: table-cell; width: 100%">
                        <?php if (Yii::app()->user->checkAccess('purchaseReceiptReport')): ?>
                            <li><?php echo CHtml::link('Laporan Tanda Terima Pembelian', array('/report/purchaseReceiptSupplier/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                            
                        <?php if (Yii::app()->user->checkAccess('purchasePaymentReport')): ?>
                            <li><?php echo CHtml::link('Laporan Pembayaran Pembelian', array('/report/purchasePaymentDetail/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                            
                        <?php if (Yii::app()->user->checkAccess('salePaymentReport')): ?>
                            <li><?php echo CHtml::link('Laporan Pelunasan Piutang Detail', array('/report/salePaymentDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pelunasan Piutang Detail Manual', array('/report/manualSalePaymentDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Pelunasan Piutang Detail Manual 2', array('/report/materialPayment/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                            
                        <?php if (Yii::app()->user->checkAccess('receivableCustomerReport')): ?>
                            <li><?php echo CHtml::link('Laporan Outstanding Per Customer Detail', array('/report/saleReceiptDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Outstanding Per Customer Detail Manual', array('/report/manualSaleReceiptDetail/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Outstanding Per Customer Manual 2', array('/report/materialReceivable/summary')); ?></li>
                            <br class="clear" />
                            <li><?php echo CHtml::link('Laporan Outstanding Per Customer Bulanan', array('/report/receivableMonthly/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                            
                        <?php if (Yii::app()->user->checkAccess('expenseReport')): ?>
                            <li><?php echo CHtml::link('Laporan Pengeluaran Kas / Bank', array('/report/expense/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                            
                        <?php if (Yii::app()->user->checkAccess('depositReport')): ?>
                            <li><?php echo CHtml::link('Laporan Penerimaan Kas / Bank', array('/report/deposit/summary')); ?></li>
                            <br class="clear" />  
                        <?php endif; ?>
                            
                        <?php if (Yii::app()->user->checkAccess('accountingReport')): ?>
                            <li style="width: 50%"><?php echo CHtml::link('Buku Kas / Bank', array('/report/bankBook/summary')); ?></li>
                            <br class="clear" />
                            <li style="width: 50%"><?php echo CHtml::link('Buku Besar', array('/report/generalLedger/summary')); ?></li>
                            <br class="clear" />
                            <li style="width: 50%"><?php echo CHtml::link('Buku Besar Piutang', array('/report/receivableLedger/summary')); ?></li>
                            <br class="clear" />
                            <li style="width: 50%"><?php echo CHtml::link('Balance Sheet', array('/report/balanceSheet/summary')); ?></li>
                            <br class="clear" />
                            <li style="width: 50%"><?php echo CHtml::link('Laba / Rugi', array('/report/profitLoss/summary')); ?></li>
                            <br class="clear" />
                        <?php endif; ?>
                    </ul>
                </fieldset>
            <?php endif; ?>
        </div>
    </div>
</div>