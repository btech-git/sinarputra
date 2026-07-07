<?php

class SqlViewGenerator extends CComponent {

    public static function count($view) {
        $sql = "SELECT COUNT(*) FROM ({$view}) v";

        return $sql;
    }

    public static function purchaseQuantityRemaining() {
        $sql = "SELECT p.quantity - COALESCE(receive.quantity, 0) AS quantity_purchased, p.id AS purchase_detail_id
                FROM " . PurchaseDetail::model()->tableName() . " p
                LEFT OUTER JOIN (
                    SELECT purchase_detail_id, COUNT(purchase_detail_id) AS quantity
                    FROM " . ReceiveDetail::model()->tableName() . "
                    WHERE is_inactive = 0
                    GROUP BY purchase_detail_id
                ) receive
                ON p.id = receive.purchase_detail_id";

        return $sql;
    }

    public static function purchaseItemQuantityRemaining() {
        $sql = "SELECT p.quantity - COALESCE(receiveItem.quantity, 0) AS quantity_purchased, p.id AS purchase_item_detail_id
				FROM " . PurchaseItemDetail::model()->tableName() . " p
				LEFT OUTER JOIN
				(
					SELECT purchase_item_detail_id, SUM(quantity) AS quantity
					FROM " . ReceiveItemDetail::model()->tableName() . "
					GROUP BY purchase_item_detail_id
				) receiveItem
				ON p.id = receiveItem.purchase_item_detail_id";

        return $sql;
    }

    public static function saleQuantityRemaining() {
        $sql = "SELECT s.quantity - COALESCE(delivery.quantity, 0) AS quantity_sold, s.id AS sale_detail_id
				FROM " . SaleDetail::model()->tableName() . " s
				LEFT OUTER JOIN
				(
					SELECT sale_detail_id, SUM(quantity) AS quantity
					FROM " . DeliveryDetail::model()->tableName() . "
					GROUP BY sale_detail_id
				) delivery
				ON s.id = delivery.sale_detail_id";

        return $sql;
    }

    public static function localStock() {
        $sql = "SELECT COALESCE(SUM(quantity_in) - SUM(quantity_out), 0) 
				FROM " . Inventory::model()->tableName() . " 
				WHERE product_id = :product_id AND warehouse_id = :warehouse_id";

        return $sql;
    }

    public static function balance() {
        $sql = "SELECT h.date, h.account_id, d.account_id AS detail_account_id, d.amount AS debit, 0 AS credit, d.memo AS note, d.is_inactive
				FROM " . DepositHeader::model()->tableName() . " h 
				INNER JOIN " . DepositDetail::model()->tableName() . " d ON h.id = d.deposit_header_id
				WHERE h.account_id = :account_id AND h.is_inactive = 0 AND d.is_inactive = 0
				UNION ALL
				SELECT h.date, h.account_id, d.account_id AS detail_account_id, 0 AS debit, d.amount AS credit, d.memo AS note, d.is_inactive
				FROM " . ExpenseHeader::model()->tableName() . " h 
				INNER JOIN " . ExpenseDetail::model()->tableName() . " d ON h.id = d.expense_header_id
				WHERE h.account_id = :account_id AND h.is_inactive = 0 AND d.is_inactive = 0
				UNION ALL
				SELECT h.date, d.account_id, h.account_id AS detail_account_id, 0 AS debit, d.amount AS credit, d.memo AS note, d.is_inactive
				FROM " . DepositHeader::model()->tableName() . " h 
				INNER JOIN " . DepositDetail::model()->tableName() . " d ON h.id = d.deposit_header_id
				WHERE d.account_id = :account_id AND h.is_inactive = 0 AND d.is_inactive = 0
				UNION ALL
				SELECT h.date, d.account_id, h.account_id AS detail_account_id, d.amount AS debit, 0 AS credit, d.memo AS note, d.is_inactive
				FROM " . ExpenseHeader::model()->tableName() . " h 
				INNER JOIN " . ExpenseDetail::model()->tableName() . " d ON h.id = d.expense_header_id
				WHERE d.account_id = :account_id AND h.is_inactive = 0 AND d.is_inactive = 0
				UNION ALL
				SELECT h.date, d.account_id, d.account_id AS detail_account_id, d.debit AS debit, d.credit AS credit, d.memo AS note, d.is_inactive
				FROM " . JournalVoucherHeader::model()->tableName() . " h 
				INNER JOIN " . JournalVoucherDetail::model()->tableName() . " d ON h.id = d.journal_voucher_header_id
				WHERE d.account_id = :account_id AND h.is_inactive = 0 AND d.is_inactive = 0";

        return $sql;
    }

