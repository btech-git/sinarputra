<?xml version="1.0" encoding="utf-8"?>
<TaxInvoiceBulk xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <TIN>0031486434413000</TIN>
    <ListOfTaxInvoice>
<?php foreach ($materialInvoiceHeaders as $materialInvoiceHeader): ?>
        <TaxInvoice>
            <TaxInvoiceDate><?php echo CHtml::value($materialInvoiceHeader, 'date'); ?></TaxInvoiceDate>
            <TaxInvoiceOpt>Normal</TaxInvoiceOpt>
            <TrxCode>04</TrxCode>
            <AddInfo/>
            <CustomDoc/>
            <RefDesc><?php echo $materialInvoiceHeader->getCodeNumber(MaterialInvoiceHeader::CN_CONSTANT); ?></RefDesc>
            <FacilityStamp/>
            <SellerIDTKU>0031486434413000000000</SellerIDTKU>
            <BuyerTin><?php echo CHtml::value($materialInvoiceHeader, 'customer.tax_registration_number'); ?></BuyerTin>
            <BuyerDocument>TIN</BuyerDocument>
            <BuyerCountry>IDN</BuyerCountry>
            <BuyerDocumentNumber/>
            <BuyerName><?php echo CHtml::value($materialInvoiceHeader, 'customer.company'); ?></BuyerName>
            <BuyerAdress><?php echo htmlspecialchars(CHtml::value($materialInvoiceHeader, 'customer.address_main'), ENT_XML1); ?></BuyerAdress>
            <BuyerEmail><?php echo CHtml::value($materialInvoiceHeader, 'customer.email'); ?></BuyerEmail>
            <BuyerIDTKU><?php echo CHtml::value($materialInvoiceHeader, 'customer.tax_registration_number'); ?>000000</BuyerIDTKU>
            <ListOfGoodService>
<?php foreach ($materialInvoiceHeader->materialInvoiceDetails as $saleInvoiceDetail): ?>
                <GoodService>
                    <Opt>A</Opt>
                    <Code>720000</Code>
                    <Name><?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'material_name')); ?> - <?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'height')); ?> x <?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'width')); ?> x <?php echo CHtml::encode(CHtml::value($saleInvoiceDetail, 'length')); ?></Name>
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
