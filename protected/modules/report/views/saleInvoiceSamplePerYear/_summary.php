<?php
Yii::app()->clientScript->registerCss('_report', '
        @page {
                size:auto;
                margin: 5px 0px 0px 0px;
            }

        .width1-1 { width: 5% }    
	.width1-2 { width: 15% }
        .width1-3 { width: 8% }
');
$yearChoose = $yearChoose ? $yearChoose : date('Y');
?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Faktur Penjualan (Sample)</div>
    <div><?php echo $yearChoose; ?></div>
</div>

<br />

<table class="report">
    <tr id="header1">
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Customer</th>
        <th class="width1-2" style="text-align: left;border-bottom: 2px solid;">Sales</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">January</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">February</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">March</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">April</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">May</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">June</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">July</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">August</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">September</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">October</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">November</th>
        <th class="width1-1" style="text-align: right;border-bottom: 2px solid;">December</th>
        <th class="width1-3" style="text-align: right;border-bottom: 2px solid;">Total</th>

    </tr>
    <?php $totalMonth1 = 0; ?>
    <?php $totalMonth2 = 0; ?>
    <?php $totalMonth3 = 0; ?>
    <?php $totalMonth4 = 0; ?>
    <?php $totalMonth5 = 0; ?>
    <?php $totalMonth6 = 0; ?>
    <?php $totalMonth7 = 0; ?>
    <?php $totalMonth8 = 0; ?>
    <?php $totalMonth9 = 0; ?>
    <?php $totalMonth10 = 0; ?>
    <?php $totalMonth11 = 0; ?>
    <?php $totalMonth12 = 0; ?>
    <?php $grandTotal = 0; ?>
    <?php foreach ($saleInvoiceSamplePerYearSummary->dataProvider->data as $header): ?>
        <?php $totalPerCustomer = 0; ?>
        <tr class="items1">
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'company')); ?></td>
            <td class="width1-2"><?php echo CHtml::encode(CHtml::value($header, 'employee.name')); ?></td>
            <td class="width1-1" style="text-align: right;">
                <?php $month1 = $header->getTotalInvoiceSamplePerMonth(1, $yearChoose); ?>
                <?php $totalMonth1 += $month1; ?>
                <?php $totalPerCustomer += $month1; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month1)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month2 = $header->getTotalInvoiceSamplePerMonth(2, $yearChoose); ?>
                <?php $totalMonth2 += $month2; ?>
                <?php $totalPerCustomer += $month2; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month2)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month3 = $header->getTotalInvoiceSamplePerMonth(3, $yearChoose); ?>
                <?php $totalMonth3 += $month3; ?>
                <?php $totalPerCustomer += $month3; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month3)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month4 = $header->getTotalInvoiceSamplePerMonth(4, $yearChoose); ?>
                <?php $totalMonth1 += $month4; ?>
                <?php $totalPerCustomer += $month4; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month4)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month5 = $header->getTotalInvoiceSamplePerMonth(5, $yearChoose); ?>
                <?php $totalMonth5 += $month5; ?>
                <?php $totalPerCustomer += $month5; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month5)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month6 = $header->getTotalInvoiceSamplePerMonth(6, $yearChoose); ?>
                <?php $totalMonth6 += $month6; ?>
                <?php $totalPerCustomer += $month6; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month6)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month7 = $header->getTotalInvoiceSamplePerMonth(7, $yearChoose); ?>
                <?php $totalMonth7 += $month7; ?>
                <?php $totalPerCustomer += $month7; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month7)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month8 = $header->getTotalInvoiceSamplePerMonth(8, $yearChoose); ?>
                <?php $totalMonth1 += $month8; ?>
                <?php $totalPerCustomer += $month8; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month8)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month9 = $header->getTotalInvoiceSamplePerMonth(9, $yearChoose); ?>
                <?php $totalMonth9 += $month9; ?>
                <?php $totalPerCustomer += $month9; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month9)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month10 = $header->getTotalInvoiceSamplePerMonth(10, $yearChoose); ?>
                <?php $totalMonth10 += $month10; ?>
                <?php $totalPerCustomer += $month10; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month10)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month11 = $header->getTotalInvoiceSamplePerMonth(11, $yearChoose); ?>
                <?php $totalMonth11 += $month11; ?>
                <?php $totalPerCustomer += $month11; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month11)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $month12 = $header->getTotalInvoiceSamplePerMonth(12, $yearChoose); ?>
                <?php $totalMonth12 += $month12; ?>
                <?php $totalPerCustomer += $month12; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $month12)); ?>
            </td>
            <td class="width1-1" style="text-align: right;">
                <?php $grandTotal += $totalPerCustomer; ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPerCustomer)); ?>
            </td>
        </tr>

    <?php endforeach; ?>
    <tr>
        <td class="width1-2" style="border-top:2px solid;"></td>
        <td class="width1-2" style="text-align: right;border-top:2px solid;">Total</td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth1)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth2)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth3)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth4)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth5)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth6)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth7)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth8)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth9)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth10)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth11)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalMonth12)); ?>
        </td>
        <td class="width1-1" style="text-align: right;border-top:2px solid;">
            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $grandTotal)); ?>
        </td>

    </tr>
</table>