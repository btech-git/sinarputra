<?php

class MonthlyTransactionActiveRecord extends ActiveRecord
{
    public function getCodeNumber($cnConstant = '')
    {
        $arr = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
		$month = $this->cn_month ? $this->cn_month - 1 : 0;
        return sprintf('%04d/%s/%s/%02d', $this->cn_ordinal, $cnConstant, $arr[$month], $this->cn_year);
    }
	
    public function setCodeNumber($cnOrdinal, $cnMonth, $cnYear)
    {
		$this->cn_ordinal = $cnOrdinal;
        $this->cn_month = $cnMonth;
        $this->cn_year = $cnYear;
    }
	
    public function setCodeNumberByNext($currentMonth, $currentYear)
    {
        $ordinal = $this->cn_ordinal;
        if ($currentMonth > $this->cn_month || $currentYear > $this->cn_year) {
            $ordinal = 0;
        }
        
        $this->setCodeNumber($ordinal + 1, $currentMonth, $currentYear);
    }
    
    public function normalizeCnMonthBy($romanNum)
    {
        $arr = array_flip(array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'));

        if ($romanNum === '')
            $this->cn_month = '';
        else
        {
            $romanNum = strtoupper($romanNum);
            $this->cn_month = isset($arr[$romanNum]) ? $arr[$romanNum] + 1 : 0;
        }
    }
}