<div>
    <table>
        <tr>
            <td colspan="3" style="text-align: center">
            <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("Admin[roles][administrator]", CHtml::resolveValue($model, "roles[administrator]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'administrator'
                )); ?>
                <?php echo CHtml::label('ADMINISTRATOR', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][customerCareHead]", CHtml::resolveValue($model, "roles[customerCareHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'customerCareHead'
                )); ?>
                <?php echo CHtml::label('All Customer Care Center', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][inventoryHead]", CHtml::resolveValue($model, "roles[inventoryHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'inventoryHead'
                )); ?>
                <?php echo CHtml::label('All Inventory', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][productionHead]", CHtml::resolveValue($model, "roles[productionHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'productionHead'
                )); ?>
                <?php echo CHtml::label('All Production', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][purchaseHead]", CHtml::resolveValue($model, "roles[purchaseHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'purchaseHead'
                )); ?>
                <?php echo CHtml::label('All Purchasing', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][accountingHead]", CHtml::resolveValue($model, "roles[accountingHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'accounting'
                )); ?>
                <?php echo CHtml::label('All Accounting', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][financeHead]", CHtml::resolveValue($model, "roles[financeHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'financeHead'
                )); ?>
                <?php echo CHtml::label('All Finance', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][reportHead]", CHtml::resolveValue($model, "roles[reportHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'reportHead'
                )); ?>
                <?php echo CHtml::label('All Report', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][masterMainHead]", CHtml::resolveValue($model, "roles[masterMainHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'masterMainHead'
                )); ?>
                <?php echo CHtml::label('All Master Main', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
            <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("Admin[roles][masterSubHead]", CHtml::resolveValue($model, "roles[masterSubHead]"), array(
                    'id' => 'Admin_roles_' . $counter, 
                    'value' => 'masterSubHead'
                )); ?>
                <?php echo CHtml::label('All Master Sub Main', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
        </tr>
    </table>
</div>

<div>
    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
        'tabs' => array(
            'Transaction' => array(
                'content' => $this->renderPartial('_roleTransaction', array(
                    'model' => $model, 
                    'counter' => $counter,
                ), true),
            ),
            'Accounting/Finance' => array(
                'content' => $this->renderPartial('_roleAccounting', array(
                    'model' => $model, 
                    'counter' => $counter+35,
                ), true),
            ),
            'Report' => array(
                'content' => $this->renderPartial('_roleReport', array(
                    'model' => $model, 
                    'counter' => $counter+75,
                ), true),
            ),
            'Master' => array(
                'content' => $this->renderPartial('_roleMaster', array(
                    'model' => $model, 
                    'counter' => $counter+99,
                ), true),
            ),
        ),
        // additional javascript options for the tabs plugin
        'options' => array(
            'collapsible' => true,
        ),
        // set id for this widgets
        'id' => 'view_tab_transaction',
    )); ?>
</div>