    public static function workOrderQuantityRemaining() {
        $sql = "SELECT s.quantity_request - COALESCE(delivery.quantity, 0) AS quantity_delivered, s.id AS quoation_detail_product_id
				FROM " . QuotationDetailProduct::model()->tableName() . " s
				LEFT OUTER JOIN
				(
					SELECT work_order_cutting_detail_product_id, sd.quotation_detail_product_id as quotationDetailProductId, SUM(dp.quantity) AS quantity
					FROM " . DeliveryPartialDetail::model()->tableName() . " dp
                    JOIN  " . WorkOrderCuttingDetailProduct::model()->tableName() . " wo  
                    JOIN  " . SaleDetailProduct::model()->tableName() . " sd  
					GROUP BY work_order_cutting_detail_product_id
				) delivery
				ON s.id = deliveryPartial.quotationDetailProductId";

        return $sql;
    }

    public static function customerMonthlySales() {
        $sql = "SELECT h.customer_id, c.code AS customer_code, c.company AS customer_company, SUBSTRING(h.date, 1, 4) AS year, SUBSTRING(h.date, 6, 2) AS month, SUM(h.grand_total) AS grand_total
				FROM " . SaleInvoiceHeader::model()->tableName() . " h
				INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
				WHERE h.is_inactive = 0 AND (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(h.date, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(h.date, 6, 2)) <= 12
				GROUP BY h.customer_id, SUBSTRING(h.date, 1, 4), SUBSTRING(h.date, 6, 2)
				ORDER BY h.customer_id, year, month";

        return $sql;
    }

    public static function receivableMonthly() {
        $sql = "SELECT h.customer_id, c.code AS customer_code, c.company AS customer_company, SUBSTRING(h.date, 1, 4) AS year, SUBSTRING(h.date, 6, 2) AS month, SUM(h.grand_total - h.total_payment - h.total_return) AS remaining
				FROM " . SaleInvoiceHeader::model()->tableName() . " h
				INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
				WHERE h.is_inactive = 0 AND (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(h.date, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(h.date, 6, 2)) <= 12
				GROUP BY h.customer_id, SUBSTRING(h.date, 1, 4), SUBSTRING(h.date, 6, 2)
				ORDER BY h.customer_id, year, month";

        return $sql;
    }

    public static function salesmanMonthlySales() {
        $sql = "SELECT h.employee_id_salesman, e.name AS employee_name, SUBSTRING(h.date, 1, 4) AS year, SUBSTRING(h.date, 6, 2) AS month, SUM(h.grand_total) AS grand_total
				FROM " . SaleInvoiceHeader::model()->tableName() . " h
				INNER JOIN " . Employee::model()->tableName() . " e ON e.id = h.employee_id_salesman
				WHERE h.is_inactive = 0 AND (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(h.date, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(h.date, 6, 2)) <= 12
				GROUP BY h.employee_id_salesman, SUBSTRING(h.date, 1, 4), SUBSTRING(h.date, 6, 2)
				ORDER BY h.employee_id_salesman, year, month";

        return $sql;
    }

    public static function materialMonthlySales() {
        $sql = "SELECT d.grade_name AS grade_name, SUBSTRING(h.date, 1, 4) AS year, SUBSTRING(h.date, 6, 2) AS month, SUM(d.weight * d.unit_price) AS grand_total
				FROM " . SaleInvoiceHeader::model()->tableName() . " h
				INNER JOIN " . SaleInvoiceDetail::model()->tableName() . " d ON h.id = d.sale_invoice_header_id
				WHERE h.is_inactive = 0 AND d.is_inactive = 0 AND (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(h.date, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(h.date, 6, 2)) <= 12
				GROUP BY d.grade_name, SUBSTRING(h.date, 1, 4), SUBSTRING(h.date, 6, 2)
				ORDER BY d.grade_name, year, month";

        return $sql;
    }

    public static function materialMonthlySalesWeight() {
        $sql = "SELECT d.grade_name AS grade_name, SUBSTRING(h.date, 1, 4) AS year, SUBSTRING(h.date, 6, 2) AS month, SUM(d.weight) AS grand_total
				FROM " . SaleInvoiceHeader::model()->tableName() . " h
				INNER JOIN " . SaleInvoiceDetail::model()->tableName() . " d ON h.id = d.sale_invoice_header_id
				WHERE h.is_inactive = 0 AND d.is_inactive = 0 AND (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(h.date, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(h.date, 6, 2)) <= 12
				GROUP BY d.grade_name, SUBSTRING(h.date, 1, 4), SUBSTRING(h.date, 6, 2)
				ORDER BY d.grade_name, year, month";

        return $sql;
    }

}
