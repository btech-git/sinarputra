<?php

class ManufactureModule extends CWebModule
{
	public function init()
	{
		$this->setImport(array(
			'manufacture.models.*',
			'manufacture.components.*',
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
