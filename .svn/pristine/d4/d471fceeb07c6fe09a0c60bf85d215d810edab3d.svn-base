<?php

class SqlGenerator extends CComponent
{
	public static function localStock()
	{
		$sql = "SELECT COALESCE(SUM(quantity_in - quantity_out), 0) 
				FROM " . Inventory::model()->tableName() ." 
				WHERE product_color_size_id = :product_color_size_id AND warehouse_id = :warehouse_id";
		
		return $sql;
	}
	
	public static function inventoryStock()
	{
		$sql = "SELECT COALESCE(SUM(quantity_in - quantity_out), 0) AS stock
				FROM " . Inventory::model()->tableName() ." 
				WHERE product_color_size_id = :product_color_size_id";
		
		return $sql;
	}
	
	public static function saleDeliveryQuantity()
	{
		$sql = "SELECT COALESCE(SUM(quantity), 0) AS quantity
				FROM " . SaleDetail::model()->tableName() ." 
				WHERE product_color_size_id = :product_color_size_id AND id NOT IN (SELECT sale_detail_id FROM " . DeliveryDetail::model()->tableName() .")";
		
		return $sql;
	}
	
	public static function inventoryStockOnHand()
	{
		$sql = "SELECT inventory.stock - sale_delivery.quantity AS stock_on_hand
				FROM (" . self::inventoryStock() . ") inventory
				CROSS JOIN (" . self::saleDeliveryQuantity() . ") sale_delivery";
		
		return $sql;
	}
        
        public static function bankBook()
	{
		$sql = "SELECT dc.date, a.name AS account, dc.debit, dc.credit, dc.detail_account_id, dc.note
				FROM
				(
					" . SqlViewGenerator::balance() . "
				) dc
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = dc.detail_account_id
				WHERE dc.date BETWEEN :start_date AND :end_date AND dc.is_inactive = 0 AND a.is_inactive = 0
				ORDER BY date ASC, account ASC";

		return $sql;
	}
        
         public static function beginningBalance()
	{
		$sql = "SELECT COALESCE(SUM(dc.debit) - SUM(dc.credit), 0) AS beginning_balance FROM
				(
					" . SqlViewGenerator::balance() . "
				) dc
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = dc.detail_account_id
				WHERE dc.account_id = :account_id AND dc.date < :start_date AND dc.is_inactive = 0 AND a.is_inactive = 0";
		
		return $sql;
	}
	
	public static function endingBalance()
	{
		$sql = "SELECT COALESCE(SUM(dc.debit) - SUM(dc.credit), 0) AS ending_balance FROM
				(
					" . SqlViewGenerator::balance() . "
				) dc
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = dc.detail_account_id
				WHERE dc.account_id = :account_id AND dc.date <= :end_date AND dc.is_inactive = 0 AND a.is_inactive = 0";
		
		return $sql;
	}
        
        public static function beginningBalanceLedger()
	{
		$sql = "SELECT (SUM(ja.debit) - SUM(ja.credit)) AS beginning_balance FROM
				
					" . JournalAccounting::model()->tableName() . "
				 ja
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = ja.account_id
				WHERE a.id = :account_id AND ja.date < :start_date";
		
		return $sql;
	}
        
        public static function endBalanceLedger()
	{
		$sql = "SELECT (SUM(ja.debit) - SUM(ja.credit)) AS beginning_balance FROM
					" . JournalAccounting::model()->tableName() . "
				 ja
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = ja.account_id
				WHERE a.id = :account_id AND ja.date <= :end_date";
		
		return $sql;
	}
        
        public static function endDebitLedger()
	{
		$sql = "SELECT SUM(ja.debit) AS beginning_debit 
				FROM " . JournalAccounting::model()->tableName() . " ja
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = ja.account_id
				WHERE a.id = :account_id AND ja.date BETWEEN :start_date AND :end_date";
		
		return $sql;
	}
        
        public static function endCreditLedger()
	{
		$sql = "SELECT SUM(ja.credit) AS beginning_debit FROM
					" . JournalAccounting::model()->tableName() . "
				 ja
				INNER JOIN " . Account::model()->tableName() . " a ON a.id = ja.account_id
				WHERE a.id = :account_id AND ja.date BETWEEN :start_date AND :end_date";
		
		return $sql;
	}
        
