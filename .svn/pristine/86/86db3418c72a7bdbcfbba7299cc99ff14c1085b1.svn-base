<?php

class Item extends ItemBase
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchForPurchaseItem()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.code', $this->code, true);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.item_category_id', $this->item_category_id);
		$criteria->compare('t.unit_id', $this->unit_id);
		$criteria->compare('t.is_inactive', $this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                            'Pagination' => array (
                             'PageSize' => 50
                      ),
		));
	}
}