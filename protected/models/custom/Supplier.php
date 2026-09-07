<?php

class Supplier extends SupplierBase {

    const NO_TAX = 0;
    const FULL_TAX = 1;
    const NO_TAX_LITERAL = 'Tanpa PPn';
    const FULL_TAX_LITERAL = 'Dengan PPn';

    const NO_TAX_SERVICE = 0;
    const TAX_SERVICE_21 = 1;
    const TAX_SERVICE_22 = 2;
    const TAX_SERVICE_23 = 3;
    const TAX_SERVICE_24 = 4;
    const NO_TAX_SERVICE_LITERAL = 'Tanpa PPH';
    const TAX_SERVICE_21_LITERAL = 'PPh 21';
    const TAX_SERVICE_22_LITERAL = 'PPh 22';
    const TAX_SERVICE_23_LITERAL = 'PPh 23';
    const TAX_SERVICE_24_LITERAL = 'PPh 24';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTaxStatus() {
        return ($this->is_tax) ? self::FULL_TAX_LITERAL : self::NO_TAX_LITERAL;
    }

    public function getTaxServiceType($taxServiceType) {
        
        switch($taxServiceType) {
            case self::NO_TAX_SERVICE: return self::NO_TAX_SERVICE_LITERAL;
            case self::TAX_SERVICE_21: return self::TAX_SERVICE_21_LITERAL;
            case self::TAX_SERVICE_22: return self::TAX_SERVICE_22_LITERAL;
            case self::TAX_SERVICE_23: return self::TAX_SERVICE_23_LITERAL;
            case self::TAX_SERVICE_24: return self::TAX_SERVICE_24_LITERAL;
            default: return '';
        }
    }
}
