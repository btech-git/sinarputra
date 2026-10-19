<?php

class JournalAccounting extends JournalAccountingBase {

    public $currentSaldo;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getLedgerBeginningBalances($startDate) {  
        
        $sql = "
            SELECT account_id, COALESCE(SUM(debit - credit), 0) AS beginning_balance 
            FROM " . JournalAccounting::model()->tableName() . " 
            WHERE date < :start_date AND is_inactive = 0
            GROUP BY account_id
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':start_date' => $startDate,
        ));

        return $resultSet;
    }
    
    public static function getGeneralLedgerReport($startDate, $endDate, $accountId) {
        $accountConditionSql = '';
      
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($accountId)) {
            $accountConditionSql = ' AND a.id = :account_id';
            $params[':account_id'] = $accountId;
        }
        
        $sql = "SELECT j.account_id, a.name AS account_name, a.code AS account_code, j.debit, j.credit
                FROM " . Account::model()->tableName() . " a
                INNER JOIN (
                    SELECT account_id, SUM(debit) AS debit, SUM(credit) AS credit
                    FROM " . JournalAccounting::model()->tableName() . " 
                    WHERE date BETWEEN :start_date AND :end_date AND is_inactive = 0
                    GROUP BY account_id
                ) j ON a.id = j.account_id
                WHERE a.is_inactive = 0" . $accountConditionSql . "
                ORDER BY a.code ASC
                LIMIT 30";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getProfitLossLedgerReport($startDate, $endDate) {
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT j.account_id, MAX(a.code) AS account_code, COALESCE(SUM(
                    CASE a.normal_balance
                    WHEN 'Debit' THEN j.debit - j.credit
                    WHEN 'Credit' THEN j.credit - j.debit
                    ELSE 0
                    END
                ), 0) AS balance
                FROM " . JournalAccounting::model()->tableName() . " j 
                INNER JOIN " . Account::model()->tableName() . " a ON a.id = j.account_id
                WHERE a.code >= '4' AND j.date BETWEEN :start_date AND :end_date AND a.is_inactive = 0
                GROUP BY j.account_id
                ORDER BY a.code ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
