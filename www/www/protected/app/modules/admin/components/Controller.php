<?php

class Controller extends CController
{
	public $layout='index';
	public $menu=array();
	public $breadcrumbs=array();
	public $metaKeywords='';
	public $metaDescription='';

	public function init() {
		parent::init();
		$app = Yii::app();
		if (isset($app->session['_lang'])) {
			$app->language = $app->session['_lang'];
		}
	}

}