<?php

class CmsController extends CController
{
	public $layout='//layouts/column1';
	public $menu=array();
	public $breadcrumbs=array();
	public $metaKeywords='';
	public $metaDescription='';

	public function beforeAction($action)
	{
		$languages = Languages::all();
		Yii::app()->language = Yii::app()->request->getQuery('lang', $languages[0]);
		return parent::beforeAction($action);
	}

	public function __construct($id,$module=null){
		self::checkLang();
		parent::__construct($id,$module);
	}

	public static function checkLang()
	{
		$languages = Languages::all(); //array('bg');
		$path = explode('/', trim(Yii::app()->request->getPathInfo(),'/'));
		if($path[0]=="" || !in_array($path[0],$languages)) {
			$langs = array();
			if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
				// break up string into pieces (languages and q factors)
				preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
				if (count($lang_parse[1])) {
					// create a list like "en" => 0.8
					$langs = array_combine($lang_parse[1], $lang_parse[4]);
					// set default to 1 for any without q factor
					foreach ($langs as $lang => $val) {
						if ($val === '') $langs[$lang] = 1;
					}
					// sort list based on value
					arsort($langs, SORT_NUMERIC);
				}
			}
			foreach ($langs as $lang => $val) {
				foreach ($languages as $sLang) {
					if (strpos($lang, $sLang) === 0) {
						Yii::app()->request->redirect('/'.$sLang);
					}
				}
			}
			reset($languages);
			Yii::app()->request->redirect('/'.current($languages));
		}
		Yii::app()->language = $path[0];
	}
}