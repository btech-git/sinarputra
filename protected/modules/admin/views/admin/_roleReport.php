<table>
    <tr>
        <th style="text-align: center; width: 50%">Customer Care Center</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Quotation Order</td>
        <td style="text-align: center">
            <?php //echo $counter; ?>
            <?php echo CHtml::checkBox("Admin[roles][quotationReportView]", CHtml::resolveValue($model, "roles[quotationReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'quotationReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Sales Marketing</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Omzet Penjualan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleMarketingReportView]", CHtml::resolveValue($model, "roles[saleMarketingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleMarketingReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Inventory</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Penerimaan Material</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveMaterialReportView]", CHtml::resolveValue($model, "roles[receiveMaterialReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveMaterialReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>SPK</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderReportView]", CHtml::resolveValue($model, "roles[workOrderReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Production Potong</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Production Planning Cutting</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][productionPlanningCuttingReportView]", CHtml::resolveValue($model, "roles[productionPlanningCuttingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'productionPlanningCuttingReportView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Perencanaan Proses Produksi</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][productionOutstandingCuttingReportView]", CHtml::resolveValue($model, "roles[productionOutstandingCuttingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'productionOutstandingCuttingReportView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Production Cutting Output</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][productionCuttingReportView]", CHtml::resolveValue($model, "roles[productionCuttingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'productionCuttingReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Production Miling</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Production and Planning Control Miling</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][productionPlanningMilingReportView]", CHtml::resolveValue($model, "roles[productionPlanningMilingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'productionPlanningMilingReportView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Production Output Miling</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][productionMilingReportView]", CHtml::resolveValue($model, "roles[productionMilingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'productionMilingReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Quality Control</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Quality Control Cutting</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qualityControlCuttingReportView]", CHtml::resolveValue($model, "roles[qualityControlCuttingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qualityControlCuttingReportView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Quality Control Miling</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qualityControlMilingReportView]", CHtml::resolveValue($model, "roles[qualityControlMilingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qualityControlMilingReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Sales</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Pengiriman</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][deliveryReportView]", CHtml::resolveValue($model, "roles[deliveryReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'deliveryReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Faktur Penjualan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleInvoiceReportView]", CHtml::resolveValue($model, "roles[saleInvoiceReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleInvoiceReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Tanda Terima Penjualan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleReceiptReportView]", CHtml::resolveValue($model, "roles[saleReceiptReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleReceiptReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Purchase</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Pembelian</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseReportView]", CHtml::resolveValue($model, "roles[purchaseReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Penerimaan Material / Item</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveReportView]", CHtml::resolveValue($model, "roles[receiveReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Faktur Pembelian</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseInvoiceReportView]", CHtml::resolveValue($model, "roles[purchaseInvoiceReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseInvoiceReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr>
        <th style="text-align: center; width: 50%">Finance</th>
        <th style="text-align: center"></th>
    </tr>
    <tr>
        <td>Tanda Terima Pembelian</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseReceiptReportView]", CHtml::resolveValue($model, "roles[purchaseReceiptReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseReceiptReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Pembayaran Pembelian</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchasePaymentReportView]", CHtml::resolveValue($model, "roles[purchasePaymentReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchasePaymentReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Pelunasan Piutang</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][salePaymentReportView]", CHtml::resolveValue($model, "roles[salePaymentReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'salePaymentReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Outstanding Customer</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receivableCustomerReportView]", CHtml::resolveValue($model, "roles[receivableCustomerReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receivableCustomerReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Pengeluaran Kas / Bank</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][expenseReportView]", CHtml::resolveValue($model, "roles[expenseReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'expenseReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Penerimaan Kas / Bank</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][depositReportView]", CHtml::resolveValue($model, "roles[depositReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'depositReportView'
            )); ?>
        </td>
    </tr>
    
    <tr>
        <td>Kas / Bank</td>
        <td style="text-align: center">
            <?php //echo $counter; ?>
            <?php echo CHtml::checkBox("Admin[roles][accountingReportView]", CHtml::resolveValue($model, "roles[accountingReportView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'accountingReportView'
            )); ?>
        </td>
    </tr>
</table>
