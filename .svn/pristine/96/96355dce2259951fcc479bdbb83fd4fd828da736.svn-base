<?php
//$sale as SaleHeader model

Yii::app()->clientScript->registerScript('memo', '
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 25% }
    .sig2 { width: 25% }
    .sig3 { width: 25% }
    .sig4 { width: 25% }

    table.memo, table.memo tr.theader th, table.memo tr.titems td {
        border-left: 1px solid;
        border-right: 1px solid;
        vertical-align:text-top;
    }

    table.memo tr.theader th {
        text-align: center;
        border-bottom: 2px solid;
    }
	
');
?>

<div id="memoheader">
    <div style="font-size: larger">PT. Sinar Putra Metalindo</div>
    <div style="font-size: 1.5em">ORDER PENJUALAN</div>
</div>

<br />

<div class="memonote">
    <div class="divtable">
        <div class="divtablecell hcolumn1">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Sale #</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode($sale->getCodeNumber(SaleHeader::CN_CONSTANT)); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($sale, 'date')))); ?>
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('H:mm:s', strtotime(CHtml::value($sale, 'time_created')))); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Tanggal Kirim</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime(CHtml::value($sale, 'estimate_delivery_date')))); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Customer PO</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'customer_order_number')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn1header" style="font-weight: bold">Salesman</div>
                    <div class="divtablecell info hcolumn1value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'employeeIdSalesman.name')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="divtablecell hcolumn2">
            <div class="divtable">
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">No. Customer</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'customer.code')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Customer</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'customer.company')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Alamat Pusat</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'customer.address_main')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Alamat Kirim</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'customer.address_secondary')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">Area</div>
                    <div class="divtablecell info hcolumn2value">
                        <?php echo CHtml::encode(CHtml::value($sale, 'customer.customerArea.name')); ?>
                    </div>
                </div>
                
                <div class="divtablerow">
                    <div class="divtablecell info hcolumn2header" style="font-weight: bold">New/Replacement</div>
                    <div class="divtablecell info hcolumn2value"><?php echo CHtml::encode(CHtml::value($sale, 'transactionStatus')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<table style="width: 60%; margin-left: auto; margin-right: auto; border: 1px solid">
    <tr>
        <td colspan="6">KETERANGAN:</td>
    </tr>
    <tr>
        <td>M</td>
        <td>=</td>
        <td>Miling Tebal</td>
        <td>SM</td>
        <td>=</td>
        <td>Miling Lebar & Panjang</td>
    </tr>
    <tr>
        <td>SM</td>
        <td>=</td>
        <td>Side Mill</td>
        <td>M & SM</td>
        <td>=</td>
        <td>Miling 6 Sisi</td>
    </tr>
    <tr>
        <td>G</td>
        <td>=</td>
        <td>Grinding</td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>HT</td>
        <td>=</td>
        <td>Heat Treatment</td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td>NT</td>
        <td>=</td>
        <td>Nitriding</td>
        <td colspan="3"></td>
    </tr>
</table>

<table class="memo">
    <tr class="theader">
        <th rowspan="2" style="text-align:center; width: 3%; vertical-align: middle">No.</th>
        <th rowspan="2" style="text-align:center; width: 8%; vertical-align: middle">Quotation #</th>
        <th rowspan="2" style="text-align:center; width: 5%; vertical-align: middle">Job Number</th>
        <th colspan="5">Permintaan</th>
        <th colspan="5">Penawaran</th>
        <th rowspan="2" style="text-align:center; width: 7%; vertical-align: middle">Berat</th>
        <th rowspan="2" style="text-align:center; width: 3%; vertical-align: middle">M</th>
        <th rowspan="2" style="text-align:center; width: 3%; vertical-align: middle">SM</th>
        <th rowspan="2" style="text-align:center; width: 3%; vertical-align: middle">G</th>
        <th rowspan="2" style="text-align:center; width: 3%; vertical-align: middle">HT</th>
        <th rowspan="2" style="text-align:center; width: 3%; vertical-align: middle">NTD</th>
        <th rowspan="2" style="text-align:center; vertical-align: middle">Material Awal</th>
    </tr>
    <tr class="theader">
        <th style="width: 5%">Nama</th>
        <th style="width: 5%">Tbl / Dmtr</th>
        <th style="width: 5%">Lebar</th>
        <th style="width: 5%">Pjg</th>
        <th style="width: 5%">Quantity</th>
        <th style="width: 5%">Nama</th>
        <th style="width: 5%">Tbl / Dmtr</th>
        <th style="width: 5%">Lebar</th>
        <th style="width: 5%">Pjg</th>
        <th style="width: 5%">Quantity</th>
    </tr>
    <?php foreach ($sale->saleDetails as $i => $detail): ?>
        <tr class="titems">
            <?php $detailProductService = $detail->quotation_detail_product_id == null ? $detail->quotationDetailService : $detail->quotationDetailProduct; ?>
            <td style="text-align:center;"><?php echo $i + 1; ?></td>
            <td><?php echo CHtml::encode($detail->quotation_detail_product_id == null ? $detail->quotationDetailService->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT) : $detail->quotationDetailProduct->quotationHeader->getCodeNumber(QuotationHeader::CN_CONSTANT)); ?></td>
            <td><?php echo $detail->quotation_detail_product_id == null ? CHtml::value($detail, 'quotationDetailService.job_number') : CHtml::value($detail, 'quotationDetailProduct.job_number'); ?></td>
            <td><?php echo $detail->quotation_detail_product_id == null ? CHtml::value($detail, 'quotationDetailService.product_name') : CHtml::value($detail, 'quotationDetailProduct.product_name_request'); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'height_request'))); ?></td>
            <td style="text-align: right"><?php echo ($detail->quotation_detail_product_id == null ? $detail->quotationDetailService->product_category_id != 2 : $detail->quotationDetailProduct->product_category_id != 2) ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'width_request'))): ''; ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'length_request'))); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.', CHtml::value($detailProductService, 'quantity_request'))); ?></td>
            <td><?php echo $detail->quotation_detail_product_id == null ? CHtml::value($detail, 'quotationDetailService.product_name') : CHtml::value($detail, 'quotationDetailProduct.product_name_quote'); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'height_quote'))); ?></td>
            <td style="text-align: right"><?php echo ($detail->quotation_detail_product_id == null ? $detail->quotationDetailService->product_category_id != 2 : $detail->quotationDetailProduct->product_category_id != 2) ? CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'width_quote'))): ''; ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detailProductService, 'length_quote'))); ?></td>
            <td style="text-align: center"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detailProductService, 'quantity_quote'))); ?></td>
            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.####', CHtml::value($detailProductService, 'weight'))); ?></td>
            <td style="text-align: center"><?php echo ((int)$detailProductService->is_miling == 1) ? 'Y' : ''; ?></td>
            <td style="text-align: center"><?php echo ((int)$detailProductService->is_sidemiling == 1) ? 'Y' : ''; ?></td>
            <td style="text-align: center"><?php echo ((int)$detailProductService->is_grinding == 1) ? 'Y' : ''; ?></td>
            <td style="text-align: center"><?php echo ((int)$detailProductService->is_hardness == 1) ? 'Y' : ''; ?></td>
            <td style="text-align: center"><?php echo ((int)$detailProductService->is_annelying == 1) ? 'Y' : ''; ?></td>
            <td>&nbsp;</td>
        </tr>
    <?php endforeach; ?>
    <?php for ($j = 15, $i = $i % $j + 1; $j > $i; $j--): ?>
        <tr class="titems">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    <?php endfor; ?>
    <tr>
        <td style="border-left: 1px solid; text-align: right; border-top: 2px solid; font-weight: bold;  border-bottom: 1px solid" colspan="12">Total Quantity:</td>
        <td style="text-align: center; border-top: 2px solid; font-weight: bold;  border-bottom: 1px solid"><?php echo $sale->totalQuantity; ?></td>
        <td style="text-align: right; border-top: 2px solid; font-weight: bold;  border-bottom: 1px solid"><?php echo $sale->totalWeight; ?></td>
        <td style="border-top: 2px solid;  border-right: 1px solid;  border-bottom: 1px solid" colspan="6" >&nbsp;</td>
    </tr>
</table>
        
<div class="memoCatatan">Catatan: <?php echo CHtml::encode(CHtml::value($sale, 'note')); ?></div>
<br />
<div class="memoCatatan">Note: <?php echo CHtml::encode(CHtml::value($sale, 'customer.note')); ?></div>

<div class="memosig">
    <div style="font-weight:bold; font-style: italic;" class="divtable">
        <div class="divtablecell sig1">
            <div>Pembuat,</div>
            <div style="height: 80px;"></div>
            <div ><?php echo CHtml::encode(CHtml::value($sale, 'admin.name'));      ?></div>
        </div>
        <div class="divtablecell sig2">
            <div></div>
            <div style="height: 80px;"></div>
            <div ><?php //echo CHtml::encode(CHtml::value($sale, 'admin.name')); ?></div>
        </div>
        <div class="divtablecell sig4">
            <div></div>
            <div style="height: 80px;"></div>
            <div><?php //echo CHtml::encode(CHtml::value($sale, 'customer.company')); ?></div>
        </div>
    </div>
</div>
