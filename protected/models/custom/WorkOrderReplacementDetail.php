<?php

class WorkOrderReplacementDetail extends WorkOrderReplacementDetailBase {
    const NOT_URGENT = 0;
    const URGENT = 1;

    const NOT_URGENT_LITERAL = 'No';
    const URGENT_LITERAL = 'Yes';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUrgentStatus() {
        return ($this->is_urgent) ? self::URGENT_LITERAL : self::NOT_URGENT_LITERAL;
    }

    public function getWeightRequest() {
        $mass = CHtml::value($this, 'productCategory.mass');

        if ($this->product_category_id == 1 || $this->product_category_id == 3) {
            $weightRequest = $this->length_quote
                    * $this->width_quote
                    * $this->height_quote
                    * $mass;
        } elseif ($this->product_category_id == 2) {
            $weightRequest = $this->length_quote
                    * $this->height_quote
                    * $this->height_quote
                    * $mass;
        } elseif ($this->product_category_id == 4) {
            $weightRequest = $this->weight / $this->quantity;
        } else
            $weightRequest = 0;
        
        return $weightRequest;
    }

}