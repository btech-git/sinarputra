
<table>
    <tr>
        <th style="text-align: center; width: 50%">Accounting</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Surat Jalan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][deliveryCreate]", CHtml::resolveValue($model, "roles[deliveryCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'deliveryCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][deliveryEdit]", CHtml::resolveValue($model, "roles[deliveryEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'deliveryEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][deliveryView]", CHtml::resolveValue($model, "roles[deliveryView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'deliveryView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Invoice Customer</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleInvoiceCreate]", CHtml::resolveValue($model, "roles[saleInvoiceCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleInvoiceCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleInvoiceEdit]", CHtml::resolveValue($model, "roles[saleInvoiceEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleInvoiceEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleInvoiceView]", CHtml::resolveValue($model, "roles[saleInvoiceView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleInvoiceView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Tanda Terima Penjualan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleReceiptCreate]", CHtml::resolveValue($model, "roles[saleReceiptCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleReceiptCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleReceiptEdit]", CHtml::resolveValue($model, "roles[saleReceiptEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleReceiptEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleReceiptView]", CHtml::resolveValue($model, "roles[saleReceiptView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleReceiptView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>e-Faktur</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][eFakturCreate]", CHtml::resolveValue($model, "roles[eFakturCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'eFakturCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][eFakturEdit]", CHtml::resolveValue($model, "roles[eFakturEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'eFakturEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][eFakturView]", CHtml::resolveValue($model, "roles[eFakturView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'eFakturView'
            )); ?>
        </td>
    </tr>
</table>

<table>
    <tr>
        <th style="text-align: center; width: 50%">Finance</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Pelunasan Customer</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][salePaymentCreate]", CHtml::resolveValue($model, "roles[salePaymentCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'salePaymentCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][salePaymentEdit]", CHtml::resolveValue($model, "roles[salePaymentEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'salePaymentEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][salePaymentView]", CHtml::resolveValue($model, "roles[salePaymentView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'salePaymentView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Invoice Supplier</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseInvoiceCreate]", CHtml::resolveValue($model, "roles[purchaseInvoiceCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseInvoiceCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseInvoiceEdit]", CHtml::resolveValue($model, "roles[purchaseInvoiceEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseInvoiceEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseInvoiceView]", CHtml::resolveValue($model, "roles[purchaseInvoiceView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseInvoiceView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Tanda Terima Pembelian</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseReceiptCreate]", CHtml::resolveValue($model, "roles[purchaseReceiptCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseReceiptCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseReceiptEdit]", CHtml::resolveValue($model, "roles[purchaseReceiptEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseReceiptEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseReceiptView]", CHtml::resolveValue($model, "roles[purchaseReceiptView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseReceiptView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Pelunasan Supplier</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchasePaymentCreate]", CHtml::resolveValue($model, "roles[purchasePaymentCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchasePaymentCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchasePaymentEdit]", CHtml::resolveValue($model, "roles[purchasePaymentEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchasePaymentEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchasePaymentView]", CHtml::resolveValue($model, "roles[purchasePaymentView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchasePaymentView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Pengeluaran Kas / Bank</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][expenseCreate]", CHtml::resolveValue($model, "roles[expenseCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'expenseCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][expenseEdit]", CHtml::resolveValue($model, "roles[expenseEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'expenseEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][expenseView]", CHtml::resolveValue($model, "roles[expenseView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'expenseView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Penerimaan Kas / Bank</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][depositCreate]", CHtml::resolveValue($model, "roles[depositCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'depositCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][depositEdit]", CHtml::resolveValue($model, "roles[depositEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'depositEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][depositView]", CHtml::resolveValue($model, "roles[depositView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'depositView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Jurnal Umum</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][journalVoucherCreate]", CHtml::resolveValue($model, "roles[journalVoucherCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'journalVoucherCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][journalVoucherEdit]", CHtml::resolveValue($model, "roles[journalVoucherEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'journalVoucherEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][journalVoucherView]", CHtml::resolveValue($model, "roles[journalVoucherView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'journalVoucherView'
            )); ?>
        </td>
    </tr>
</table>