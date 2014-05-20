<?php

class GalleriesController extends Controller
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
			'postOnly + imageDelete', // we only allow deletion via POST request
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
			array('allow',
				'actions'=>array('index','reorder','create','update','delete','imageUpdate','imageDelete','imagesReorder'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actions() {
		return array(
				'reorder' => array(
						'class' => 'bootstrap.actions.TbSortableAction',
						'modelName' => 'Galleries'
				),
				'imagesReorder' => array(
						'class' => 'bootstrap.actions.TbSortableAction',
						'modelName' => 'Images'
				)
		);
	}

	public function actionCreate()
	{
		$this->layout='pages';
		$article = new Articles('create');
		$article->LangId = Yii::app()->language;
		$article->ArticleCreateTime = new CDbExpression('NOW()');
		$article->ArticleAuthor = Yii::app()->user->id;
		$article->ArticleActivated = 0;
		$article->ArticleOptions = 2;
		$article->ArticleContent = 'gallery';
		$model=new Galleries('create');
// 		$dp = $model->search();
// 		$data = $dp->getData();
// 		$a = $data[0]->GalleryOrder + 1;
		$model->GalleryOrder = $model->search()->data[0]->GalleryOrder + 1;
		$model->ArticleId = -1;

		if (isset($_POST['Articles']) ) { //&& isset($_POST['Galleries']) ) {
			$article->attributes = $_POST['Articles'];
			if ($article->validate()) {
				if ($model->validate()) {
					$transaction=Yii::app()->db->beginTransaction();
					$result = $article->save(false);
					$model->ArticleId = $article->ArticleId;
					$result = $result && $model->save(false);
					if ($result) {
						$transaction->commit();
						$this->redirect(array('update','id'=>$model->GalleryId));
					}
					$transaction->rollback();
				}
			}
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
		$article = $model->article;
		if (isset($_POST['Articles'])) {
			$_POST['Articles']['ArticleOptions'] = 2;
			$article->attributes = $_POST['Articles'];
			$article->ArticleModifyTime = new CDbExpression('NOW()');
			$article->ArticleContent = 'gallery';
			$article->save(true);
		}
		if (isset($_POST['Images'])) {
			$image = new Images();
			$image->GalleryId = $model->GalleryId;
			$imageOrder = $image->search()->data[0]->ImageOrder + 1;
			$image->ImageOrder = $imageOrder;
			$image->attributes = $_POST['Images'];
			$image->image=CUploadedFile::getInstance($image,'image');
			Yii::trace(CVarDumper::dumpAsString($image->image),'vardump');
			Yii::trace(CVarDumper::dumpAsString($image->attributes),'vardump');
			$res = $image->save(true);
			Yii::trace(CVarDumper::dumpAsString($image->attributes),'vardump');
			Yii::trace(CVarDumper::dumpAsString($image),'vardump');
			$this->redirect(array('update','id'=>$model->GalleryId));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider= Galleries::model()->search();
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionImageUpdate()
	{
		if(isset($_POST['name']) && $_POST['name']=='ImageDescription')
		{
			$image=Images::model()->findByPk($_POST['pk']);
			$image->ImageDescription = $_POST['value'];
			$image->save();
// 			echo CActiveForm::validate($image);
			Yii::app()->end();
		}

	}

	public function actionImageDelete($id)
	{
		Images::model()->findByPk($id)->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Galleries the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Galleries::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Galleries $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='galleries-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
