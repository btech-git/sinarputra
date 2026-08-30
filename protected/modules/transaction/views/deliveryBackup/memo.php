<?php
//$deliveryBackup as DeliveryHeader model

Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 35% }
    .sig2 { width: 40% }
    .sig3 { width: 25% }
    
    .memo-title
    {
        margin-left:15%;
        font-size:12px;
    }
');
?>

<?php $lastPage = floor((count($deliveryBackup->deliveryBackupDetails) - 1) / 20); ?>
<?php $page = 0; ?>
<?php while ($page <= $lastPage): ?>
    <div <?php if ($page > 0): ?>style="page-break-before: always"<?php endif; ?>>
        <div id="memoheader">

            <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/SPM LOGO FINAL.jpg" alt="" width="150%"/></div>
            <div class="memo-title">
                <table>
                    <tr>
                        <td style="text-align: left;">Workshop</td>
                        <td>:</td>
                        <td style="text-align: left;">Jl. Johar Blok F6 No. 3A-B Delta Silicon II Industrial Park </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align: left;">Lippo Cikarang - Bekasi 17530 </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Telp</td>
                        <td>:</td>
                        <td style="text-align: left;">(021) 89904100, 29577585-6 Fax : (021) 89904145, 29577583 </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">Email</td>
                        <td>:</td>
                        <td style="text-align: left;">sales@sinarputrametalindo.com </td>
                    </tr>
                    <tr>
                        <td style="font-size: 16px; text-align: center; font-weight: bold" colspan="3">
                            SURAT JALAN
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <table width="100%">
            <tr>
                <td style="border-left: 2px solid;border-top: 2px solid;width:12%;">Kepada Yth</td>
                <td style="border-top: 2px solid;width:2%;">:</td>
                <td style="border-top: 2px solid; width:38%;">
                    <?php echo CHtml::encode(CHtml::value($deliveryBackup, 'customer.company')); ?>
                </td>
                <td style="border-left: 2px solid;border-top: 2px solid; width:15%">Tanggal</td>
                <td style="border-top: 2px solid;width:2%">:</td>
                <td style="border-right: 2px solid;border-top: 2px solid; width:33%;">
                    <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($deliveryBackup, 'transaction_date')))); ?>
                </td>
            </tr>
            <tr>
                <td style="border-left: 2px solid;" colspan="3">
                    <?php echo nl2br(CHtml::encode(CHtml::value($deliveryBackup, 'customer_address'))); ?>
                </td>
                <td style="border-left: 2px solid;">No. Purchase Order</td>
                <td>:</td>
                <td style="border-right: 2px solid;">
                    <?php //echo CHtml::encode(CHtml::value($deliveryBackup, 'workOrderCuttingHeader.saleHeader.customer_order_number')); ?>
                </td>
            </tr>
            <tr>
                <td style="border-left: 2px solid; border-bottom: 2px solid;" colspan="3">
                    <?php echo CHtml::encode(CHtml::value($deliveryBackup, 'customer_city')); ?> - 
                    Area: <?php echo CHtml::encode(CHtml::value($deliveryBackup, 'customer.customerArea.name')); ?>
                </td>
                <td style="border-left: 2px solid; border-bottom: 2px solid;">No. Surat Jalan</td>
                <td style="border-bottom: 2px solid;">:</td>
                <td style="border-right: 2px solid; border-bottom: 2px solid;">
                    <?php echo CHtml::encode($deliveryBackup->getCodeNumber(DeliveryBackupHeader::CN_CONSTANT)); ?>
                </td>
            </tr>
        </table>

        <br />

        <table class="memo">
            <tr id="theader">
                <th style="width: 5%; border-top: 2px solid; border-bottom: 2px solid">No.</th>
                <th style="width: 10%; border-top: 2px solid; border-bottom: 2px solid">Banyaknya</th>
                <th style="text-align: center; border-top: 2px solid; border-bottom: 2px solid">N A M A &nbsp; B A R A N G</th>
                <th style="width: 10%; border-top: 2px solid; border-bottom: 2px solid">Berat (kg)</th>
            </tr>
            <?php for ($n = 0; $n < 20; $n++): ?>
                <?php $i = $page * 20 + $n; ?>
                <?php if (isset($deliveryBackup->deliveryBackupDetails[$i])): ?>
                    <?php $detail = $deliveryBackup->deliveryBackupDetails[$i]; ?>
                    <tr class="titems" style="font-size: 14px">
                        <td style="text-align: center"><?php echo $i + 1; ?></td>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity'))); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($detail, 'grade_name')); ?> -
                            <?php echo CHtml::encode(CHtml::value($detail, 'productCategory.name')); ?>
                            <?php if ($detail->height != 0.00 && $detail->length != 0.00): ?>
                                --
                                <?php if ($detail->product_category_id == 2): ?>
                                    <?php echo 'Dia.'; ?>
                                <?php endif; ?>
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'height'))); ?>

                                <?php if ($detail->product_category_id != 2): ?>
                                    x
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'width'))); ?>
                                <?php endif; ?>
                                x
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'length'))); ?>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'weight'))); ?></td>
                    </tr>
                <?php else: ?>
                    <tr class="titems">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                <?php endif; ?>
            <?php endfor; ?>
            <?php if ($page === (int) $lastPage): ?>
                <tr class="titems">
                    <td style="border-top: 2px solid #555; text-align: right; font-weight: bold;">Total: </td>
                    <td style="border-top: 2px solid #555; text-align: center; font-weight: bold;">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $deliveryBackup->totalQuantity)); ?>
                    </td>
                    <td style="border-top: 2px solid #555"></td>
                    <td style="border-top: 2px solid #555; text-align: center; font-weight: bold;">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $deliveryBackup->totalWeight)); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
    <?php $page++; ?>
<?php endwhile; ?>

<div>
    <div>
        Catatan: <?php echo nl2br(CHtml::encode(CHtml::value($deliveryBackup, 'note'))); ?>
    </div>

    <div class="memosig">
        <div style="font-weight:bold; font-style: italic;" class="divtable">
            <div  class="divtablecell">
                <div>Penerima / Pembeli</div>
                <div style="height: 70px;"></div>
                <div style="width: 40%; margin-left: auto; margin-right: auto;">
                    <div style="text-align: left;">
                        <p>Nama Penerima:</p>
                        <p>Jam Terima:</p>
                    </div>
                </div>
            </div>
            <div  class="divtablecell">
                <div>Ekspedisi</div>
            </div>
            <div  class="divtablecell">
                <div>Hormat Kami,</div>
                <div style="height: 70px;"></div>
                <div style="width: 30%; margin-left: auto; margin-right: auto;">
                    <div style="float: center;">
                        <?php echo CHtml::encode(CHtml::value($deliveryBackup, 'admin.name')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>