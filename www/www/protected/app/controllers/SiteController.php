<?php

class SiteController extends CmsController
{
	public $defaultAction = 'index';
	public $metaKeywords;
	public $metaDescription;

	public function actionIndex($lang)
	{
		$m = CmsModel::model('SitemapNode',SiteMap::getRoot(),'view');
		$this->render('index', array('m'=>$m));
	}

	public function actionView($path=false)
	{
		$m = SiteMap::create($path);
		$this->render('view', array('m'=>$m, 'path'=>$path));
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

}