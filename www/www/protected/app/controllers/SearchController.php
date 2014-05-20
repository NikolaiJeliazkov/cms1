<?php

class SearchController extends CmsController
{
	public $defaultAction = 'index';
	public $metaKeywords;
	public $metaDescription;

	public function actionIndex($lang)
	{
		print_r(Yii::app()->request->getParam('tag',''));
		print_r(Yii::app()->request->getParam('s','sss'));
		Yii::app()->end();
	}


}