<?php

class QuotationDetailProduct extends QuotationDetailProductBase {

    const IS_USING_WEIGHT = 1;
    const IS_USING_QUANTITY = 2;
    const IS_USING_WEIGHT_LITERAL = 'Berat';
    const IS_USING_QUANTITY_LITERAL = 'Pcs';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getMultiplicationStatus() {
        return ($this->is_using_weight) ? self::IS_USING_QUANTITY_LITERAL : self::IS_USING_WEIGHT_LITERAL;
    }

    public function searchNotSelectedInSaleDetailProduct() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array('quotationHeader');
        $criteria->addCondition("t.id NOT IN (
            SELECT quotation_detail_product_id 
            FROM " . SaleDetail::model()->tableName() . "
            WHERE t.id = quotation_detail_product_id
        ) AND quotationHeader.date > '2021-12-31'");

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name_request', $this->product_name_request, true);
        $criteria->compare('t.product_name_quote', $this->product_name_quote, true);
        $criteria->compare('t.length_request', $this->length_request, true);
        $criteria->compare('t.length_quote', $this->length_quote, true);
        $criteria->compare('t.width_request', $this->width_request, true);
        $criteria->compare('t.width_quote', $this->width_quote, true);
        $criteria->compare('t.height_request', $this->height_request, true);
        $criteria->compare('t.height_quote', $this->height_quote, true);
        $criteria->compare('t.quantity_request', $this->quantity_request);
        $criteria->compare('t.quantity_quote', $this->quantity_quote);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.unit_price', $this->unit_price, true);
        $criteria->compare('t.job_number', $this->job_number, true);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.quotation_header_id', $this->quotation_header_id);
        $criteria->compare('t.is_miling', $this->is_miling);
        $criteria->compare('t.is_grinding', $this->is_grinding);
        $criteria->compare('t.is_hardness', $this->is_hardness);
        $criteria->compare('t.is_annelying', $this->is_annelying);
        $criteria->compare('t.is_sidemiling', $this->is_sidemiling);
        $criteria->compare('t.is_inactive', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 50
            ),
        ));
    }

    public function getWeightRequest() {
        $mass = CHtml::value($this, 'productCategory.mass');

        $staticWeight = 1.00;

        if ($this->product_category_id == 1 || $this->product_category_id == 3) {
            $weightRequest = $this->length_quote * $this->width_quote * $this->height_quote * $mass;
        } elseif ($this->product_category_id == 2 || $this->product_category_id == 5) {
            $weightRequest = $this->length_quote * $this->height_quote * $this->height_quote * $mass;
        } elseif ($this->product_category_id == 4) {
            $weightRequest = $this->weight / $this->quantity_quote;
        } else
            $weightRequest = 0.00;

        if ($weightRequest == 0.00)
            return $weightRequest * $this->quantity_quote;
        else if ($weightRequest < 1 && ($this->product_category_id == 2 || $this->product_category_id == 3))
            return $staticWeight * $this->quantity_quote;
        else
            return $weightRequest * $this->quantity_quote;
    }

    public function getTotal() {
        $optionMultiplication = ((int) $this->is_using_weight !== 1) ? $this->quantity_quote : $this->weight;

        return $optionMultiplication * $this->unit_price;
    }

    public function getSaleHeaderNumber() {
        $saleDetail = SaleDetail::model()->findByAttributes(array('quotation_detail_product_id' => $this->id));

        if ($saleDetail)
            return $saleDetail->saleHeader->getCodeNumber(SaleHeader::CN_CONSTANT);
        else
            return "Belum Proses";
    }

    public function searchForProduct() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name_request', $this->product_name_request, true);
        $criteria->compare('t.product_name_quote', $this->product_name_quote, true);
        $criteria->compare('t.length_request', $this->length_request, true);
        $criteria->compare('t.length_quote', $this->length_quote, true);
        $criteria->compare('t.width_request', $this->width_request, true);
        $criteria->compare('t.width_quote', $this->width_quote, true);
        $criteria->compare('t.height_request', $this->height_request, true);
        $criteria->compare('t.height_quote', $this->height_quote, true);
        $criteria->compare('t.quantity_request', $this->quantity_request, true);
        $criteria->compare('t.quantity_quote', $this->quantity_quote, true);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.unit_price', $this->unit_price, true);
        $criteria->compare('t.job_number', $this->job_number);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.quotation_header_id', $this->quotation_header_id);
        $criteria->compare('t.is_miling', $this->is_miling);
        $criteria->compare('t.is_grinding', $this->is_grinding);
        $criteria->compare('t.is_hardness', $this->is_hardness);
        $criteria->compare('t.is_annelying', $this->is_annelying);
        $criteria->compare('t.is_sidemiling', $this->is_sidemiling);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        $criteria->order = 't.id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pagesize' => 50
            ),
        ));
    }
    
    public function getProcessList() {
        $miling = (int)$this->is_miling === 1 ? 'M ' : '';
        $grinding = (int)$this->is_grinding === 1 ? 'G ' : '';
        $hardness = (int)$this->is_hardness === 1 ? 'HT ' : '';
        $annelying = (int)$this->is_annelying === 1 ? 'NTD ' : '';
        $sidemiling = (int)$this->is_sidemiling === 1 ? 'SM ' : '';
        
        return $miling . $grinding . $hardness . $annelying . $sidemiling;
    }

    public function searchByQuotationPricingHistory() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name_request', $this->product_name_request, true);
        $criteria->compare('t.product_name_quote', $this->product_name_quote, true);
        $criteria->compare('t.length_request', $this->length_request, true);
        $criteria->compare('t.length_quote', $this->length_quote, true);
        $criteria->compare('t.width_request', $this->width_request, true);
        $criteria->compare('t.height_request', $this->height_request, true);
        $criteria->compare('t.quantity_request', $this->quantity_request);
        $criteria->compare('t.quantity_quote', $this->quantity_quote);
        $criteria->compare('t.weight', $this->weight, true);
        $criteria->compare('t.unit_price', $this->unit_price, true);
        $criteria->compare('t.job_number', $this->job_number, true);
        $criteria->compare('t.product_category_id', $this->product_category_id);
        $criteria->compare('t.quotation_header_id', $this->quotation_header_id);
        $criteria->compare('t.is_miling', $this->is_miling);
        $criteria->compare('t.is_grinding', $this->is_grinding);
        $criteria->compare('t.is_hardness', $this->is_hardness);
        $criteria->compare('t.is_annelying', $this->is_annelying);
        $criteria->compare('t.is_sidemiling', $this->is_sidemiling);
        $criteria->compare('t.is_using_weight', $this->is_using_weight);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
}
