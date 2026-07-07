
<?php
$this->breadcrumbs = array(
    'Receive' => array('create'),
    'View',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $receive,
        'attributes' => array(
            array(
                'label' => 'Penerimaan #',
                'value' => $receive->getCodeNumber(ReceiveHeader::CN_CONSTANT),
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $receive->date),
            ),
            array(
                'label' => 'Gudang',
                'value' => $receive->warehouse->name,
            ),
            array(
                'label' => 'Supplier',
                'value' => CHtml::encode(CHtml::value($receive, 'supplier.company')),
            ),
            array(
                'label' => 'Catatan',
                'value' => $receive->note,
            ),
            array(
                'label' => 'Pembelian #',
                'value' => $receive->purchaseHeader ? $receive->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT) : '',
            ),
        ),
    ));
    ?>

    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'material-receive-detail-grid',
        'dataProvider' => $detailsDataProvider,
        'columns' => array(
            array(
                'header' => 'SerialNumber',
                'value' => '$data->serialConstant',
            ),
            'product_name: Nama Barang',
            'productCategory.name: Kategori',
            array(
                'header' => 'Tinggi/Dmtr',
                'value' => 'number_format($data->height, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Lebar/Dmtr',
                'value' => '$data->product_category_id != 2 ? number_format($data->width, 2) : ""',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Panjang',
                'value' => 'number_format($data->length, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            array(
                'header' => 'Berat',
                'value' => 'number_format($data->weight, 2)',
                'htmlOptions' => array(
                    'style' => 'text-align: right',
                ),
            ),
            'hardness_scale',
            'number_heat',
            'location.name: Lokasi',
            'memo',
        ),
    ));
    ?>
    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?>
        <?php echo CHtml::link('Manage', array('admin')); ?>
        <?php echo CHtml::link('Print', array('memo', 'id' => $receive->id), array('target' => '_blank')); ?>
        <?php echo CHtml::link('Upload File', array('uploadFile', 'id' => $receive->id)); ?>
    </div>
</div>

<br /><hr />

<fieldset>
    <legend>Attached Files</legend>

    <?php if (!empty($postImages)): ?>
        <?php foreach ($postImages as $postImage): ?>
            <?php $src = Yii::app()->baseUrl . '/images/receive/' . $postImage->fullFilename; ?>
            <?php if ($postImage->extension == 'pdf'): ?>
                <div class="row" style="font-size: 24px; margin: 16px 0">
                    <?php echo CHtml::link($postImage->filename, $src, array('target' => '_blank')); ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="small-3 columns">
                        <div style="margin-bottom:.5rem">
                            <?php echo CHtml::image($src, "Files # " . $postImage->id, array('width' => 500, 'height' => 300,)); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</fieldset>