<?php

class ProjectController extends CController
{
	const PAGE_SIZE=10;

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * Specifies the action filters.
	 * This method overrides the parent implementation.
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				// 'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method overrides the parent implementation.
	 * It is only effective when 'accessControl' filter is enabled.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('deny',  // deny access to create, update, delete operations for guest users
						'actions'=>array('create','update','delete'),
						'users'=>array('?'),
				),
				array('allow', // allow access to admin operation for admin user
						'actions'=>array('admin'),
						'users'=>array('admin'),
				),
				array('deny',  // deny access to admin operation for all users
						'actions'=>array('admin'),
						'users'=>array('*'),
				),
		);
	}

	/**
	 * Shows a particular project.
	 */
	public function actionShow()
	{
		$this->render('show',array('project'=>$this->loadProject()));
	}

	/**
	 * Creates a new project.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		$project=new Project;
		if(isset($_POST['Project']))
		{

			if ($_POST['Project']['active']) {
				$qtxt ="UPDATE ".$project->tableName()." SET active=0";
				Yii::app()->db->createCommand($qtxt)->query();
			}

			$project->attributes=$_POST['Project'];
			if($project->save())
				$this->redirect(array('show','id'=>$project->id));
		}
		$this->render('create',array('project'=>$project));
	}

	/**
	 * Updates a particular project.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		$project=$this->loadProject();
		if(isset($_POST['Project']))
		{

			if ($_POST['Project']['active']) {
				$qtxt ="UPDATE ".$project->tableName()." SET active=0";
				Yii::app()->db->createCommand($qtxt)->query();
			}


			$project->setAttributes($_POST['Project']);
			if($project->save()) {
				Yii::app()->user->setFlash('success', "The project settings has been saved");
				$this->redirect(array('admin'));
			}
			//$this->redirect(array('show','id'=>$project->id));
		}
		$this->render('update',array('project'=>$project));
	}

	/**
	 * Deletes a particular project.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadProject()->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all projects.
	 */
	public function actionList()
	{
		$pages=$this->paginate(Project::model()->count(), self::PAGE_SIZE);
		$projectList=Project::model()->findAll($this->getListCriteria($pages));

		$this->render('list',array(
				'projectList'=>$projectList,
				'pages'=>$pages));
	}

	/**
	 * Manages all projects.
	 */
	public function actionAdmin()
	{
		$this->processAdminCommand();

		$pages=$this->paginate(Project::model()->count(), self::PAGE_SIZE);
		$projectList=Project::model()->findAll($this->getListCriteria($pages));

		$cs =Yii::app()->getClientScript();
		$js ="function refreshColumnActive() { alert('not fully implemented, please reload the page..'); }";
		$cs->registerScript(get_class($this), $js);

		$this->render('admin',array(
				'projectList'=>$projectList,
				'pages'=>$pages));
	}

	/**
	 * Loads the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	protected function loadProject()
	{
		if(isset($_GET['id']))
			$project=Project::model()->findbyPk($_GET['id']);
		if(isset($project))
			return $project;
		else
			throw new CHttpException(500,'The requested project does not exist.');
	}

	/**
	 * @param CPagination the pagination information
	 * @return CDbCriteria the query criteria for Project list.
	 * It includes the ORDER BY and LIMIT/OFFSET information.
	 */
	protected function getListCriteria($pages)
	{
		$criteria=new CDbCriteria;
		$columns=Project::model()->tableSchema->columns;
		if(isset($_GET['sort']) && isset($columns[$_GET['sort']]))
		{
			$criteria->order=$columns[$_GET['sort']]->rawName;
			if(isset($_GET['desc']))
				$criteria->order.=' DESC';
		}
		$criteria->limit=$pages->pageSize;
		$criteria->offset=$pages->currentPage*$pages->pageSize;
		return $criteria;
	}

	/**
	 * Generates the header cell for the specified column.
	 * This method will generate a hyperlink for the column.
	 * Clicking on the link will cause the data to be sorted according to the column.
	 * @param string the column name
	 * @return string the generated header cell content
	 */
	protected function generateColumnHeader($column)
	{
		$params=$_GET;
		if(isset($params['sort']) && $params['sort']===$column)
		{
			if(isset($params['desc']))
				unset($params['desc']);
			else
				$params['desc']=1;
		}
		else
		{
			$params['sort']=$column;
			unset($params['desc']);
		}
		$url=$this->createUrl('list',$params);
		return CHtml::link(Project::model()->getAttributeLabel($column),$url);
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			/* if(Yii::app()->user->isGuest)
				Yii::app()->user->loginRequired(); */

			if(($project=Project::model()->findbyPk($_POST['id']))!==null)
			{
				$project->delete();
				// reload the current page to avoid duplicated delete actions
				$this->refresh();
			}
			else
				throw new CHttpException(500,'The requested project does not exist.');
		}
	}


	public function actionSetactive() {
		$id =(int)$_GET["id"];
		$table =Project::model()->tableName();

		$qtxt ="UPDATE ".$table." SET active=0";
		Yii::app()->db->createCommand($qtxt)->query();

		$qtxt ="UPDATE ".$table." SET active=1 ";
		$qtxt.="WHERE id=".$id;
		Yii::app()->db->createCommand($qtxt)->query();
	}
}
