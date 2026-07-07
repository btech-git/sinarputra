<?php
$this->breadcrumbs = array(
    'Receive' => array('create'),
    'View',
);
?>

<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<div id="detail_div">
    
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'receive-upload-form',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'enableAjaxValidation' => false,
    )); ?>
    
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $receive->header,
        'attributes' => array(
            array(
                'label' => 'Penerimaan #',
                'value' => $receive->header->getCodeNumber(ReceiveHeader::CN_CONSTANT),
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $receive->header->date),
            ),
            array(
                'label' => 'Pembelian #',
                'value' => $receive->header->purchase_header_id ? $receive->header->purchaseHeader->getCodeNumber(PurchaseHeader::CN_CONSTANT) : '',
            ),
            array(
                'label' => 'Gudang',
                'value' => $receive->header->warehouse->name,
            ),
            array(
                'label' => 'Supplier',
                'value' => CHtml::encode(CHtml::value($receive->header, 'supplier.company')),
            ),
            array(
                'label' => 'Catatan',
                'value' => $receive->header->note,
            ),
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
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
            'location.name: Lokasi',
            'memo',
        ),
    )); ?>
    
    <div id="link">
        Attach Images (Upload size max 10MB) : 
        <?php $this->widget('CMultiFileUpload', array(
            'model' => $receive->header,
            'attribute' => 'images',
            'accept' => 'jpg|jpeg|png|pdf',
            'denied' => 'Only jpg, jpeg, png and pdf are allowed',
            'max' => 10,
            'remove' => '[x]',
            'duplicate' => 'Already Selected',
            'options' => array(
                'afterFileSelect' => 'function(e ,v ,m){
                    var fileSize = e.files[0].size;
                    if (fileSize > 11*1024*1024) {
                        alert("Exceeds file upload limit 10MB");
                        $(".MultiFile-remove").click();
                    }                      
                    return true;
                }',
            ),
        )); ?>
    </div>
    
    <br /> 
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>

