<?php

class SiteController extends CController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xEBF4FB,
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * Displays a login form to login a user.
	 */
	public function actionLogin()
	{
		$user=new LoginForm;
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$user->attributes=$_POST['LoginForm'];
			// validate user input and redirect to previous page if valid
			if($user->validate())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('user'=>$user));
	}

	/**
	 * Logout the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


  public function actionSaveMessages() {
    //$log =$this->saveMessages($_POST["msg"], $data->source_lang);
		////$this->redirect($this->createUrl('translate'));
    //echo $log;
  }


	public function actionTranslate() {
		$log ="";

		$data =$this->getActiveProjectData();

		if (isset($_POST["translate_save"])) {
      $target_lang =substr($_POST["sel_target_lang"], 0, 5);
			$log =$this->saveMessages($_POST["msg"], $data->source_lang, $target_lang);
			//$this->redirect($this->createUrl('translate'));
      echo "<pre>".$log."</pre>";
			die();
		}



		$lang_list =explode(",", $data->lang_list);
		foreach($lang_list as $key=>$lang) {
			$lang_code =trim($lang);
			$lang_list[$lang_code]=$lang_code;
			unset($lang_list[$key]);
		}

		$cs =Yii::app()->getClientScript();

		$js ="updateTranslateForm('".$data->path."', '".$data->source_lang."');";
		$cs->registerScript(get_class($this), $js);

    $cs->registerCoreScript('jquery');
		$cs->registerScriptFile(Yii::app()->baseUrl.'/js/form_translate.js');
    

    $prj_db->active=false;
		$this->render('translate', array('data'=>$data, 'lang_list'=>$lang_list, 'test'=>$log));
	}


	function getActiveProjectData() {
		$criteria = new CDbCriteria;
		$criteria->condition = "active=1";
		$data = Project::model()->find($criteria);

		return $data;
	}


	public function actionGetTranslateForm() {

		// this doesn't sounds very secure;
		// todo: perform some security check
		$project_path =$_POST["project_path"];
		$source_lang =substr($_POST["source_lang"], 0, 5);
		$sel_target_lang =substr($_POST["sel_target_lang"], 0, 5);

    $this->projectDbModelsSetup();    

		$translator='Yii::t';
		$fileTypes =array("php");
		$exclude =array("yii", "framework", ".svn");

		$options=array();
		if(isset($fileTypes))
			$options['fileTypes']=$fileTypes;
		if(isset($exclude))
			$options['exclude']=$exclude;
		$files=CFileHelper::findFiles(realpath($project_path),$options);

		$messages =array();
    $tr_msg =array();
		$log ="";
		$all_cat_msg_id_arr =array();
		foreach($files as $file) {
			$messages =array_merge_recursive($messages,$this->extractMessages($file,$translator, $log));
		}
		foreach($messages as $category=>$msgs) {
			$msgs =array_values(array_unique($msgs));
			$messages[$category]=$msgs;

      $cat_msg =$this->getSourceMessages($category);
      $cat_msg_id_arr =array_flip($cat_msg);
			$all_cat_msg_id_arr =$all_cat_msg_id_arr+$cat_msg_id_arr;
      $tr_msg[$category] =$this->getMessageTranslation($cat_msg_id_arr, $sel_target_lang);
		}

		asort($all_cat_msg_id_arr);

		$cs =Yii::app()->getClientScript();

		$res =array();
		$res["form"]=$this->renderPartial('gettranslateform',
			array('messages'=>$messages, 'source_lang'=>$source_lang,
			'sel_target_lang'=>$sel_target_lang, 'tr_msg'=>$tr_msg,
      'cat_msg_id_arr'=>$all_cat_msg_id_arr), true);


		//$res["log"]=var_export($all_cat_msg_id_arr, true).var_export($tr_msg, true)."--".$sel_target_lang;
		$res["log"]=$log;

		echo CJSON::encode($res);
	}


  function actionImport() {
    $this->render('import');
  }


  function actionExport() {
    $this->render('export');
  }


	protected function extractMessages($fileName,$translator, & $log)
	{

		$log.="Extracting messages from $fileName...\n";
		$subject=file_get_contents($fileName);
		$n=preg_match_all('/\b'.$translator.'\s*\(\s*(\'.*?(?<!\\\\)\'|".*?(?<!\\\\)")\s*,\s*(\'.*?(?<!\\\\)\'|".*?(?<!\\\\)")\s*[,\)]/',$subject,$matches,PREG_SET_ORDER);
		$messages=array();
		for($i=0;$i<$n;++$i)
		{
			$category=substr($matches[$i][1],1,-1);
			$message=$matches[$i][2];
			$messages[$category][]=eval("return $message;");  // use eval to eliminate quote escape;
		}
		return $messages;
	}


	protected function saveMessages($msg_arr, $source_lang, $target_lang) {
		$log ="";

    $prj_db =& $this->getActiveProjectDb();
    $this->projectDbModelsSetup();

    $tr_table =Message::model()->tableName();

		foreach($msg_arr as $category=>$items) {

      // 1 - collect messages already stored in current category (SourceMessage table)
      $cat_msg =$this->getSourceMessages($category);

      // 2 - collect messages translations (Message table)
      $cat_msg_id_arr =array_flip($cat_msg);
      $tr_msg =$this->getMessageTranslation($cat_msg_id_arr);


      foreach ($items as $msg) {

        // 3 - compare the current category messages with the items from input
        $src_msg =$msg[$source_lang];
        if (!in_array($src_msg, $cat_msg)) {
          $log.="ADD message [".$src_msg."] to SourceMessage table and retrive id.\n";
          $log.="[new] ";

          $sm_attr =array();
          $sm_attr["category"]=$category;
          $sm_attr["message"]=$src_msg;
          $source_message =new SourceMessage;
          $source_message->attributes =$sm_attr;
          $source_message->save();

          $cat_msg_id =$source_message->id;
        }
        else {
          $cat_msg_id =$cat_msg_id_arr[$src_msg];
        }
        $log.="message id: ".$cat_msg_id."\n";

        // Add or update source lang translation
        //$log.="[?] ".$cat_msg_id." - ".var_export($tr_msg[$source_lang], true)."\n";
        //// not sure this is needed: ----------------------------------------
        /* $translation =$msg[$source_lang];
        if (isset($tr_msg[$source_lang][$cat_msg_id])) {
          $log.="update translation for: ".$cat_msg_id." - ".$src_msg;
          $log.=": ".$translation." [".$source_lang."]\n";

          $qtxt ="UPDATE ".$tr_table." SET translation=:translation WHERE ";
          $qtxt.="id=:id AND language=:language";
          $cmd =$prj_db->createCommand($qtxt);
          $cmd->bindParam(":translation",$translation,PDO::PARAM_STR);
          $cmd->bindParam(":language",$source_lang,PDO::PARAM_STR);
          $cmd->bindParam(":id",$cat_msg_id,PDO::PARAM_INT);
          $cmd->execute();
        }
        else {
          $log.="adding translation for: ".$cat_msg_id." - ".$src_msg;
          $log.=": ".$src_msg." [".$source_lang."]\n";

          $tr_attr =array();
          $tr_attr["language"]=$source_lang;
          $tr_attr["translation"]=$translation;
          $tr_attr["id"]=(int)$cat_msg_id;
          $message =new Message;
          $message->setAttributes($tr_attr, NULL, false);
          //$log.=var_export($message->getAttributes(), true);
          $message->save();
        } // -------------------------------------------------------------- */


        // Add or update target lang translation
        //$log.="[?] ".$cat_msg_id." - ".var_export($tr_msg[$source_lang], true)."\n";
        $translation =$msg[$target_lang];
        if (isset($tr_msg[$target_lang][$cat_msg_id])) {
          $log.="update translation for: ".$cat_msg_id." - ".$src_msg;
          $log.=": ".$translation." [".$target_lang."]\n";

          $qtxt ="UPDATE ".$tr_table." SET translation=:translation WHERE ";
          $qtxt.="id=:id AND language=:language";
          $cmd =$prj_db->createCommand($qtxt);
          $cmd->bindParam(":translation",$translation,PDO::PARAM_STR);
          $cmd->bindParam(":language",$target_lang,PDO::PARAM_STR);
          $cmd->bindParam(":id",$cat_msg_id,PDO::PARAM_INT);
          $cmd->execute();
        }
        else if (!empty($translation)) {
          $log.="adding translation for: ".$cat_msg_id." - ".$src_msg;
          $log.=": ".$translation." [".$target_lang."]\n";

          $tr_attr =array();
          $tr_attr["id"]=$cat_msg_id;
          $tr_attr["language"]=$target_lang;
          $tr_attr["translation"]=$translation;
          $message =new Message;
          $message->setAttributes($tr_attr, NULL, false);
          $message->save();
        }

      }
		}

		$prj_db->active=false;  // close connection
    return $log;
	}


	protected function getActiveProjectDb() {

		$data =$this->getActiveProjectData();
		$config =include($data->path.'/protected/config/main.php');
		$db =$config["components"]["db"];

		$connection=new CDbConnection($db["connectionString"],$db["username"],$db["password"]);
		$connection->charset="utf8";
		$connection->active=true;

		return $connection;
	}


  // These functions should probably be moved inside a Message/SourceMessage controller:


  function projectDbModelsSetup() {

    $prj_db =& $this->getActiveProjectDb();

    // SourceMessage setup: it referrers to an external db.
    SourceMessage::setDbConnection($prj_db);
    // Message setup: it referrers to an external db.
    Message::setDbConnection($prj_db);

  }


  function getSourceMessages($category) {

    $src_table =SourceMessage::model()->tableName();
    $db_arr =SourceMessage::model()->findAll("category='".$category."'");
    $cat_msg =array();
    foreach($db_arr as $n=>$model) {
      $cat_msg[$model->id]=$model->message;
    }

    return $cat_msg;
  }


  function getMessageTranslation($cat_msg_id_arr, $sel_lang=FALSE) {
		$where ="";

		if (!empty($cat_msg_id_arr)) {
			$where.="id IN (".implode(",", $cat_msg_id_arr).")";
		}
		else {
			$where.="1";
		}
    if ($sel_lang !== FALSE) {
      $where.=" AND language='".$sel_lang."'";
    }

    $db_arr =Message::model()->findAll($where);
    $tr_msg =array();
    foreach($db_arr as $n=>$model) {
      $lang =$model->language;
      /*if (!isset($db_arr[$translation])) {
        $db_arr[$translation] =array();
      }*/
      $tr_msg[$lang][$model->id]=$model->translation;
    }

    return $tr_msg;
  }

}