        public static function profitLoss()
	{
		$sql = "SELECT sale.amount AS sale_amount, purchase.amount AS purchase_amount, beginning_stock.amount AS beginning_stock_amount, ending_stock.amount AS ending_stock_amount, 
				beginning_stock.amount + purchase.amount AS ready_stock, beginning_stock.amount + purchase.amount - ending_stock.amount AS cogs,
				sale.amount - beginning_stock.amount - purchase.amount + ending_stock.amount AS gross, 
				expense.amount AS expense_amount, other_income.amount AS other_income_amount, other_expense.amount AS other_expense_amount, 
				sale.amount - beginning_stock.amount - purchase.amount + ending_stock.amount - expense.amount - other_expense.amount + other_income.amount AS profit_loss 
				FROM
				(
					SELECT COALESCE(SUM(credit) - SUM(debit), 0) as amount 
					FROM ". JournalAccounting::model()->tableName() ." aj 
					INNER JOIN " . Account::model()->tableName() ." a ON a.id = aj.account_id 
					INNER JOIN ". AccountCategory::model()->tableName() ." ac ON ac.id = a.account_category_id 
					WHERE aj.date BETWEEN :start_date AND :end_date 
				) sale
				CROSS JOIN
				(
					SELECT COALESCE(SUM(debit) - SUM(credit), 0) as amount 
					FROM ". JournalAccounting::model()->tableName() ." aj 
					INNER JOIN " . Account::model()->tableName() ." a ON a.id = aj.account_id 
					INNER JOIN ". AccountCategory::model()->tableName() ." ac ON ac.id = a.account_category_id 
					WHERE aj.date BETWEEN :start_date AND :end_date 
				) purchase
				CROSS JOIN
				(
					SELECT COALESCE(SUM(credit) - SUM(debit), 0) as amount 
					FROM ". JournalAccounting::model()->tableName() ." aj 
					INNER JOIN " . Account::model()->tableName() ." a ON a.id = aj.account_id 
					INNER JOIN ". AccountCategory::model()->tableName() ." ac ON ac.id = a.account_category_id 
					WHERE aj.date BETWEEN :start_date AND :end_date 
				) expense
				CROSS JOIN
				(
					SELECT COALESCE(SUM(debit) - SUM(credit), 0) as amount 
					FROM ". JournalAccounting::model()->tableName() ." aj 
					INNER JOIN " . Account::model()->tableName() ." a ON a.id = aj.account_id 
					INNER JOIN ". AccountCategory::model()->tableName() ." ac ON ac.id = a.account_category_id 
					WHERE aj.date BETWEEN :start_date AND :end_date 
				) other_income
				CROSS JOIN
				(
					SELECT COALESCE(SUM(credit) - SUM(debit), 0) as amount 
					FROM ". JournalAccounting::model()->tableName() ." aj 
					INNER JOIN " . Account::model()->tableName() ." a ON a.id = aj.account_id 
					INNER JOIN ". AccountCategory::model()->tableName() ." ac ON ac.id = a.account_category_id 
					WHERE aj.date BETWEEN :start_date AND :end_date
				) other_expense
				CROSS JOIN
				(
					SELECT (purchase.total_quantity) * purchase.average AS amount FROM
					(
						SELECT SUM(d.quantity * d.unit_price ) / SUM(d.quantity) AS average, SUM(d.quantity) AS total_quantity
						FROM ". PurchaseHeader::model()->tableName() ." h
						INNER JOIN  ". PurchaseDetail::model()->tableName() ." d ON h.id = d.purchase_header_id
						WHERE h.date < :start_date 
					) purchase
					
				) beginning_stock
				CROSS JOIN
				(
					SELECT (purchase.total_quantity) * purchase.average AS amount FROM
					(
						SELECT SUM(d.quantity * d.unit_price ) / SUM(d.quantity) AS average, SUM(d.quantity) AS total_quantity
						FROM ". PurchaseHeader::model()->tableName() ." h
						INNER JOIN  ". PurchaseDetail::model()->tableName() ." d ON h.id = d.purchase_header_id
						WHERE h.date <= :end_date 
					) purchase
					
				) ending_stock";
		
		return $sql;
	}
        
}
