<div>
    <table>
        <tr>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][administrator]", CHtml::resolveValue($model, "roles[administrator]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'administrator')); ?>
                <?php echo CHtml::label('Administrator', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][master]", CHtml::resolveValue($model, "roles[master]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'master')); ?>
                <?php echo CHtml::label('Master', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][customerCare]", CHtml::resolveValue($model, "roles[customerCare]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'customerCare')); ?>
                <?php echo CHtml::label('All Customer Care Center', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][inventory]", CHtml::resolveValue($model, "roles[inventory]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'inventory')); ?>
                <?php echo CHtml::label('All Inventory', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][production]", CHtml::resolveValue($model, "roles[production]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'production')); ?>
                <?php echo CHtml::label('All Production', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][accounting]", CHtml::resolveValue($model, "roles[accounting]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'accounting')); ?>
                <?php echo CHtml::label('All Accounting', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][purchase]", CHtml::resolveValue($model, "roles[purchase]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'purchase')); ?>
                <?php echo CHtml::label('All Purchasing', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td>
                <?php echo CHtml::checkBox("Admin[roles][finance]", CHtml::resolveValue($model, "roles[finance]"), array('id' => 'Admin_roles_' . $counter, 'value' => 'finance')); ?>
                <?php echo CHtml::label('All Finance', 'Admin_roles_' . $counter++, array('style' => 'display: inline')); ?>
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
                    'counter' => $counter+6,
                ), true),
            ),
            'Report' => array(
                'content' => $this->renderPartial('_roleReport', array(
                    'model' => $model, 
                    'counter' => $counter+39,
                ), true),
            ),
            'Master' => array(
                'content' => $this->renderPartial('_roleMaster', array(
                    'model' => $model, 
                    'counter' => $counter+82,
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