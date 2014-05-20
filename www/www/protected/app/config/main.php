<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');
// $current_domain='cms1';

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'CMS1',
// 	'name'=>'Народно читалище "Разум 1883"',
	'language' => 'bg',
	'theme'=>'razum',

	'preload'=>array(
		'log',
		'bootstrap',
	),

	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.EGalleria.*',
		'editable.*',
	),
	'defaultController'=>'site',

// 	'request' => array(
// 			'class' => 'CHttpRequest',
// 			'enableCookieValidation' => true,
// 			'enableCsrfValidation' => !isset($_POST['dontvalidate']) ? true : false,
// 			'csrfCookie' => array( 'domain' => '.' . $current_domain )
// 	),

	'modules'=>array(
		'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'qwerty',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin',
	),

	'components'=>array(
		'widgetFactory'=>array(
			'widgets'=>array(
				'CLinkPager'=>array(
					'cssFile'=>false,
				),
			),
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('site/login'),
		),
		'urlManager'=>array(
			'class'=>'application.components.CmsUrlManager',
			'urlFormat'=>'path',
			'rules'=>array(
				'/'=>'site/index',
				'<lang:([a-z]{2})>/site/<path:(.+)>'=>'site/view',
				'<lang:([a-z]{2})>/<route:[\w\/]+>'=>'<route>',
				'<lang:([a-z]{2})>'=>'/',
			),
			'showScriptName'=>false,
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=icca_razum',
			'emulatePrepare' => true,
			'username' => 'icca_razum',
			'password' => 'qwerty',
			'charset' => 'utf8',
			'enableParamLogging'=>true,
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class'=>'CWebLogRoute',
					'showInFireBug'=>true,
					'levels'=>'trace',
					'categories'=>'vardump',//,system.db.CDbCommand',
				),
// 				array(
// 					'class'=>'CWebLogRoute',
// 					'levels'=>'trace,info,error,warning',
// 					'filter' => array(
// 						'class' => 'CLogFilter',
// 						'prefixSession' => true,
// 						'prefixUser' => false,
// 						'logUser' => false,
// 						'logVars' => array(),
// 					),
// 				),
			),
		),
		'bootstrap' => array(
				'class' => 'ext.bootstrap.components.Bootstrap',
// 				'responsiveCss' => true,
		),
		//X-editable config
		'editable' => array(
				'class'     => 'editable.EditableConfig',
				'form'      => 'bootstrap',        //form style: 'bootstrap', 'jqueryui', 'plain'
				'mode'      => 'inline',           //mode: 'popup' or 'inline'
				'defaults'  => array(              //default settings for all editable elements
						'emptytext' => 'Click to edit'
				)
		),
		'messages' => array(
				'class' => 'CDbMessageSource',
				'sourceMessageTable'     => 'sourcemessage',
				'translatedMessageTable' => 'message',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),

);