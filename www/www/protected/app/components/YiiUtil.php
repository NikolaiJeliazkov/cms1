<?php
/**
 * Yii Utilities Function
 *
 * @author Spiros Kabasakalis
 */
class YiiUtil {

	public static  function registerCssAndJs($folder, $jsfile, $cssfile) {

		$sourceFolder = YiiBase::getPathOfAlias($folder);
		$publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
		Yii::app()->clientScript->registerScriptFile($publishedFolder . $jsfile, CClientScript::POS_HEAD);
		Yii::app()->clientScript->registerCssFile($publishedFolder . $cssfile);
	}

	public static function registerCss($folder, $cssfile) {
		$sourceFolder = YiiBase::getPathOfAlias($folder);
		$publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
		Yii::app()->clientScript->registerCssFile($publishedFolder .'/'. $cssfile);
		return $publishedFolder .'/'. $cssfile;
	}

	public static function registerJs($folder, $jsfile) {
		$sourceFolder = YiiBase::getPathOfAlias($folder);
		$publishedFolder = Yii::app()->assetManager->publish($sourceFolder);
		Yii::app()->clientScript->registerScriptFile($publishedFolder .'/'.  $jsfile);
		return $publishedFolder .'/'. $jsfile;
	}

	public static function publishedImageUrl($folder, $path,$picBaseName,$ext) {
		$sourceFolder = YiiBase::getPathOfAlias($folder);
		$publishedFolder = Yii::app()->assetManager->publish($sourceFolder);

		return $publishedFolder .'/'. $path.'/'.$picBaseName .'.'.$ext;
	}

	public static  function appWebRoot(){
		return(substr( Yii::app()->baseUrl, 1, strlen(Yii::app()->baseUrl)-1));
	}

	public static  function fullURL(){
		return('http://'.$_SERVER['SERVER_NAME'].Yii::app()->request->url);
	}

	public static function d($var) {
		echo Yii::trace(CVarDumper::dumpAsString($var),'vardump');
	}
}


