<?xml version="1.0" encoding="utf-8"?>
<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <TIN>0031486434413000</TIN>
    <ListOfTaxInvoice>
<?php foreach ($saleInvoiceHeaders as $saleInvoiceHeader): ?>
        <TaxInvoice>
            <TaxInvoiceDate><?php echo CHtml::value($saleInvoiceHeader, 'date'); ?></TaxInvoiceDate>
            <TaxInvoiceOpt>Normal</TaxInvoiceOpt>
            <TrxCode>04</TrxCode>
            <AddInfo/>
            <CustomDoc/>
            <RefDesc><?php echo $saleInvoiceHeader->getCodeNumber(ManualSaleInvoiceHeader::CN_CONSTANT); ?></RefDesc>
            <FacilityStamp/>
            <SellerIDTKU>0031486434413000000000</SellerIDTKU>
            <BuyerTin><?php echo CHtml::value($saleInvoiceHeader, 'customer.tax_registration_number'); ?></BuyerTin>
            <BuyerDocument>TIN</BuyerDocument>
            <BuyerCountry>IDN</BuyerCountry>
            <BuyerDocumentNumber/>
            <BuyerName><?php echo CHtml::value($saleInvoiceHeader, 'customer.company'); ?></BuyerName>
            <BuyerAdress><?php echo htmlspecialchars(CHtml::value($saleInvoiceHeader, 'customer.address_main'), ENT_XML1); ?></BuyerAdress>
            <BuyerEmail><?php echo CHtml::value($saleInvoiceHeader, 'customer.email'); ?></BuyerEmail>
            <BuyerIDTKU><?php echo CHtml::value($saleInvoiceHeader, 'customer.tax_registration_number'); ?>000000</BuyerIDTKU>
            <ListOfGoodService>
<?php foreach ($saleInvoiceHeader->manualSaleInvoiceDetails as $saleInvoiceDetail): ?>
                <GoodService>
                    <Opt>A</Opt>
                    <Code>720000</Code>
                    <Name><?php echo CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.job_number'); ?> - <?php echo CHtml::value($saleInvoiceDetail, 'grade_name'); ?> <?php if ($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->height_quote != 0.00 && $saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->length_quote != 0.00): ?> -- <?php if ($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->product_category_id == 2): ?> <?php echo 'Dia.'; ?> <?php endif; ?> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.height_quote'))); ?> <?php if ($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->product_category_id != 2): ?> x <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.width_quote'))); ?><?php endif; ?> x <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.length_quote'))); ?> || <?php if ($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->product_category_id == 2): ?> <?php echo 'Dia.'; ?><?php endif; ?> <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.height_request'))); ?> <?php if ($saleInvoiceDetail->deliveryDetail->workOrderCuttingDetail->product_category_id != 2): ?> x <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.width_request'))); ?><?php endif; ?> x <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleInvoiceDetail, 'deliveryDetail.workOrderCuttingDetail.length_request'))); ?><?php endif; ?></Name>
                    <Unit><?php if ($saleInvoiceDetail->is_using_weight == SaleInvoiceDetail::IS_USING_QUANTITY): ?>UM.0021<?php else: ?>UM.0003<?php endif; ?></Unit>
                    <Price><?php echo CHtml::value($saleInvoiceDetail, 'unit_price'); ?></Price>
                    <Qty><?php if ($saleInvoiceDetail->is_using_weight == SaleInvoiceDetail::IS_USING_QUANTITY): ?><?php echo CHtml::value($saleInvoiceDetail, 'quantity'); ?><?php else: ?><?php echo CHtml::value($saleInvoiceDetail, 'weight'); ?><?php endif; ?></Qty>
                    <TotalDiscount>0.00</TotalDiscount>
                    <TaxBase><?php echo CHtml::value($saleInvoiceDetail, 'total'); ?></TaxBase>
                    <OtherTaxBase><?php echo CHtml::value($saleInvoiceDetail, 'totalWithCoretax'); ?></OtherTaxBase>
                    <VATRate>12</VATRate>
                    <VAT><?php echo CHtml::value($saleInvoiceDetail, 'totalWithTax'); ?></VAT>
                    <STLGRate>0</STLGRate>
                    <STLG>0.00</STLG>
                </GoodService>
<?php endforeach; ?>
            </ListOfGoodService>
        </TaxInvoice>
<?php endforeach; ?>
    </ListOfTaxInvoice>
</TaxInvoiceBulk>
