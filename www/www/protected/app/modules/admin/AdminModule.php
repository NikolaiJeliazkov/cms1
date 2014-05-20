<?php

class AdminModule extends CWebModule
{

	public $defaultController='pages';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',
						'actions'=>array('login'),
						'users'=>array('*'),
				),
				array('allow',
						'actions'=>array('index','admin','delete','create','update','view'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
				'admin.models.*',
				'admin.components.*',
		));
		Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'errorAction'=>'admin/default/error',
			),
			'user' => array(
				'class' => 'CWebUser',
				'loginUrl' => Yii::app()->createUrl('admin/default/login'),
			)
		));

	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
// 			Yii::app()->errorHandler->errorAction='admin/default/error';
			return true;
		}
		else
			return false;
	}
}
