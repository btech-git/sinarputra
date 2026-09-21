<table>
    <tr>
        <th style="text-align: center; width: 50%">Main</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>COA</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterAccountCreate]", CHtml::resolveValue($model, "roles[masterAccountCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterAccountCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterAccountEdit]", CHtml::resolveValue($model, "roles[masterAccountEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterAccountEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterAccountView]", CHtml::resolveValue($model, "roles[masterAccountView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterAccountView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Customer</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterCustomerCreate]", CHtml::resolveValue($model, "roles[masterCustomerCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterCustomerCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterCustomerEdit]", CHtml::resolveValue($model, "roles[masterCustomerEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterCustomerEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterCustomerView]", CHtml::resolveValue($model, "roles[masterCustomerView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterCustomerView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Supplier</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterSupplierCreate]", CHtml::resolveValue($model, "roles[masterSupplierCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterSupplierCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterSupplierEdit]", CHtml::resolveValue($model, "roles[masterSupplierEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterSupplierEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterSupplierView]", CHtml::resolveValue($model, "roles[masterSupplierView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterSupplierView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Karyawan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeCreate]", CHtml::resolveValue($model, "roles[masterEmployeeCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeEdit]", CHtml::resolveValue($model, "roles[masterEmployeeEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeView]", CHtml::resolveValue($model, "roles[masterEmployeeView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Item Penunjang</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterItemCreate]", CHtml::resolveValue($model, "roles[masterItemCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterItemCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterItemEdit]", CHtml::resolveValue($model, "roles[masterItemEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterItemEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterItemView]", CHtml::resolveValue($model, "roles[masterItemView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterItemView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Gudang</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterWarehouseCreate]", CHtml::resolveValue($model, "roles[masterWarehouseCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterWarehouseCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterWarehouseEdit]", CHtml::resolveValue($model, "roles[masterWarehouseEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterWarehouseEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterWarehouseView]", CHtml::resolveValue($model, "roles[masterWarehouseView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterWarehouseView'
            )); ?>
        </td>
    </tr>	
    <tr>
        <td>Lokasi Stok Material</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterLocationCreate]", CHtml::resolveValue($model, "roles[masterLocationCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterLocationCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterLocationEdit]", CHtml::resolveValue($model, "roles[masterLocationEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterLocationEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterLocationView]", CHtml::resolveValue($model, "roles[masterLocationView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterLocationView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Mesin</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMachineCreate]", CHtml::resolveValue($model, "roles[masterMachineCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMachineCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMachineEdit]", CHtml::resolveValue($model, "roles[masterMachineEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMachineEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMachineView]", CHtml::resolveValue($model, "roles[masterMachineView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMachineView'
            )); ?>
        </td>
    </tr>
    <tr>
        <th style="text-align: center; width: 50%">Sub Main</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>COA Category</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterAccountCategoryCreate]", CHtml::resolveValue($model, "roles[masterAccountCategoryCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterAccountCategoryCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterAccountCategoryEdit]", CHtml::resolveValue($model, "roles[masterAccountCategoryEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterAccountCategoryEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterAccountCategoryView]", CHtml::resolveValue($model, "roles[masterAccountCategoryView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterAccountCategoryView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Employee Department</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeDepartmentCreate]", CHtml::resolveValue($model, "roles[masterEmployeeDepartmentCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeDepartmentCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeDepartmentEdit]", CHtml::resolveValue($model, "roles[masterEmployeeDepartmentEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeDepartmentEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeDepartmentView]", CHtml::resolveValue($model, "roles[masterEmployeeDepartmentView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeDepartmentView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Employee Division</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeDivisionCreate]", CHtml::resolveValue($model, "roles[masterEmployeeDivisionCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeDivisionCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeDivisionEdit]", CHtml::resolveValue($model, "roles[masterEmployeeDivisionEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeDivisionEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeDivisionView]", CHtml::resolveValue($model, "roles[masterEmployeeDivisionView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeDivisionView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Employee Category</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeCategoryCreate]", CHtml::resolveValue($model, "roles[masterEmployeeCategoryCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeCategoryCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeCategoryEdit]", CHtml::resolveValue($model, "roles[masterEmployeeCategoryEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeCategoryEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterEmployeeCategoryView]", CHtml::resolveValue($model, "roles[masterEmployeeCategoryView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterEmployeeCategoryView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Kategori Item Penunjang</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterItemCategoryCreate]", CHtml::resolveValue($model, "roles[masterItemCategoryCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterItemCategoryCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterItemCategoryEdit]", CHtml::resolveValue($model, "roles[masterItemCategoryEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterItemCategoryEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterItemCategoryView]", CHtml::resolveValue($model, "roles[masterItemCategoryView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterItemCategoryView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Jenis Mesin</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMachineTypeCreate]", CHtml::resolveValue($model, "roles[masterMachineTypeCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMachineTypeCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMachineTypeEdit]", CHtml::resolveValue($model, "roles[masterMachineTypeEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMachineTypeEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMachineTypeView]", CHtml::resolveValue($model, "roles[masterMachineTypeView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMachineTypeView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Jenis Pembayaran</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterPaymentTypeCreate]", CHtml::resolveValue($model, "roles[masterPaymentTypeCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterPaymentTypeCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterPaymentTypeEdit]", CHtml::resolveValue($model, "roles[masterPaymentTypeEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterPaymentTypeEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterPaymentTypeView]", CHtml::resolveValue($model, "roles[masterPaymentTypeView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterPaymentTypeView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Kategori Material</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMaterialCategoryCreate]", CHtml::resolveValue($model, "roles[masterMaterialCategoryCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMaterialCategoryCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMaterialCategoryEdit]", CHtml::resolveValue($model, "roles[masterMaterialCategoryEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMaterialCategoryEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMaterialCategoryView]", CHtml::resolveValue($model, "roles[masterMaterialCategoryView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMaterialCategoryView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Ukuran Material</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMaterialSizeCreate]", CHtml::resolveValue($model, "roles[masterMaterialSizeCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMaterialSizeCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMaterialSizeEdit]", CHtml::resolveValue($model, "roles[masterMaterialSizeEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMaterialSizeEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterMaterialSizeView]", CHtml::resolveValue($model, "roles[masterMaterialSizeView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterMaterialSizeView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Satuan</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterUnitCreate]", CHtml::resolveValue($model, "roles[masterUnitCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterUnitCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterUnitEdit]", CHtml::resolveValue($model, "roles[masterUnitEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterUnitEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][masterUnitView]", CHtml::resolveValue($model, "roles[masterUnitView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'masterUnitView'
            )); ?>
        </td>
    </tr>
</table>