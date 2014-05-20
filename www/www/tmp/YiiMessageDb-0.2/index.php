<?php

/* ------------------------------------------------------------
    Copyright 2009 - Giovanni Derks
    http://www.dotmill.it/dev

    Released under the terms of the BSD License.
    IDE: jEdit / Netbeans with tab size = 2
-------------------------------------------------------------*/



// change the following paths if necessary
// $yii='/change/me/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

$yii=dirname(__FILE__).'/../../protected/framework/yii.php';
// $config=dirname(__FILE__).'/../../protected/app/config/main.php';


// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
