<?php

class DeliveryHeader extends DeliveryHeaderBase {

    const CN_CONSTANT = 'DLV';
    const PENDING = 0;
    const DELIVERED = 1;
    const PENDING_LITERAL = 'Belum Terkirim';
    const DELIVERED_LITERAL = 'Terkirim';

    //custom attribute
    public $saleHeaderId;
    public $customerCompany;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDeliveryConfirmation() {
        return ($this->is_delivered) ? self::DELIVERED_LITERAL : self::PENDING_LITERAL;
    }

    public function getTotalQuantityByProduct($productId) {
        $totalQuantity = 0.00;

        foreach ($this->deliveryDetails(array('with' => array(
            'saleDetail' => array('with' => 'product')), 
            'condition' => 'product.id = :product_id', 
            'params' => array(':product_id' => $productId),
        )) as $deliveryDetail) {
            $totalQuantity += $deliveryDetail->quantity;
        }

        return $totalQuantity;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->deliveryDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->quantity;
            }
        }

        return $total;
    }

    public function getTotalWeight() {
        $total = 0.00;

        foreach ($this->deliveryDetails as $detail) {
            if ($detail->is_inactive == 0) {
                $total += $detail->weight;
            }
        }

        return $total;
    }

    public function getPackingMethod($delivery) {
        $total = self::getDeliveryQuantityTotal($delivery);

        $dus = 0;
        while ($total >= 12) {
            $total -= 12;
            $dus += 1;
        }

        return $dus . ' dus, ' . $total . ' pasang.';
    }

    public function getMemoTotal($flag) {
        $total = 0;
        switch ($flag) {
            case 1:
                foreach ($this->deliveryDetails as $detail) {
                    $total += $detail->height;
                }
                return $total;
                break;

            case 2:
                foreach ($this->deliveryDetails as $detail) {
                    $total += $detail->width;
                }
                return $total;
                break;

            case 3:
                foreach ($this->deliveryDetails as $detail) {
                    $total += $detail->length;
                }
                return $total;
                break;

            case 4:
                foreach ($this->deliveryDetails as $detail) {
                    $total += CHtml::value($detail, 'weight');
                }
                return $total;
                break;
            case 5:
                foreach ($this->deliveryDetails as $detail) {
                    $total += CHtml::value($detail, 'quantity');
                }
                return $total;
                break;
        }
    }

    public function getInvoiceNumber() {
        $saleInvoiceHeader = SaleInvoiceHeader::model()->findByAttributes(array('work_order_cutting_header_id' => $this->work_order_cutting_header_id));

        return empty($saleInvoiceHeader) ? '' : $saleInvoiceHeader->getCodeNumber(SaleInvoiceHeader::CN_CONSTANT);
    }

    public function searchWithPaging() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.cn_ordinal', $this->cn_ordinal);
        $criteria->compare('t.cn_month', $this->cn_month);
        $criteria->compare('t.cn_year', $this->cn_year);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.customer_address', $this->customer_address, true);
        $criteria->compare('t.customer_city', $this->customer_city, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.work_order_cutting_header_id', $this->work_order_cutting_header_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
        $criteria->compare('t.admin_id', $this->admin_id);
        $criteria->compare('t.is_sample', $this->is_sample);
        $criteria->compare('t.is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.id DESC',
            ),
        ));
    }
}
