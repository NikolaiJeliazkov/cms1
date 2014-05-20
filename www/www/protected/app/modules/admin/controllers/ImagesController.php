<?php

class ImagesController extends Controller
{
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index','upload','delete'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	public function actionIndex($folder='')
	{
		$files1 = scandir(realpath('./').'/images/'.$folder);
		$ret = array();
		foreach ($files1 as $f) {
			if ($f=='.' || $f=='..') continue;
			$pathinfo = pathinfo($f);
			if (!in_array(strtolower($pathinfo['extension']), array('jpg','jpeg','gif','png'))) continue;
			$ret[] = array('thumb'=>'/images/thumbs/'.$f, 'image'=>'/images/'.$f);
		}
		echo stripslashes(json_encode($ret));
		Yii::app()->end();
	}

	public function actionUpload()
	{
		$uploaddir = realpath('./').'/images/';
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			thumbnailsUtil::CreateThumb($uploadfile, $uploaddir.'/thumbs/'.$_FILES['file']['name'], 100, 100);
			$array = array(
					'filelink' => '/images/'.basename($_FILES['file']['name'])
			);
			echo stripslashes(json_encode($array));
		} else {
			echo "Possible file upload attack!\n";
		}

	}

}
