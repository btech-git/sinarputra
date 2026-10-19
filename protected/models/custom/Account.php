<?php

class Account extends AccountBase {

    public $accountBalance;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getBeginningBalance($accountId, $startDate) {
        $sql = SqlGenerator::beginningBalance();

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getEndingBalance($accountId, $endDate) {
        $sql = SqlGenerator::endingBalance();

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getBalanceTotal($startDate, $endDate) {
        
        $sql = "SELECT SUM(IF(a.normal_balance = 'Debit', j.debit - j.credit, j.credit - j.debit)) AS journal_balance
                FROM " . JournalAccounting::model()->tableName() . " j 
                INNER JOIN " . Account::model()->tableName() . " a ON a.id = j.account_id
                WHERE j.account_id = :account_id AND j.date BETWEEN :start_date AND :end_date";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':account_id' => $this->id,
        ));

        return $resultSet;
    }

    public function getBeginningBalanceLedger($accountId, $startDate) {
        $sql = SqlGenerator::beginningBalanceLedger();

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':start_date' => $startDate,
        ));

        $this->accountBalance = $value;

        return ($value === false) ? 0 : $value;
    }

    public function getEndBalanceLedger($accountId, $endDate) {
        $sql = SqlGenerator::endBalanceLedger();

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':end_date' => $endDate,
        ));

        $this->accountBalance = $value;

        return ($value === false) ? 0 : $value;
    }

    public function getEndDebitLedger($accountId, $startDate, $endDate) {
        $sql = SqlGenerator::endDebitLedger();

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':end_date' => $endDate,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getEndCreditLedger($accountId, $startDate, $endDate) {
        $sql = SqlGenerator::endCreditLedger();

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':end_date' => $endDate,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public static function getProfitLossCoaReport() {
        
        $sql = "SELECT a.id AS id, a.code AS code, a.name AS name, c.code AS parent_code
                FROM " . Account::model()->tableName() . " a
                INNER JOIN " . AccountCategory::model()->tableName() . " c ON c.id = a.account_category_id
                WHERE a.code >= '4'
                ORDER BY a.code ASC;";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }
}