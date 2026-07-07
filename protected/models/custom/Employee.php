<?php

class Employee extends EmployeeBase {

    public $file;
    public $file_signature;

    const MALE = 0;
    const FEMALE = 1;
    const MALE_LITERAL = 'Male';
    const FEMALE_LITERAL = 'Female';

    const SINGLE = 0;
    const MARRIED = 1;
    const DIVORCE = 2;
    const MARRIED_LITERAL = 'Menikah';
    const SINGLE_LITERAL = 'Belum Menikah';
    const DIVORCE_LITERAL = 'Cerai';

    const HUSBAND = 1;
    const WIFE = 2;
    const CHILD = 3;
    const HUSBAND_LITERAL = 'Suami';
    const WIFE_LITERAL = 'Istri';
    const CHILD_LITERAL = 'Anak';

    const L = 1;
    const K0 = 2;
    const K1 = 3;
    const K2 = 4;
    const K3 = 5;
    const L_LITERAL = 'L';
    const K0_LITERAL = 'K0';
    const K1_LITERAL = 'K1';
    const K2_LITERAL = 'K2';
    const K3_LITERAL = 'K3';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getGenderStatus() {
        return ($this->is_female) ? self::FEMALE_LITERAL : self::MALE_LITERAL;
    }

    public function getMaritalStatus($status) {
        switch ($status) {
            case self::MARRIED: return self::MARRIED_LITERAL;
            case self::SINGLE: return self::SINGLE_LITERAL;
            case self::DIVORCE: return self::DIVORCE_LITERAL;
            default: return '';
        }
    }

    public function getFamilyStatus($status) {
        switch ($status) {
            case self::HUSBAND: return self::HUSBAND_LITERAL;
            case self::WIFE: return self::WIFE_LITERAL;
            case self::CHILD: return self::CHILD_LITERAL;
            default: return '';
        }
    }

    public function getTaxStatus($status) {
        switch ($status) {
            case self::L: return self::L_LITERAL;
            case self::K0: return self::K0_LITERAL;
            case self::K1: return self::K1_LITERAL;
            case self::K2: return self::K2_LITERAL;
            case self::K3: return self::K3_LITERAL;
            default: return '';
        }
    }

    public function getNameAndGroup() {
        return $this->name . ' - ' . $this->job_group;
    }
}