<?php

/**
 * @property integer $id
 * @property string $product_name
 * @property string $length_request
 * @property string $length_quote
 * @property string $width_request
 * @property string $width_quote
 * @property string $height_request
 * @property string $height_quote
 * @property integer $quantity_request
 * @property integer $quantity_quote
 * @property string $weight
 * @property string $unit_price
 * @property string $job_number
 * @property integer $product_category_id
 * @property integer $quotation_header_id
 * @property integer $is_miling
 * @property integer $is_grinding
 * @property integer $is_hardness
 * @property integer $is_annelying
 * @property integer $is_sidemiling
 * @property integer $is_coating
 * @property integer $is_cutting
 * @property integer $is_using_weight
 * @property integer $is_inactive
 *
 * @property QuotationHeader $quotationHeader
 * @property ProductCategory $productCategory
 * @property SaleDetail[] $saleDetails
 */
class QuotationDetailServiceBase extends ActiveRecord {

    public function tableName() {
        return 'tblsp_quotation_detail_service';
    }

    public function rules() {
        return array(
            array('product_name, job_number, product_category_id, quotation_header_id', 'required'),
            array('quantity_request, quantity_quote, product_category_id, quotation_header_id, is_miling, is_grinding, is_hardness, is_annelying, is_coating, is_sidemiling, is_cutting, is_using_weight, is_inactive', 'numerical', 'integerOnly' => true),
            array('product_name, job_number', 'length', 'max' => 60),
            array('length_request, length_quote, width_request, width_quote, height_request, height_quote', 'length', 'max' => 10),
            array('weight, unit_price', 'length', 'max' => 18),
            // The following rule is used by search().
            array('id, product_name, length_request, length_quote, width_request, width_quote, height_request, height_quote, quantity_request, quantity_quote, weight, unit_price, job_number, product_category_id, quotation_header_id, is_miling, is_grinding, is_hardness, is_annelying, is_sidemiling, is_cutting, is_coating, is_using_weight', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'quotationHeader' => array(self::BELONGS_TO, 'QuotationHeader', 'quotation_header_id'),
            'productCategory' => array(self::BELONGS_TO, 'ProductCategory', 'product_category_id'),
            'saleDetails' => array(self::HAS_MANY, 'SaleDetail', 'quotation_detail_service_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_name' => 'Product Name',
            'length_request' => 'Length Request',
            'length_quote' => 'Length Quote',
            'width_request' => 'Width Request',
            'width_quote' => 'Width Quote',
            'height_request' => 'Height Request',
            'height_quote' => 'Height Quote',
            'quantity_request' => 'Quantity Request',
            'quantity_quote' => 'Quantity Quote',
            'weight' => 'Weight',
            'unit_price' => 'Unit Price',
            'job_number' => 'Job Number',
            'product_category_id' => 'Product Category',
            'quotation_header_id' => 'Quotation Header',
            'is_miling' => 'Miling',
            'is_grinding' => 'Grinding',
            'is_hardness' => 'Hardness',
            'is_annelying' => 'Annelying',
            'is_sidemiling' => 'Sidemiling',
            'is_cutting' => 'Cutting',
            'is_coating' => 'Coating',
            'is_using_weight' => 'Using Weight',
            'is_inactive' => 'Inactive',
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_name', $this->product_name, true);
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
        $criteria->compare('t.is_coating', $this->is_coating);
        $criteria->compare('t.is_cutting', $this->is_cutting);
        $criteria->compare('t.is_using_weight', $this->is_using_weight);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

}
