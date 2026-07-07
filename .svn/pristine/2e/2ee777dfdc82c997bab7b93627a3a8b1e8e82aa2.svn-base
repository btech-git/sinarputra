<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($workOrderCuttingDetailMaterial, 'error'); ?>

    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Serial Number', ''); ?>
                <?php echo CHtml::activeTextField($workOrderCuttingDetailMaterial, 'serial_number'); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'serial_number'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Grade', ''); ?>
                <?php echo CHtml::activeTextField($workOrderCuttingDetailMaterial, 'product_name'); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'product_name'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Kategori', ''); ?>
                <?php echo CHtml::encode(CHtml::value($workOrderCuttingDetailMaterial, 'productCategory.name')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Tebal', ''); ?>
                <?php echo CHtml::activeTextField($workOrderCuttingDetailMaterial, 'height', array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetCuttingWeight', array('id' => $workOrderCuttingDetailMaterial->id)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($workOrderCuttingDetailMaterial, "weight") . '").val(data.weight);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'height'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Lebar', ''); ?>
                <?php echo CHtml::activeTextField($workOrderCuttingDetailMaterial, 'width', array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetCuttingWeight', array('id' => $workOrderCuttingDetailMaterial->id)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($workOrderCuttingDetailMaterial, "weight") . '").val(data.weight);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'width'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Panjang', ''); ?>
                <?php echo CHtml::activeTextField($workOrderCuttingDetailMaterial, 'length', array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetCuttingWeight', array('id' => $workOrderCuttingDetailMaterial->id)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($workOrderCuttingDetailMaterial, "weight") . '").val(data.weight);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'length'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Berat', ''); ?>
                <?php echo CHtml::activeTextField($workOrderCuttingDetailMaterial, 'weight', array('readOnly' => true)); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'weight'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Lokasi', ''); ?>
                <?php echo CHtml::activeDropDownList($workOrderCuttingDetailMaterial, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Location-'
                )); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'weight'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Status', ''); ?>
                    <?php echo CHtml::activeDropDownList($workOrderCuttingDetailMaterial, 'is_inactive', array(
                        ActiveRecord::ACTIVE => 'Active', 
                        ActiveRecord::INACTIVE => 'Inactive'
                    )); ?>
                <?php echo CHtml::error($workOrderCuttingDetailMaterial, 'is_inactive'); ?>
            </div>
        </div>

    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
