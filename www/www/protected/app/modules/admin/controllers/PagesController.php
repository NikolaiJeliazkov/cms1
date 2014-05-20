<?php

class PagesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

// 	public function actions() {
// 		return array(
// 				'reorder' => array(
// 						'class' => 'bootstrap.actions.TbSortableAction',
// 						'modelName' => 'SiteMap'
// 				));
// 	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','delete','reorder'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$id = SiteMap::getRoot();
		$this->actionView($id);
	}

	public function actionView($id)
	{
		$this->layout='pages';
		$model = $this->loadModel($id);
		if ($model->ModuleName!='site') {
			$this->redirect('/admin/'.$model->ModuleName);
		}
		$article = Articles::model()->findByPk($model->ModuleData);
		if (isset($_POST['SiteMap'])) {
			$model->attributes = $_POST['SiteMap'];
			$model->save(true);
		}
		if (isset($_POST['Articles'])) {
			$article->attributes = $_POST['Articles'];
			$article->save(true);
		}


		$this->render('view',array(
				'model'=>$this->loadModel($id),
				'article'=>$article,
		));
	}

	public function actionReorder($id)
	{
		$c = SiteMap::getChildren($id,false,true);
		$a = array();
		foreach ($c as $row) {
			$a[$row['id']] = $row['pos'];
		}
// 		throw new CHttpException(500,CVarDumper::dumpAsString($a));
		foreach ($_POST['sortOrder'] as $oldId=>$newId) {
			$OldModel=SiteMap::model()->findByPk($oldId);
			$OldModel->pos = $a[$newId];
			$OldModel->save(false);
		}
		Yii::app()->end();
	}

	public function actionCreate($parent)
	{
		$model = SiteMap::createNew($parent,false,false,null,'site',null);
		$article = Articles::createNew($model->LangId,$model->url,null,null,null,null,null,Yii::app()->user->id,0,7,null,null);
		$model->ModuleData = $article->ArticleId;
		$model->save(false);
// 		Yii::trace(CVarDumper::dumpAsString($model->attributes),'vardump');
		$this->redirect(array('/admin/pages/view','id'=>$model->id));
	}

	public function actionDelete($id)
	{
		try {
			$model=SiteMap::model()->findByPk($id);
			if ($model->ModuleName!='site') {
				throw new CHttpException(500,'Записът не може да бъде изтрит.');
			}
			$model->delete();
		}
		catch (CDbException $e) {
			if ($e->errorInfo[0]=='23000') {
				throw new CHttpException(500,'Записът не може да бъде изтрит поради наличието на вложени записи.');
			}
			throw new CHttpException(500,CVarDumper::dumpAsString($e));
		}
		catch (CHttpException $e) {
			throw $e;
		}
		catch (Exception $e) {
			throw new CHttpException(500,CVarDumper::dumpAsString($e));
		}
	}

	public function loadModel($id)
	{
		$model=SiteMap::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Languages $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='languages-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
