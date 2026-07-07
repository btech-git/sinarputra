<?php

class PurchaseReturnHeader extends PurchaseReturnHeaderBase
{
	const CN_CONSTANT = 'PRET';
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	
	public function getGrandTotal()
	{
		$total = 0.00;
		
		foreach ($this->purchaseReturnDetails as $purchaseReturnDetail)
			$total += $purchaseReturnDetail->total;
		
		return $total;
	}
        
        public function getQuantityTotal()
	{
		$total = 0.00;
		
		foreach ($this->purchaseReturnDetails as $purchaseReturnDetail)
			$total += $purchaseReturnDetail->quantity;
		
		return $total;
	}
        
        public function searchWithPaging()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.cn_ordinal', $this->cn_ordinal);
		$criteria->compare('t.cn_month', $this->cn_month);
		$criteria->compare('t.cn_year', $this->cn_year);
		$criteria->compare('t.date', $this->date, true);
		$criteria->compare('t.note', $this->note, true);
		$criteria->compare('t.receive_header_id', $this->receive_header_id);
		$criteria->compare('t.admin_id', $this->admin_id);
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