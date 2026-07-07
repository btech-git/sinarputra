<?php

class Product extends ProductBase {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchActive() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.stock_minimum', $this->stock_minimum);
        $criteria->compare('t.purchasing_price', $this->purchasing_price, true);
        $criteria->compare('t.selling_price', $this->selling_price, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getInventoryStockOnHand() {
        return 0;
    }
    
    public function getSaleInvoiceDetails()
    {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'deliveryDetail' => array(
                'with' => array(
                    'workOrderCuttingDetailProduct' => array(
                        'with' => array(
                            'saleDetailProduct' => array(
                                'with' => array(
                                    'quotationDetailProduct'
                                )
                            )
                        )
                    )
                )
            ),
        );

        $saleInvoiceDetails = SaleInvoiceDetail::model()->findAll($criteria);
        
        if(count($saleInvoiceDetails) > 0 )
            return $saleInvoiceDetails;
        else
            return array();
    }

    public function getPricing1() {
        $pricing = 0.00;
        $saleInvoiceDetails = $this->getSaleInvoiceDetails();
        
        if (count($saleInvoiceDetails) > 0) {
            $value = $saleInvoiceDetails[0];
            $pricing = $value->unit_price;
        }
        return $pricing;
    }
    
    public function getPricing2() {
        $pricing = 0.00;
        $saleInvoiceDetails = $this->getSaleInvoiceDetails();
        
        if (count($saleInvoiceDetails) > 1) {
            $value = $saleInvoiceDetails[1];
            $pricing = $value->unit_price;
        }
        return $pricing;
    }
    
    public function getPricing3() {
        $pricing = 0.00;
        $saleInvoiceDetails = $this->getSaleInvoiceDetails();
        
        if (count($saleInvoiceDetails) > 2) {
            $value = $saleInvoiceDetails[2];
            $pricing = $value->unit_price;
        }
        return $pricing;
    }
}