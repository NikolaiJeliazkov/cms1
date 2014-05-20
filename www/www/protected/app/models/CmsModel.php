<?php
class CmsModel extends CFormModel
{
	public $breadcrumbs=array();
	public $nodeData=false;

	public function getById($id) {
		return false;
	}

	public static function model($className=__CLASS__, $id=false, $scenario=false, $nodeData=false) {
// 		if (! ($className instanceof CmsModel)) {
// 			throw new CHttpException(500,'Invalid classname');
// 		}
		$model = new $className($scenario);
		$model->attachBehaviors($model->behaviors());
		$model->nodeData = $nodeData;
		if ($id) {
			if (false === $model->getById($id)) {
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $model;
	}

	public function getTitle() {
		return '';
	}

	public static function getdate($date, $fmt='d.m.Y H:i'){
		$strdate = strtotime($date);
		return  date($fmt, $strdate);
	}

}