<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />    

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div class="container" id="page">

            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>        
                <nav>
                    <ul class="nav">
                        <?php if (Yii::app()->user->checkAccess('purchaseCreateMaster') ||
                            Yii::app()->user->checkAccess('accountingCreateMaster') ||
                            Yii::app()->user->checkAccess('inventoryCreateMaster') ||
                            Yii::app()->user->checkAccess('hrgaCreateMaster') ||
                            Yii::app()->user->checkAccess('productionCreateMaster') ||
                            Yii::app()->user->checkAccess('purchaseEditMaster') ||
                            Yii::app()->user->checkAccess('accountingEditMaster') ||
                            Yii::app()->user->checkAccess('inventoryEditMaster') ||
                            Yii::app()->user->checkAccess('hrgaEditMaster') ||
                            Yii::app()->user->checkAccess('productionEditMaster') ||
                            Yii::app()->user->checkAccess('purchaseViewMaster') ||
                            Yii::app()->user->checkAccess('accountingViewMaster') ||
                            Yii::app()->user->checkAccess('inventoryViewMaster') ||
                            Yii::app()->user->checkAccess('hrgaViewMaster') ||
                            Yii::app()->user->checkAccess('productionViewMaster')
                        ): ?>
                            <li class="dropdown">
                                <?php echo CHtml::link('Master', array('/site/page', 'view' => 'master')); ?>
                                <ul>
                                    <li style="font-weight: bold; text-decoration: underline">DATA MASTER</li>
                                    <?php if (Yii::app()->user->checkAccess('purchaseCreateMaster') ||
                                    Yii::app()->user->checkAccess('purchaseEditMaster') ||
                                    Yii::app()->user->checkAccess('purchaseViewMaster')): ?>
                                        <li><?php echo CHtml::link('Item', array('/admin/item/admin')); ?></li>
                                        <li><?php echo CHtml::link('Supplier Non Material', array('*')); ?></li>
                                        <li><?php echo CHtml::link('Item Category', array('/admin/itemCategory/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('accountingCreateMaster') ||
                                    Yii::app()->user->checkAccess('accountingEditMaster') ||
                                    Yii::app()->user->checkAccess('accountingViewMaster')): ?>
                                        <li><?php echo CHtml::link('Chart of Account', array('/admin/account/admin')); ?></li>
                                        <li><?php echo CHtml::link('Customer', array('/admin/customer/admin')); ?></li>    
                                        <li><?php echo CHtml::link('Gudang', array('/admin/warehouse/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('inventoryCreateMaster') ||
                                    Yii::app()->user->checkAccess('inventoryEditMaster') ||
                                    Yii::app()->user->checkAccess('inventoryViewMaster')): ?>
                                        <li><?php echo CHtml::link('Supplier Material', array('/admin/supplier/admin')); ?></li>
                                        <li><?php echo CHtml::link('Material', array ('/admin/item/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('hrgaCreateMaster') ||
                                            Yii::app()->user->checkAccess('hrgaEditMaster') ||
                                            Yii::app()->user->checkAccess('hrgaViewMaster')): ?>    
                                        <li><?php echo CHtml::link('Employee', array('/admin/employee/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('productionCreateMaster') ||
                                    Yii::app()->user->checkAccess('productionEditMaster') ||
                                    Yii::app()->user->checkAccess('productionViewMaster')): ?>
                                        <li><?php echo CHtml::link('Employee Production', array('*')); ?></li>
                                    <?php endif; ?>
                                        
                                    <li style="font-weight: bold; text-decoration: underline">DATA PEMBANTU</li>
                                    <?php if (Yii::app()->user->checkAccess('productionCreateMaster') ||
                                    Yii::app()->user->checkAccess('productionEditMaster') ||
                                    Yii::app()->user->checkAccess('productionViewMaster')): ?>
                                        <li><?php echo CHtml::link('Mesin', array('/admin/machine/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('inventoryCreateMaster') ||
                                    Yii::app()->user->checkAccess('inventoryEditMaster') ||
                                    Yii::app()->user->checkAccess('inventoryViewMaster')): ?>  
                                        <li><?php echo CHtml::link('Product Category', array('/admin/productCategory/admin')); ?></li>    
                                        <li><?php echo CHtml::link('Location', array('/admin/location/admin')); ?></li>    
                                        <li><?php echo CHtml::link('Kendaraan Operasional', array('/admin/deliveryVehicle/admin')); ?></li>
                                    <?php endif; ?>    
                                    <?php if (Yii::app()->user->checkAccess('accountingCreateMaster') ||
                                    Yii::app()->user->checkAccess('accountingEditMaster') ||
                                    Yii::app()->user->checkAccess('accountingViewMaster')): ?>
                                        <li><?php echo CHtml::link('Akun Kategori', array('/admin/accountCategory/admin')); ?></li>
                                        <li><?php echo CHtml::link('Currency', array('/admin/currency/admin')); ?></li>
                                        <li><?php echo CHtml::link('Satuan', array('/admin/unit/admin')); ?></li>  
                                        <li><?php echo CHtml::link('Payment Type', array('/admin/paymentType/admin')); ?></li>
                                    <?php endif; ?>    
                                    
                                    <li style="font-weight: bold; text-decoration: underline">DATA PEMBANTU EMPLOYEE</li>
                                    <?php if (Yii::app()->user->checkAccess('hrgaCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Employee Category', array('/admin/employeeCategory/admin')); ?></li>
                                        <li><?php echo CHtml::link('Employee Type', array('/admin/employmentType/admin')); ?></li>  
                                        <li><?php echo CHtml::link('Ethnic Group', array('/admin/ethnicGroup/admin')); ?></li>   
                                        <li><?php echo CHtml::link('Department', array('/admin/department/admin')); ?></li>
                                        <li><?php echo CHtml::link('Religion', array('/admin/religion/admin')); ?></li>    
                                        <li><?php echo CHtml::link('Blood Type', array('/admin/bloodType/admin')); ?></li>
                                        <li><?php echo CHtml::link('Production Group', array('/admin/productionGroup/admin')); ?></li>
                                    <?php endif; ?>             
                                    
                                    <li style="font-weight: bold; text-decoration: underline">EMPLOYEE</li>
                                    <?php if (Yii::app()->user->checkAccess('hrgaCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Timesheet', array('/admin/employee/upload')); ?></li>
                                    <?php endif; ?>           
                                </ul>                        
                            </li>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('administrator')): ?> 
                            <li class="dropdown">          
                                <?php echo CHtml::link('User Profile', array('/admin/admin/admin')); ?>
                            </li>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('saleCreate') ||
                            Yii::app()->user->checkAccess('quotationCreate') ||
                            Yii::app()->user->checkAccess('statusReviewCreate')
                        ): ?>            
                            <li class="dropdown"> 
                                <?php echo CHtml::link('Customer Care Center', array('/site/page', 'view' => 'customer_care_center')); ?>
                                <ul> 
                                    <li style="font-weight: bold; text-decoration: underline">TRANSACTION</li>                            
                                    <?php if (Yii::app()->user->checkAccess('quotationCreate')): ?>    
                                        <li><?php echo CHtml::link('Quotation Order', array('/transaction/quotation/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('saleCreate')): ?>    
                                        <li><?php echo CHtml::link('Customer Order', array('/transaction/sale/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('statusReviewCreate')): ?> 
                                        <li><?php echo CHtml::link('Status Review', array('/transaction/statusReview/summary')); ?></li>
                                        <li><?php echo CHtml::link('Produksi Status Review', array('/manufacture/statusReview/summary')); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (Yii::app()->user->checkAccess('workOrderCreate') || 
                                Yii::app()->user->checkAccess('workOrderReplacementCreate') ||
                                Yii::app()->user->checkAccess('receiveCreate') ||
                                Yii::app()->user->checkAccess('stockCheck') ||
                                Yii::app()->user->checkAccess('inventoryCreateMaster')
                        ): ?> 
                            <li class="dropdown"> 
                                <?php echo CHtml::link('Inventory', array('/site/page', 'view' => 'inventory')); ?>
                                <ul> 
                                    <li style="font-weight: bold; text-decoration: underline">TRANSACTION</li>
                                    <?php if (Yii::app()->user->checkAccess('workOrderCreate')): ?>
                                        <li><?php echo CHtml::link('Monitoring Stok', array('/manufacture/workOrderCutting/saleOrderList')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('workOrderReplacementCreate')): ?>
                                        <li><?php echo CHtml::link('SPK Replacement', array('/manufacture/workOrderReplacement/qualityControlList')); ?></li>
                                    <?php endif; ?>                            
                                    <?php if (Yii::app()->user->checkAccess('receiveCreate')): ?>
                                        <li><?php echo CHtml::link('Penerimaan Material', array('/transaction/receive/create')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('stockCheck')): ?>
                                        <li><?php echo CHtml::link('Cek Stok', array('/transaction/stockCheck/summary')); ?></li>
                                        <li><?php echo CHtml::link('Update Lembaran', array('/transaction/stockCheck/adminReceive')); ?></li>
                                        <li><?php echo CHtml::link('Update Sipot', array('/transaction/stockCheck/adminCutting')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('inventoryCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Supplier Material', array('/admin/supplier/admin')); ?></li>
                                        <li><?php echo CHtml::link('Product Category', array('/admin/productCategory/admin')); ?></li>  
                                        <li><?php echo CHtml::link('Location', array('/admin/location/admin')); ?></li>
                                        <li><?php echo CHtml::link('Material', array('/admin/item/admin')); ?></li>
                                    <?php endif; ?>   
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('ppcCuttingCreate') || 
                            Yii::app()->user->checkAccess('poCuttingCreate') || 
                            Yii::app()->user->checkAccess('qcCuttingCreate') || 
                            Yii::app()->user->checkAccess('ppcMilingCreate') || 
                            Yii::app()->user->checkAccess('poMilingCreate') || 
                            Yii::app()->user->checkAccess('qcMilingCreate') ||
                            Yii::app()->user->checkAccess('productionCreateMaster')
                        ): ?> 
                            <li class="dropdown">  
                                <?php echo CHtml::link('Production', array('/site/page', 'view' => 'production')); ?>
                                <ul> 
                                    <li style="font-weight: bold; text-decoration: underline">POTONG</li>                            
                                    <?php if (Yii::app()->user->checkAccess('ppcCuttingCreate')): ?>
                                        <li><?php echo CHtml::link('Production and Planning Control (PPC)', array('/manufacture/productionPlanningCutting/workOrderList')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('poCuttingCreate')): ?>
                                        <li><?php echo CHtml::link('Production Output', array('/manufacture/productionCutting/productionPlanningList')); ?></li>
                                    <?php endif; ?>
                                        
                                    <li style="font-weight: bold; text-decoration: underline">MILING</li>
                                    <?php if (Yii::app()->user->checkAccess('ppcMilingCreate')): ?>
                                        <li><?php echo CHtml::link('Production and Planning Control (PPC)', array('/manufacture/productionPlanningMiling/workOrderList')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('poMilingCreate')): ?>
                                        <li><?php echo CHtml::link('Production Output', array('/manufacture/productionMiling/productionPlanningList')); ?></li>
                                    <?php endif; ?>
                                        
                                    <li style="font-weight: bold; text-decoration: underline">QUALITY CONTROL</li>
                                    <?php if (Yii::app()->user->checkAccess('qcCuttingCreate')): ?>
                                        <li><?php echo CHtml::link('Quality Control Cutting', array('/manufacture/qualityControlCutting/productionCuttingList')); ?></li>
                                    <?php endif; ?> 
                                    <?php if (Yii::app()->user->checkAccess('qcMilingCreate')): ?>
                                        <li><?php echo CHtml::link('Quality Control Miling', array('/manufacture/qualityControlMiling/productionMilingList')); ?></li>
                                    <?php endif; ?>

                                    <li style="font-weight: bold; text-decoration: underline">PRODUCTION</li>
                                    <?php if (Yii::app()->user->checkAccess('productionCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Employee Production', array('*')); ?></li>
                                        <li><?php echo CHtml::link('Machine', array('/admin/machine/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('statusReviewCreate')): ?> 
                                        <li><?php echo CHtml::link('Produksi Status Review', array('/manufacture/statusReview/summary')); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </li>     
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('deliveryCreate') ||
                            Yii::app()->user->checkAccess('saleInvoiceCreate') ||
                            Yii::app()->user->checkAccess('saleReceiptCreate') ||
                            Yii::app()->user->checkAccess('salePaymentCreate') ||
                            Yii::app()->user->checkAccess('purchaseCreate') ||
                            Yii::app()->user->checkAccess('purchaseItemCreate') ||
                            Yii::app()->user->checkAccess('receiveItemCreate') ||
                            Yii::app()->user->checkAccess('purchaseInvoiceCreate') ||
                            Yii::app()->user->checkAccess('purchaseReceiptCreate') ||
                            Yii::app()->user->checkAccess('purchasePaymentCreate') ||
                            Yii::app()->user->checkAccess('purchaseCreateMaster') ||
                            Yii::app()->user->checkAccess('accountingCreateMaster') ||
                            Yii::app()->user->checkAccess('eFakturCreate') ||
                            Yii::app()->user->checkAccess('depositCreate') ||
                            Yii::app()->user->checkAccess('expenseCreate')
                        ): ?> 
                            <li class="dropdown"> 
                                <?php echo CHtml::link('Finance/Accounting', array('/site/page', 'view' => 'accounting')); ?>
                                <ul>
                                    <li style="font-weight: bold; text-decoration: underline">ACCOUNTING</li>  
                                    <?php if (Yii::app()->user->checkAccess('deliveryCreate')): ?>
                                        <li><?php echo CHtml::link('Surat Jalan', array('/transaction/delivery/qualityControlList')); ?></li>
                                        <li><?php echo CHtml::link('SJ Manual', array('/transaction/manualDelivery/workOrderList')); ?></li>
                                        <li><?php echo CHtml::link('SJ Manual 2', array('/transaction/deliveryBackup/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('saleInvoiceCreate')): ?>
                                        <li><?php echo CHtml::link('Invoice Customer', array('/accounting/saleInvoice/workOrderList')); ?></li>
                                        <li><?php echo CHtml::link('Invoice Manual', array('/accounting/manualSaleInvoice/admin')); ?></li>
                                        <li><?php echo CHtml::link('Penjualan Manual INV', array('/accounting/materialInvoice/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('saleReceiptCreate')): ?>
                                        <li><?php echo CHtml::link('Tanda Terima Penjualan', array('/accounting/saleReceipt/admin')); ?></li>
                                        <li><?php echo CHtml::link('Tanda Terima Penjualan Manual', array('/accounting/manualSaleReceipt/admin')); ?></li>
                                        <li><?php echo CHtml::link('Tanda Terima Penjualan Manual 2', array('/accounting/materialReceipt/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('saleInvoiceCreate')): ?>
                                        <li><?php echo CHtml::link('e-Faktur Invoice', array('/accounting/saleInvoice/admin')); ?></li>
                                        <li><?php echo CHtml::link('e-Faktur Invoice Manual', array('/accounting/manualSaleInvoice/admin')); ?></li>
                                        <li><?php echo CHtml::link('e-Faktur Invoice Manual 2', array('/accounting/materialInvoice/admin')); ?></li>
                                    <?php endif; ?>
                                        
                                    <li style="font-weight: bold; text-decoration: underline">PURCHASE</li>
                                    <?php if (Yii::app()->user->checkAccess('purchaseCreate')): ?>
                                        <li><?php echo CHtml::link('Purchase Order Material', array('/transaction/purchase/admin')); ?></li> 
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('purchaseItemCreate')): ?>
                                        <li><?php echo CHtml::link('PO Barang Penunjang', array('/transaction/purchaseItem/admin')); ?></li> 
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('receiveItemCreate')): ?>
                                        <li><?php echo CHtml::link('Penerimaan Barang Penunjang', array('/transaction/receiveItem/admin')); ?></li> 
                                    <?php endif; ?>                            
                                    <?php if (Yii::app()->user->checkAccess('accountingCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Supplier', array('/admin/supplier/admin')); ?></li>
                                    <?php endif; ?>

                                    <li style="font-weight: bold; text-decoration: underline">FINANCE</li>
                                    <?php if (Yii::app()->user->checkAccess('salePaymentCreate')): ?>
                                        <li><?php echo CHtml::link('Pelunasan Customer', array('/accounting/salePayment/admin')); ?></li>
                                        <li><?php echo CHtml::link('Pelunasan Manual', array('/accounting/manualSalePayment/admin')); ?></li>
                                        <li><?php echo CHtml::link('Pelunasan Manual 2', array('/accounting/materialPayment/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('purchaseInvoiceCreate')): ?>
                                        <li><?php echo CHtml::link('Invoice Supplier', array('/accounting/purchaseInvoice/receiveList')); ?></li> 
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('purchaseReceiptCreate')): ?>
                                        <li><?php echo CHtml::link('Tanda Terima Pembelian', array('/accounting/purchaseReceipt/admin')); ?></li> 
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('purchasePaymentCreate')): ?>
                                        <li><?php echo CHtml::link('Pelunasan Supplier', array('/accounting/purchasePayment/admin')); ?></li> 
                                    <?php endif; ?>

                                    <li style="font-weight: bold; text-decoration: underline">GENERAL</li>
                                    <?php if (Yii::app()->user->checkAccess('accountingCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Customer', array('/admin/customer/admin')); ?></li>
                                        <li><?php echo CHtml::link('Gudang', array('/admin/warehouse/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('expenseCreate')): ?>
                                        <li><?php echo CHtml::link('Pengeluaran Kas / Bank', array('/accounting/expense/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('depositCreate')): ?>
                                        <li><?php echo CHtml::link('Penerimaan Kas / Bank', array('/accounting/deposit/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('journalVoucherCreate')): ?>
                                        <li><?php echo CHtml::link('Jurnal Umum', array('/accounting/journalVoucher/admin')); ?></li>
                                    <?php endif; ?>
                                    <?php if (Yii::app()->user->checkAccess('purchaseCreateMaster')): ?>
                                        <li><?php echo CHtml::link('Item', array('/admin/item/admin')); ?></li>
                                        <li><?php echo CHtml::link('Supplier Non Material', array('*')); ?></li>
                                        <li><?php echo CHtml::link('Item Category', array('/admin/itemCategory/admin')); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if (Yii::app()->user->checkAccess('purchaseInvoiceReport')
                            || Yii::app()->user->checkAccess('saleInvoiceReport')
                            || Yii::app()->user->checkAccess('depositReport')
                            || Yii::app()->user->checkAccess('expenseReport')
                            || Yii::app()->user->checkAccess('workOrderReport')
                            || Yii::app()->user->checkAccess('purchaseReport')
                            || Yii::app()->user->checkAccess('receiveReport')
                            || Yii::app()->user->checkAccess('quotationReport')
                            || Yii::app()->user->checkAccess('saleReport')
                            || Yii::app()->user->checkAccess('deliveryReport')
                            || Yii::app()->user->checkAccess('accounting')
                            || Yii::app()->user->checkAccess('ppcCuttingReport')
                            || Yii::app()->user->checkAccess('ppcMilingReport')
                            || Yii::app()->user->checkAccess('poCuttingReport')
                            || Yii::app()->user->checkAccess('poMilingReport')
                            || Yii::app()->user->checkAccess('qcCuttingReport')
                            || Yii::app()->user->checkAccess('qcMilingReport')
                        ):?> 
                            <li class="dropdown">
                                <?php echo CHtml::link('Report', array('/site/page', 'view' => 'report')); ?>
                            </li>
                        <?php endif; ?>

                <li class="dropdown">                
                    <?php if (Yii::app()->user->isGuest): ?>
                    <?php echo CHtml::link('Login', array('/site/login'));?>
                    <?php endif; ?>
                </li>              
                </ul>  
                 <!--            For Logout-->
                 <div class="nav-right">
                    <?php if (!Yii::app()->user->isGuest): ?>
                        <?php echo CHtml::link('Logout (' . Yii::app()->user->name . ')', array('/site/logout')); ?>
                    <?php endif; ?> 
                 </div>
                </nav>
            </div><!-- header -->

        <?php if (isset($this->breadcrumbs)): ?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links' => $this->breadcrumbs,
            )); ?><!-- breadcrumbs -->
        <?php endif ?>

        <?php echo $content; ?>

        <div class="clear"></div>

        <div id="footer">
            Copyright &copy; <?php echo date('Y'); ?> by PT. Sinar Putra Metalindo. All Rights Reserved.<br/>
            Powered by <?php echo CHtml::link('BloomingTech', 'http://www.bloomingtech.com'); ?>
        </div><!-- footer -->

    </div><!-- page -->

</body>
</html>


