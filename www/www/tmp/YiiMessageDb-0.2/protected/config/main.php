<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Yii Message Db',

		// autoloading model and component classes
		'import'=>array(
				'application.models.*',
				'application.components.*',
		),

		// application components
		'components'=>array(
				'user'=>array(
						// enable cookie-based authentication
						'allowAutoLogin'=>true,
				),
				'db'=>array(
						'connectionString' => 'mysql:host=localhost;dbname=icca_razum',
						'emulatePrepare' => true,
						'username' => 'icca_razum',
						'password' => 'qwerty',
						'charset' => 'utf8',
						'enableParamLogging'=>true,
				),
		),
);