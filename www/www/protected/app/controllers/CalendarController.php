<?php

class CalendarController extends CmsController
{
	public $defaultAction = 'index';
	public $metaKeywords;
	public $metaDescription;

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
				array('allow',  // allow all users to access 'index' and 'view' actions.
						'actions'=>array('index','view'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated users to access all actions
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	public function actionIndex($lang)
	{
		$m = new Calendar('index');
		$this->render('index', array('m'=>$m));
	}

	public function actionView($id=false)
	{
		$m = CmsModel::model('Calendar',$id,'view');
		$this->render('view', array('m'=>$m));
	}

}