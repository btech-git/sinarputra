<?php
$this->breadcrumbs = array(
    'Delivery' => array('qualityControlList'),
    'View',
);
?>
<h1>Pengiriman Barang Manual 2</h1>
<div id="detail_div">
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $deliveryBackup,
        'attributes' => array(
            array(
                'label' => 'Pengiriman #',
                'value' => $deliveryBackup->getCodeNumber(DeliveryBackupHeader::CN_CONSTANT),
            ),
            array(
                'label' => 'Tanggal',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", $deliveryBackup->transaction_date),
            ),
            array(
                'label' => 'Gudang',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'warehouse.name')),
            ),
            array(
                'label' => 'Customer',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'customer.company')),
            ),
            array(
                'label' => 'Alamat Kirim',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'customer_address')),
            ),
            array(
                'label' => 'Kota Tujuan',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'customer_city')),
            ),
            array(
                'label' => 'PO #',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'purchase_order_number')),
            ),
            array(
                'label' => 'SPK #',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'work_order_number')),
            ),
            array(
                'label' => 'Sopir',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'employeeIdDriver.name')),
            ),
            array(
                'label' => 'Catatan',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'note')),
            ),
            array(
                'label' => 'Created By',
                'value' => CHtml::encode(CHtml::value($deliveryBackup, 'admin.username')),
            ),
            array(
                'label' => 'Created Date Time',
                'value' => Yii::app()->dateFormatter->format("d MMMM yyyy H:i:s", $deliveryBackup->created_datetime),
            ),
        ),
    )); ?>

    <br />
    
    <div class="row">
        <table>
            <thead>
                <tr>
                    <th>GRADE</th>
                    <th>Kategori</th>
                    <th>Tebal / Dmtr</th>
                    <th>Lebar</th>
                    <th>Panjang</th>
                    <th>Quantity</th>
                    <th>Berat</th>
                    <th>M</th>
                    <th>SM</th>
                    <th>G</th>
                    <th>HT</th>
                    <th>NTD</th>
                    <th>COA</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deliveryBackup->deliveryBackupDetails as $detail): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'grade_name')); ?></td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'height')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'width')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'length')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(CHtml::value($detail, 'weight')); ?></td>
                        <td style="text-align: center"><?php echo CHtml::value($detail, "is_miling") == 1 ? "Yes" : ""; ?></td>
                        <td style="text-align: center"><?php echo CHtml::value($detail, "is_sidemiling") == 1 ? "Yes" : ""; ?></td>
                        <td style="text-align: center"><?php echo CHtml::value($detail, "is_grinding") == 1 ? "Yes" : ""; ?></td>
                        <td style="text-align: center"><?php echo CHtml::value($detail, "is_hardness") == 1 ? "Yes" : ""; ?></td>
                        <td style="text-align: center"><?php echo CHtml::value($detail, "is_annelying") == 1 ? "Yes" : ""; ?></td>
                        <td style="text-align: center"><?php echo CHtml::value($detail, "is_coating") == 1 ? "Yes" : ""; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <hr />
    
    <div id="link">
        <?php echo CHtml::link('Create', array('create')); ?> &nbsp; &nbsp;
        <?php echo CHtml::link('Manage', array('admin')); ?> &nbsp; &nbsp;
        <?php echo CHtml::link('Print', array('memo', 'id' => $deliveryBackup->id), array('target' => '_blank')); ?>
    </div>
</div>