<table>
    <tr>
        <th style="text-align: center; width: 50%">Customer Care Center</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Quotation Order</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][quotationCreate]", CHtml::resolveValue($model, "roles[quotationCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'quotationCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][quotationEdit]", CHtml::resolveValue($model, "roles[quotationEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'quotationEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][quotationView]", CHtml::resolveValue($model, "roles[quotationView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'quotationView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Customer Order</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleCreate]", CHtml::resolveValue($model, "roles[saleCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleEdit]", CHtml::resolveValue($model, "roles[saleEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][saleView]", CHtml::resolveValue($model, "roles[saleView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'saleView'
            )); ?>
        </td>
    </tr>	
    <tr>
        <td>Status Review</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][statusReviewCreate]", CHtml::resolveValue($model, "roles[statusReviewCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'statusReviewCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][statusReviewEdit]", CHtml::resolveValue($model, "roles[statusReviewEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'statusReviewEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][statusReviewView]", CHtml::resolveValue($model, "roles[statusReviewView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'statusReviewView'
            )); ?>
        </td>
    </tr>
</table>

<table>
    <tr>
        <th style="text-align: center; width: 50%">Inventory</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Monitoring Stok</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderCreate]", CHtml::resolveValue($model, "roles[workOrderCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderEdit]", CHtml::resolveValue($model, "roles[workOrderEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderView]", CHtml::resolveValue($model, "roles[workOrderView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>SPK Replacement</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderReplacementCreate]", CHtml::resolveValue($model, "roles[workOrderReplacementCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderReplacementCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderReplacementEdit]", CHtml::resolveValue($model, "roles[workOrderReplacementEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderReplacementEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][workOrderReplacementView]", CHtml::resolveValue($model, "roles[workOrderReplacementView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'workOrderReplacementView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Penerimaan Material</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveCreate]", CHtml::resolveValue($model, "roles[receiveCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveEdit]", CHtml::resolveValue($model, "roles[receiveEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveView]", CHtml::resolveValue($model, "roles[receiveView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Cek Stok</td>
        <td style="text-align: center">&nbsp;</td>
        <td style="text-align: center">&nbsp;</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][stockCheckView]", CHtml::resolveValue($model, "roles[stockCheckView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'stockCheckView'
            )); ?>
        </td>
    </tr>
</table>

<table>
    <tr>
        <th style="text-align: center; width: 50%">Production</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Production and Planning Control Cutting</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][ppcCuttingCreate]", CHtml::resolveValue($model, "roles[ppcCuttingCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'ppcCuttingCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][ppcCuttingEdit]", CHtml::resolveValue($model, "roles[ppcCuttingEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'ppcCuttingEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][ppcCuttingView]", CHtml::resolveValue($model, "roles[ppcCuttingView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'ppcCuttingView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Production Output Cutting</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][poCuttingCreate]", CHtml::resolveValue($model, "roles[poCuttingCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'poCuttingCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][poCuttingEdit]", CHtml::resolveValue($model, "roles[poCuttingEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'poCuttingEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][poCuttingView]", CHtml::resolveValue($model, "roles[poCuttingView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'poCuttingView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Production and Planning Control Milling</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][ppcMilingCreate]", CHtml::resolveValue($model, "roles[ppcMilingCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'ppcMilingCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][ppcMilingEdit]", CHtml::resolveValue($model, "roles[ppcMilingEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'ppcMilingEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][ppcMilingView]", CHtml::resolveValue($model, "roles[ppcMilingView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'ppcMilingView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Production Output Milling</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][poMilingCreate]", CHtml::resolveValue($model, "roles[poMilingCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'poMilingCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][poMilingEdit]", CHtml::resolveValue($model, "roles[poMilingEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'poMilingEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][poMilingView]", CHtml::resolveValue($model, "roles[poMilingView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'poMilingView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Quality Control Cutting</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qcCuttingCreate]", CHtml::resolveValue($model, "roles[qcCuttingCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qcCuttingCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qcCuttingEdit]", CHtml::resolveValue($model, "roles[qcCuttingEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qcCuttingEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qcCuttingView]", CHtml::resolveValue($model, "roles[qcCuttingView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qcCuttingView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Quality Control Milling</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qcMilingCreate]", CHtml::resolveValue($model, "roles[qcMilingCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qcMilingCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qcMilingEdit]", CHtml::resolveValue($model, "roles[qcMilingEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qcMilingEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][qcMilingView]", CHtml::resolveValue($model, "roles[qcMilingView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'qcMilingView'
            )); ?>
        </td>
    </tr>
</table>

<table>
    <tr>
        <th style="text-align: center; width: 50%">Purchasing</th>
        <th style="text-align: center">Create</th>
        <th style="text-align: center">Edit</th>
        <th style="text-align: center">View</th>
    </tr>
    <tr>
        <td>Purchase Order Material</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseCreate]", CHtml::resolveValue($model, "roles[purchaseCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseEdit]", CHtml::resolveValue($model, "roles[purchaseEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseView]", CHtml::resolveValue($model, "roles[purchaseView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>PO Barang Penunjang</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseItemCreate]", CHtml::resolveValue($model, "roles[purchaseItemCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseItemCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseItemEdit]", CHtml::resolveValue($model, "roles[purchaseItemEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseItemEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][purchaseItemView]", CHtml::resolveValue($model, "roles[purchaseItemView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'purchaseItemView'
            )); ?>
        </td>
    </tr>
    <tr>
        <td>Penerimaan Barang Penunjang</td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveItemCreate]", CHtml::resolveValue($model, "roles[receiveItemCreate]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveItemCreate'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveItemEdit]", CHtml::resolveValue($model, "roles[receiveItemEdit]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveItemEdit'
            )); ?>
        </td>
        <td style="text-align: center">
            <?php echo CHtml::checkBox("Admin[roles][receiveItemView]", CHtml::resolveValue($model, "roles[receiveItemView]"), array(
                'id' => 'Admin_roles_' . $counter++, 
                'value' => 'receiveItemView'
            )); ?>
        </td>
    </tr>
</table>
