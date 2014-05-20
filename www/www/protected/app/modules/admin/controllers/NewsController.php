<?php

class NewsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

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
				'actions'=>array('index','view','create','update','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout='pages';
		$article = new Articles('create');
		$article->LangId = Yii::app()->language;
		$article->ArticleCreateTime = new CDbExpression('NOW()');
		$article->ArticleAuthor = Yii::app()->user->id;
		$article->ArticleOptions = 2;
		$model=new Posts('create');
		$model->PostPubDate = date('Y-m-d');

		if (isset($_POST['Articles']) && isset($_POST['Posts']) ) {
			$article->attributes = $_POST['Articles'];
			if ($article->validate()) {
				$model->attributes = $_POST['Posts'];
				$model->image=CUploadedFile::getInstance($model,'image');
				$model->ArticleId = -1;
				if ($model->validate()) {
					$transaction=Yii::app()->db->beginTransaction();
					$result = $article->save(false);
					$model->ArticleId = $article->ArticleId;
					$result = $result && $model->save(false);
					if ($result) {
						$transaction->commit();
						$this->redirect(array('update','id'=>$model->PostId));
					}
					$transaction->rollback();
				}
			}
// 			Yii::trace(CVarDumper::dumpAsString($article),'vardump');
// 			Yii::trace(CVarDumper::dumpAsString($model),'vardump');
		}

		$this->render('create',array(
			'model'=>$model,
			'article'=>$article,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout='pages';
		$model=$this->loadModel($id);

		$model->image=CUploadedFile::getInstance($model,'image');
		if (isset($_POST['Posts'])) {
			$model->attributes = $_POST['Posts'];
			$model->save(true);
		}
		$article = $model->article;
		if (isset($_POST['Articles'])) {
			$_POST['Articles']['ArticleOptions'] = 2;
			$article->attributes = $_POST['Articles'];
			$article->save(true);
		}

		$this->render('update',array(
			'model'=>$model,
			'article'=>$article,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
// 		$dataProvider=new CActiveDataProvider('Posts');
		$dataProvider= Posts::model()->search();
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Languages the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Posts::model()->with('article')->findByPk($id);
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
