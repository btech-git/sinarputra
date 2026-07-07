<div class="form">

    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($receiveDetail, 'error'); ?>

    <div class="container">
        <div class="span-12">
            <div class="row">
                <?php echo CHtml::label('Serial Number', ''); ?>
                <?php echo CHtml::activeTextField($receiveDetail, 'serial_number'); ?>
                <?php echo CHtml::error($receiveDetail, 'serial_number'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Grade', ''); ?>
                <?php echo CHtml::activeTextField($receiveDetail, 'product_name'); ?>
                <?php echo CHtml::error($receiveDetail, 'product_name'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Kategori', ''); ?>
                <?php echo CHtml::encode(CHtml::value($receiveDetail, 'productCategory.name')); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Tebal', ''); ?>
                <?php echo CHtml::activeTextField($receiveDetail, 'height', array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetReceiveWeight', array('id' => $receiveDetail->id)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($receiveDetail, "weight") . '").val(data.weight);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($receiveDetail, 'height'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Lebar', ''); ?>
                <?php echo CHtml::activeTextField($receiveDetail, 'width', array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetReceiveWeight', array('id' => $receiveDetail->id)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($receiveDetail, "weight") . '").val(data.weight);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($receiveDetail, 'width'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Panjang', ''); ?>
                <?php echo CHtml::activeTextField($receiveDetail, 'length', array(
                    'onchange' => CHtml::ajax(array(
                        'type' => 'POST',
                        'dataType' => 'JSON',
                        'url' => CController::createUrl('ajaxJsonGetReceiveWeight', array('id' => $receiveDetail->id)),
                        'success' => 'function(data) {
                            $("#' . CHtml::activeId($receiveDetail, "weight") . '").val(data.weight);
                        }',
                    )),
                )); ?>
                <?php echo CHtml::error($receiveDetail, 'length'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Berat', ''); ?>
                <?php echo CHtml::activeTextField($receiveDetail, 'weight', array('readOnly' => true)); ?>
                <?php echo CHtml::error($receiveDetail, 'weight'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Lokasi', ''); ?>
                <?php echo CHtml::activeDropDownList($receiveDetail, 'location_id', CHtml::listData(Location::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                    'empty' => '-Select Location-'
                )); ?>
                <?php echo CHtml::error($receiveDetail, 'weight'); ?>
            </div>
            <div class="row">
                <?php echo CHtml::label('Status', ''); ?>
                    <?php echo CHtml::activeDropDownList($receiveDetail, 'is_inactive', array(ActiveRecord::ACTIVE => 'Active', ActiveRecord::INACTIVE => 'Inactive')); ?>
                <?php echo CHtml::error($receiveDetail, 'is_inactive'); ?>
            </div>
        </div>

    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
