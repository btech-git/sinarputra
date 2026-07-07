<?php

class AccountingModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'accounting.models.*',
			'accounting.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
			return true;
		else
			return false;
	}
}
