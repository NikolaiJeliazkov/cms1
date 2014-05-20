<?php
class CmsUrlManager extends CUrlManager
{
	public function createUrl($route,$params=array(),$ampersand='&') {
		if (in_array(Yii::app()->controller->module->id,array('admin','gii'))) {

		} else {
			$route = '/'.Yii::app()->getLanguage().'/'.$route;
		}
		unset($params['lang']);
		$res = parent::createUrl($route, $params, $ampersand);
		return $res;
	}

// 	public function parseUrl($request) {
// 		$_GET['lang'] = Yii::app()->getLanguage();
// 		$res = parent::parseUrl($request);
// 		Yii::trace(CVarDumper::dumpAsString($res),'vardump');
// 		return $res;
// 	}

}